<?php

class Words
{
	private static function wordsBelowThousand($n)
	{
		$ones = array(
			0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
			6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
			11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
			16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen'
		);
		$tens = array(
			2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty',
			6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
		);

		$n = (int)$n;
		if ($n < 20) return $ones[$n];
		if ($n < 100) {
			$t = (int)floor($n / 10);
			$r = $n % 10;
			return $tens[$t] . ($r ? ' ' . $ones[$r] : '');
		}
		$h = (int)floor($n / 100);
		$r = $n % 100;
		$out = $ones[$h] . ' Hundred';
		if ($r) $out .= ' ' . self::wordsBelowThousand($r);
		return $out;
	}

	/**
	 * Indian numbering system (Crore/Lakh/Thousand).
	 */
	public static function number($num)
	{
		$num = (int)$num;
		if ($num === 0) return 'Zero';
		if ($num < 0) return 'Minus ' . self::number(abs($num));

		$parts = array();
		$crore = (int)floor($num / 10000000);
		$num = $num % 10000000;
		$lakh = (int)floor($num / 100000);
		$num = $num % 100000;
		$thousand = (int)floor($num / 1000);
		$num = $num % 1000;
		$rest = $num;

		if ($crore) $parts[] = self::wordsBelowThousand($crore) . ' Crore';
		if ($lakh) $parts[] = self::wordsBelowThousand($lakh) . ' Lakh';
		if ($thousand) $parts[] = self::wordsBelowThousand($thousand) . ' Thousand';
		if ($rest) $parts[] = self::wordsBelowThousand($rest);

		return trim(implode(' ', $parts));
	}

	public static function inr($amount)
	{
		$amount = (float)$amount;
		$rupees = (int)floor($amount);
		$paise = (int)round(($amount - $rupees) * 100);
		$out = 'Rupees ' . self::number($rupees);
		if ($paise > 0) {
			$out .= ' and Paise ' . self::number($paise);
		}
		return $out . ' Only';
	}

	/**
	 * Fine weight words (supports up to 3 decimals).
	 * Example: 12.345 => "Twelve point Three Four Five"
	 */
	public static function weight($wt)
	{
		$wt = (float)$wt;
		$whole = (int)floor($wt);
		$dec = (int)round(($wt - $whole) * 1000);
		$out = self::number($whole);
		if ($dec > 0) {
			$decStr = str_pad((string)$dec, 3, '0', STR_PAD_LEFT);
			$digits = str_split($decStr);
			$digitWords = array(
				'0'=>'Zero','1'=>'One','2'=>'Two','3'=>'Three','4'=>'Four','5'=>'Five','6'=>'Six','7'=>'Seven','8'=>'Eight','9'=>'Nine'
			);
			$out .= ' point ' . $digitWords[$digits[0]] . ' ' . $digitWords[$digits[1]] . ' ' . $digitWords[$digits[2]];
		}
		return $out;
	}
}

