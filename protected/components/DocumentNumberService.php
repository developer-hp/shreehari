<?php

/**
 * Central SR No generator backed by cp_document_sequence.
 *
 * Uses a transaction + row lock to allocate the next number atomically.
 * Format: <PREFIX><6-digit>, e.g. SUP000001
 */
class DocumentNumberService
{
	const DOC_SUPPLIER = 'SUP';
	const DOC_KARIGAR = 'KAR';
	const DOC_ISSUE = 'ISS';
	const DOC_SUPPLIER_LEDGER = 'SLT';
	const DOC_SUPPLIER_LEDGER_VOUCHER = 'SV';  // Supplier Voucher
	const DOC_KARIGAR_JAMA_VOUCHER = 'KV';     // Karigar Voucher

	/**
	 * Get display prefix for voucher types from params, with fallback to constants.
	 * @param string $docType Internal doc_type constant (e.g., DOC_SUPPLIER_LEDGER_VOUCHER)
	 * @return string Display prefix (e.g., 'SV' or 'KV')
	 */
	public static function getVoucherPrefix($docType)
	{
		$prefixes = isset(Yii::app()->params['voucherPrefixes']) ? Yii::app()->params['voucherPrefixes'] : array();
		if ($docType === self::DOC_SUPPLIER_LEDGER_VOUCHER) {
			return isset($prefixes['supplier_voucher']) ? $prefixes['supplier_voucher'] : 'SV';
		} elseif ($docType === self::DOC_KARIGAR_JAMA_VOUCHER) {
			return isset($prefixes['karigar_voucher']) ? $prefixes['karigar_voucher'] : 'KV';
		}
		return $docType; // For other types, return as-is
	}

	/**
	 * @param string $docType One of SUP/KAR/ISS/SV/KV etc.
	 * @return string Formatted sr_no with prefix from params or docType
	 * @throws CException
	 */
	public static function nextSrNo($docType)
	{
		$docType = strtoupper(trim((string)$docType));
		if ($docType === '') {
			throw new CException('docType is required');
		}

		// Get the actual prefix to use (from params or docType itself)
		$displayPrefix = self::getVoucherPrefix($docType);
		// Use display prefix as doc_type in database for voucher types
		$dbDocType = ($docType === self::DOC_SUPPLIER_LEDGER_VOUCHER || $docType === self::DOC_KARIGAR_JAMA_VOUCHER) ? $displayPrefix : $docType;

		$db = Yii::app()->db;
		$existingTx = $db->getCurrentTransaction();
		$tx = null;
		if ($existingTx === null) {
			$tx = $db->beginTransaction();
		}
		try {
			// Ensure row exists
			$exists = (int)$db->createCommand('SELECT COUNT(*) FROM cp_document_sequence WHERE doc_type = :t')
				->queryScalar(array(':t' => $dbDocType));
			if ($exists === 0) {
				$db->createCommand('INSERT INTO cp_document_sequence (doc_type, next_no) VALUES (:t, 1)')
					->execute(array(':t' => $dbDocType));
			}

			// Lock row and read current number
			$row = $db->createCommand('SELECT next_no FROM cp_document_sequence WHERE doc_type = :t FOR UPDATE')
				->queryRow(true, array(':t' => $dbDocType));
			if (!$row || !isset($row['next_no'])) {
				throw new CException('Sequence row missing for doc_type: '.$dbDocType);
			}

			$nextNo = (int)$row['next_no'];
			// Increment for next allocation
			$db->createCommand('UPDATE cp_document_sequence SET next_no = :n WHERE doc_type = :t')
				->execute(array(':n' => $nextNo + 1, ':t' => $dbDocType));

			if ($tx !== null) {
				$tx->commit();
			}

			return $displayPrefix . str_pad((string)$nextNo, 6, '0', STR_PAD_LEFT);
		} catch (Exception $e) {
			if ($tx !== null && $tx->getActive()) {
				$tx->rollback();
			}
			throw $e;
		}
	}
}

