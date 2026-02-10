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

	/**
	 * @param string $docType One of SUP/KAR/ISS
	 * @return string Formatted sr_no
	 * @throws CException
	 */
	public static function nextSrNo($docType)
	{
		$docType = strtoupper(trim((string)$docType));
		if ($docType === '') {
			throw new CException('docType is required');
		}

		$db = Yii::app()->db;
		$tx = $db->beginTransaction();
		try {
			// Ensure row exists
			$exists = (int)$db->createCommand('SELECT COUNT(*) FROM cp_document_sequence WHERE doc_type = :t')
				->queryScalar(array(':t' => $docType));
			if ($exists === 0) {
				$db->createCommand('INSERT INTO cp_document_sequence (doc_type, next_no) VALUES (:t, 1)')
					->execute(array(':t' => $docType));
			}

			// Lock row and read current number
			$row = $db->createCommand('SELECT next_no FROM cp_document_sequence WHERE doc_type = :t FOR UPDATE')
				->queryRow(true, array(':t' => $docType));
			if (!$row || !isset($row['next_no'])) {
				throw new CException('Sequence row missing for doc_type: '.$docType);
			}

			$nextNo = (int)$row['next_no'];
			// Increment for next allocation
			$db->createCommand('UPDATE cp_document_sequence SET next_no = :n WHERE doc_type = :t')
				->execute(array(':n' => $nextNo + 1, ':t' => $docType));

			$tx->commit();

			return $docType . str_pad((string)$nextNo, 6, '0', STR_PAD_LEFT);
		} catch (Exception $e) {
			if ($tx->active) $tx->rollback();
			throw $e;
		}
	}
}

