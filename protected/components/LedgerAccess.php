<?php

class LedgerAccess
{
	/**
	 * Returns cp_user.user_type for current user (1/2/3). Defaults to 0 if unknown.
	 */
	public static function userType()
	{
		if (Yii::app()->user->isGuest) return 0;
		$u = User::model()->findByPk((int)Yii::app()->user->id);
		return $u ? (int)$u->user_type : 0;
	}

	public static function isMainUser()
	{
		return self::userType() === 1;
	}

	/**
	 * User 2 (user_type=3) rule: editable within 24 hours of created_at.
	 */
	public static function within24Hours($createdAt)
	{
		if (empty($createdAt)) return false;
		$ts = strtotime($createdAt);
		if ($ts === false) return false;
		return (time() - $ts) <= 24 * 60 * 60;
	}

	/**
	 * User 1 (user_type=2) rule (chosen): editable only if record date is the latest transaction date for that account.
	 */
	public static function isLatestDatedForAccount($tableName, $dateField, $accountField, $accountId, $dateValue)
	{
		$accountId = (int)$accountId;
		if ($accountId <= 0) return false;
		if (empty($dateValue)) return false;

		$date = date('Y-m-d', strtotime($dateValue));
		$sql = "SELECT MAX($dateField) FROM $tableName WHERE $accountField = :aid AND is_deleted = 0";
		$maxDate = Yii::app()->db->createCommand($sql)->queryScalar(array(':aid' => $accountId));
		if (!$maxDate) return false;
		return $date === date('Y-m-d', strtotime($maxDate));
	}

	public static function canModifyLedgerDoc($model, $tableName, $dateField, $accountField)
	{
		$ut = self::userType();
		if ($ut === 1) return true;

		// User 1: only latest dated record per account
		if ($ut === 2) {
			$accountId = isset($model->$accountField) ? $model->$accountField : null;
			$dateValue = isset($model->$dateField) ? $model->$dateField : null;
			return self::isLatestDatedForAccount($tableName, $dateField, $accountField, $accountId, $dateValue);
		}

		// User 2: within 24 hours of created_at
		if ($ut === 3) {
			return self::within24Hours(isset($model->created_at) ? $model->created_at : null);
		}

		return false;
	}
}

