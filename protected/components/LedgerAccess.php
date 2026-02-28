<?php

class LedgerAccess
{
	const ROLE_ADMIN = 1;
	const ROLE_HEAD = 2;
	const ROLE_STAFF = 3;

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
		return self::userType() === self::ROLE_ADMIN;
	}

	public static function isAdmin()
	{
		return self::userType() === self::ROLE_ADMIN;
	}

	public static function isHead()
	{
		return self::userType() === self::ROLE_HEAD;
	}

	public static function isStaff()
	{
		return self::userType() === self::ROLE_STAFF;
	}

	public static function isTodayDate($dateValue)
	{
		if (empty($dateValue)) return false;
		$ts = strtotime($dateValue);
		if ($ts === false) return false;
		return date('Y-m-d', $ts) === date('Y-m-d');
	}

	/**
	 * Admin: can edit always.
	 * Head: can edit until voucher is locked.
	 * Staff: can edit only same-day voucher and only when unlocked.
	 */
	public static function canEditVoucher($model, $dateField, $lockField = 'is_locked')
	{
		if (!$model) return false;
		$ut = self::userType();
		$isLocked = isset($model->$lockField) ? ((int) $model->$lockField === 1) : false;

		if ($ut === self::ROLE_ADMIN) {
			return true;
		}

		if ($ut === self::ROLE_HEAD) {
			return !$isLocked;
		}

		if ($ut === self::ROLE_STAFF) {
			$dateValue = isset($model->$dateField) ? $model->$dateField : null;
			return !$isLocked && self::isTodayDate($dateValue);
		}

		return false;
	}

	/**
	 * Admin: can delete all vouchers (including locked).
	 * Head: can delete only unlocked vouchers.
	 * Staff: can delete only same-day unlocked vouchers.
	 */
	public static function canDeleteVoucher($model, $dateField, $lockField = 'is_locked')
	{
		if (!$model) return false;
		$ut = self::userType();
		$isLocked = isset($model->$lockField) ? ((int) $model->$lockField === 1) : false;

		if ($ut === self::ROLE_ADMIN) {
			return true;
		}

		if ($ut === self::ROLE_HEAD) {
			return !$isLocked;
		}

		if ($ut === self::ROLE_STAFF) {
			$dateValue = isset($model->$dateField) ? $model->$dateField : null;
			return !$isLocked && self::isTodayDate($dateValue);
		}

		return false;
	}

	/**
	 * Issue Entry edit rules.
	 * Admin/Head: can edit.
	 * Staff: same-day entries only.
	 */
	public static function canEditIssueEntry($model)
	{
		if (!$model) return false;
		$ut = self::userType();
		if ($ut === self::ROLE_ADMIN || $ut === self::ROLE_HEAD) {
			return true;
		}
		if ($ut === self::ROLE_STAFF) {
			return self::isTodayDate(isset($model->issue_date) ? $model->issue_date : null);
		}
		return false;
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
		return self::canEditVoucher($model, $dateField, 'is_locked');
	}
}

