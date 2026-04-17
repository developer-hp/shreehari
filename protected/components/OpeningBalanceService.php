<?php

/**
 * Service to update Account Opening Balance from a customer's closing balance
 * as of a selected date, then soft-delete issue entries up to that date.
 */
class OpeningBalanceService
{
	/**
	 * Update opening balance from closing as of a cutoff date and soft-delete
	 * issue entries up to that date.
	 * Closing = net of existing opening + eligible issue entries (DR - CR).
	 * 1) Sets opening balance = closing (create/update AccountOpeningBalance).
	 * 2) Soft-deletes issue entries for this customer up to cutoff date.
	 * 3) Refreshes customer closing fields.
	 *
	 * @param int $customerId Customer ID
	 * @param string|null $cutoffDate Date in Y-m-d or parseable format
	 * @return AccountOpeningBalance|null The saved opening balance model, or null on failure
	 */
	public static function updateOpeningFromClosing($customerId, $cutoffDate = null)
	{
		$customerId = (int) $customerId;
		if ($customerId <= 0) {
			return null;
		}

		$normalizedCutoffDate = self::normalizeCutoffDate($cutoffDate);
		if ($normalizedCutoffDate === null) {
			return null;
		}

		$db = Yii::app()->db;
		$tx = $db->beginTransaction();

		try {
			$closing = self::getClosingBalanceAsOfDate($customerId, $normalizedCutoffDate);
			$wt = (float) $closing['wt'];
			$amt = (float) $closing['amount'];

			$opening = AccountOpeningBalance::model()->findByAttributes(
				array('customer_id' => $customerId, 'is_deleted' => 0)
			);
			if (!$opening) {
				$opening = new AccountOpeningBalance();
				$opening->customer_id = $customerId;
			}

			$opening->opening_fine_wt = abs($wt);
			$opening->opening_fine_wt_drcr = $wt >= 0 ? AccountOpeningBalance::DRCR_DEBIT : AccountOpeningBalance::DRCR_CREDIT;
			$opening->opening_amount = abs($amt);
			$opening->opening_amount_drcr = $amt >= 0 ? AccountOpeningBalance::DRCR_DEBIT : AccountOpeningBalance::DRCR_CREDIT;
			$opening->created_at = $normalizedCutoffDate . ' 00:00:00';
			if ($opening->isNewRecord && Yii::app()->user->id) {
				$opening->created_by = (int) Yii::app()->user->id;
			}

			if (!$opening->save(false)) {
				throw new CException('Failed to save opening balance.');
			}

			$issueEntries = IssueEntry::model()->findAll(array(
				'condition' => 'customer_id = :cid AND is_deleted = 0 AND issue_date <= :cutoff',
				'params' => array(':cid' => $customerId, ':cutoff' => $normalizedCutoffDate),
			));
			$issueEntryIds = array();
			foreach ($issueEntries as $entry) {
				$issueEntryIds[] = (int) $entry->id;
			}

			IssueEntry::model()->updateAll(
				array('is_deleted' => 1),
				'customer_id = :cid AND is_deleted = 0 AND issue_date <= :cutoff',
				array(':cid' => $customerId, ':cutoff' => $normalizedCutoffDate)
			);

			if (!empty($issueEntryIds)) {
				$placeholders = implode(',', $issueEntryIds);
				SupplierLedgerTxn::model()->updateAll(
					array('is_locked' => 1),
					'issue_entry_id IN (' . $placeholders . ') AND is_deleted = 0',
					array()
				);
				KarigarJamaVoucher::model()->updateAll(
					array('is_locked' => 1),
					'issue_entry_id IN (' . $placeholders . ') AND is_deleted = 0',
					array()
				);
				DiamondVoucher::model()->updateAll(
					array('is_locked' => 1),
					'issue_entry_id IN (' . $placeholders . ') AND is_deleted = 0',
					array()
				);
			}

			Customer::updateClosingBalance($customerId);
			$tx->commit();

			return $opening;
		} catch (Exception $e) {
			if ($tx->getActive()) {
				$tx->rollback();
			}
			Yii::log($e->getMessage(), CLogger::LEVEL_ERROR, 'application.openingBalance');
			return null;
		}
	}

	protected static function normalizeCutoffDate($cutoffDate)
	{
		$cutoffDate = trim((string) $cutoffDate);
		if ($cutoffDate === '') {
			return null;
		}

		$ts = strtotime($cutoffDate);
		if ($ts === false) {
			return null;
		}

		return date('Y-m-d', $ts);
	}

	protected static function getClosingBalanceAsOfDate($customerId, $cutoffDate)
	{
		$totalFineDr = $totalFineCr = $totalAmtDr = $totalAmtCr = 0.0;
		$opening = AccountOpeningBalance::model()->findByAttributes(
			array('customer_id' => (int) $customerId, 'is_deleted' => 0)
		);
		if ($opening) {
			$fw = (float) $opening->opening_fine_wt;
			$am = (float) $opening->opening_amount;
			if ((int) $opening->opening_fine_wt_drcr === AccountOpeningBalance::DRCR_DEBIT) {
				$totalFineDr += $fw;
			} else {
				$totalFineCr += $fw;
			}
			if ((int) $opening->opening_amount_drcr === AccountOpeningBalance::DRCR_DEBIT) {
				$totalAmtDr += $am;
			} else {
				$totalAmtCr += $am;
			}
		}

		$issues = IssueEntry::model()->findAll(array(
			'condition' => 'customer_id = :cid AND is_deleted = 0 AND issue_date <= :cutoff',
			'params' => array(':cid' => (int) $customerId, ':cutoff' => $cutoffDate),
		));
		foreach ($issues as $iss) {
			$fw = (float) $iss->fine_wt;
			$am = (float) $iss->amount;
			if ((int) $iss->drcr === IssueEntry::DRCR_DEBIT) {
				$totalFineDr += $fw;
				$totalAmtDr += $am;
			} else {
				$totalFineCr += $fw;
				$totalAmtCr += $am;
			}
		}

		return array(
			'wt' => $totalFineDr - $totalFineCr,
			'amount' => $totalAmtDr - $totalAmtCr,
		);
	}

	/**
	 * Update opening from closing for multiple customers.
	 *
	 * @param array $customerIds Array of customer IDs
	 * @param string|null $cutoffDate Date in Y-m-d or parseable format
	 * @return array ['updated' => int, 'errors' => array(customer_id => message)]
	 */
	public static function updateOpeningFromClosingBatch(array $customerIds, $cutoffDate = null)
	{
		$updated = 0;
		$errors = array();
		foreach ($customerIds as $cid) {
			$cid = (int) $cid;
			if ($cid <= 0) {
				continue;
			}
			try {
				$model = self::updateOpeningFromClosing($cid, $cutoffDate);
				if ($model !== null) {
					$updated++;
				} else {
					$errors[$cid] = 'Save failed';
				}
			} catch (Exception $e) {
				$errors[$cid] = $e->getMessage();
			}
		}
		return array('updated' => $updated, 'errors' => $errors);
	}
}
