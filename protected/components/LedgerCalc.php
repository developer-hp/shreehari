<?php

class LedgerCalc
{
	/**
	 * fine_wt = net_wt * (touch_pct/100)
	 * Rounding policy: 3 decimals (consistent with existing metal weight formatting).
	 */
	public static function fineWt($netWt, $touchPct, $precision = 3)
	{
		if ($netWt === null || $netWt === '' || $touchPct === null || $touchPct === '') {
			return null;
		}
		$netWt = (float)$netWt;
		$touchPct = (float)$touchPct;
		return round($netWt * ($touchPct / 100.0), (int)$precision);
	}
}

