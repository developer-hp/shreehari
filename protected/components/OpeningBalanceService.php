<?php

/**
 * Service to update Account Opening Balance from a customer's current closing balance,
 * then soft-delete all issue entries for that customer (period close).
 */
class OpeningBalanceService
{
	/**
	 * Update opening balance from current closing and soft-delete all issue entries.
	 * Closing = net of existing opening + all issue entries (DR - CR).
	 * 1) Sets opening balance = closing (create/update AccountOpeningBalance).
	 * 2) Soft-deletes all issue entries for this customer (is_deleted = 1).
	 * 3) Refreshes customer closing fields.
	 *
	 * @param int $customerId Customer ID
	 * @return AccountOpeningBalance|null The saved opening balance model, or null on failure
	 */
	public static function updateOpeningFromClosing($customerId)
	{
		$customerId = (int) $customerId;
		if ($customerId <= 0)
			return null;

		$closing = Customer::getClosingBalance($customerId);
		$wt = (float) $closing['wt'];
		$amt = (float) $closing['amount'];

		$opening = AccountOpeningBalance::model()->findByAttributes(
			array('customer_id' => $customerId, 'is_deleted' => 0)
		);
		if (!$opening) {
			$opening = new AccountOpeningBalance();
			$opening->customer_id = $customerId;
		}

		// Store as absolute value + DR/CR: positive closing = DR, negative = CR
		$opening->opening_fine_wt = abs($wt);
		$opening->opening_fine_wt_drcr = $wt >= 0 ? AccountOpeningBalance::DRCR_DEBIT : AccountOpeningBalance::DRCR_CREDIT;
		$opening->opening_amount = abs($amt);
		$opening->opening_amount_drcr = $amt >= 0 ? AccountOpeningBalance::DRCR_DEBIT : AccountOpeningBalance::DRCR_CREDIT;

		if (!$opening->save(false))
			return null;

		// Soft-delete all issue entries for this customer
		IssueEntry::model()->updateAll(
			array('is_deleted' => 1),
			'customer_id = :cid AND is_deleted = 0',
			array(':cid' => $customerId)
		);

		// Recompute customer closing (now equals opening only)
		Customer::updateClosingBalance($customerId);

		return $opening;
	}

	/**
	 * Update opening from closing for multiple customers.
	 *
	 * @param array $customerIds Array of customer IDs
	 * @return array ['updated' => int, 'errors' => array(customer_id => message)]
	 */
	public static function updateOpeningFromClosingBatch(array $customerIds)
	{
		$updated = 0;
		$errors = array();
		foreach ($customerIds as $cid) {
			$cid = (int) $cid;
			if ($cid <= 0) continue;
			try {
				$model = self::updateOpeningFromClosing($cid);
				if ($model !== null)
					$updated++;
				else
					$errors[$cid] = 'Save failed';
			} catch (Exception $e) {
				$errors[$cid] = $e->getMessage();
			}
		}
		return array('updated' => $updated, 'errors' => $errors);
	}
}
