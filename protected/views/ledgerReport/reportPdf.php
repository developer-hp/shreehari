<?php
$cellStyle = 'border:1px solid #222; padding:4px 6px; font-size:10px;';
$thStyle = 'border:1px solid #222; padding:4px 6px; font-size:10px; font-weight:bold;';
$numStyle = 'text-align:right;';
$todayDate = date('d-m-Y');

if (!function_exists('ledgerPdfNumberToWords')) {
    function ledgerPdfNumberToWords($number, $precision = 2)
    {
        $number = (float) $number;
        $precision = (int) $precision;
        if ($precision < 0) {
            $precision = 0;
        }
        if ($number == 0) {
            return 'Zero';
        }

        $integerPart = (int) floor(abs($number));
        $factor = pow(10, $precision);
        $decimalPart = (int) round((abs($number) - $integerPart) * $factor);
        if ($decimalPart >= $factor) {
            $integerPart += 1;
            $decimalPart = 0;
        }
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
            60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $digitWords = array('Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');

        $belowThousand = function ($num) use (&$words) {
            $text = '';
            if ($num >= 100) {
                $text .= $words[(int) floor($num / 100)] . ' Hundred ';
                $num = $num % 100;
            }
            if ($num > 0) {
                if ($num < 21) {
                    $text .= $words[$num] . ' ';
                } else {
                    $text .= $words[(int) (floor($num / 10) * 10)] . ' ';
                    if (($num % 10) > 0) {
                        $text .= $words[$num % 10] . ' ';
                    }
                }
            }
            return trim($text);
        };

        $parts = array(10000000 => 'Crore', 100000 => 'Lakh', 1000 => 'Thousand');
        $text = '';
        foreach ($parts as $value => $label) {
            if ($integerPart >= $value) {
                $chunk = (int) floor($integerPart / $value);
                $integerPart = $integerPart % $value;
                $text .= $belowThousand($chunk) . ' ' . $label . ' ';
            }
        }
        if ($integerPart > 0) {
            $text .= $belowThousand($integerPart) . ' ';
        }
        $text = trim(preg_replace('/\s+/', ' ', $text));
        if ($precision > 0 && $decimalPart > 0) {
            $decimalText = str_pad((string) $decimalPart, $precision, '0', STR_PAD_LEFT);
            $decimalWords = array();
            foreach (str_split($decimalText) as $digit) {
                $decimalWords[] = $digitWords[(int) $digit];
            }
            $text .= ' Point ' . implode(' ', $decimalWords);
        }
        return trim($text);
    }
}

if (!function_exists('ledgerPdfBalanceLabel')) {
    function ledgerPdfBalanceLabel($value)
    {
        return ((float) $value) < 0 ? 'Baki' : 'Jama';
    }
}

if (!function_exists('ledgerPdfFormatBalance')) {
    function ledgerPdfFormatBalance($value, $precision = 2)
    {
        return number_format(abs((float) $value), (int) $precision) . ' ' . ledgerPdfBalanceLabel($value);
    }
}

if (!function_exists('ledgerPdfBalanceWords')) {
    function ledgerPdfBalanceWords($value, $precision = 2)
    {
        return ledgerPdfNumberToWords(abs((float) $value), (int) $precision) . ' ' . ledgerPdfBalanceLabel($value);
    }
}
?>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:10px;">
    <tr>
        <td style="font-size:10px; font-weight:bold; text-align:right;">Date: <?php echo CHtml::encode($todayDate); ?></td>
    </tr>
</table>

<?php if (empty($customers)): ?>
<p>No data found for the selected filters.</p>
<?php else: ?>
<?php foreach ($customers as $row): ?>
<?php
$customer = $row['customer'];
$opening = $row['opening'];
$issues = $row['issues'];

$jamaFine = 0;
$bakiFine = 0;
$jamaAmount = 0;
$bakiAmount = 0;

$runningFineBalance = 0;
$runningAmountBalance = 0;

if ($opening) {
    $openingFine = (float) $opening->opening_fine_wt;
    $openingAmount = (float) $opening->opening_amount;
    if ((int) $opening->opening_fine_wt_drcr === IssueEntry::DRCR_DEBIT) {
        $jamaFine += $openingFine;
        $runningFineBalance += $openingFine;
    } else {
        $bakiFine += $openingFine;
        $runningFineBalance -= $openingFine;
    }
    if ((int) $opening->opening_amount_drcr === IssueEntry::DRCR_DEBIT) {
        $jamaAmount += $openingAmount;
        $runningAmountBalance += $openingAmount;
    } else {
        $bakiAmount += $openingAmount;
        $runningAmountBalance -= $openingAmount;
    }
}
?>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:10px;">
    <tr>
        <td class="text-center" colspan="9" style="<?php echo $thStyle; ?> font-size:16px;text-align:center;"><?php echo CHtml::encode($customer->name); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?> width:10%;">DATE</td>
        <td style="<?php echo $thStyle; ?> width:18%;">PARTICULARS</td>
        <td style="<?php echo $thStyle; ?> width:11%;">FINE JAMA</td>
        <td style="<?php echo $thStyle; ?> width:11%;">FINE BAKI</td>
        <td style="<?php echo $thStyle; ?> width:13%;">BAL FINE</td>
        <td style="<?php echo $thStyle; ?> width:11%;">AMT JAMA</td>
        <td style="<?php echo $thStyle; ?> width:11%;">AMT BAKI</td>
        <td colspan="2" style="<?php echo $thStyle; ?> width:15%;">BAL AMT</td>
    </tr>

    <?php if ($opening): ?>
    <?php
    $openingDate = !empty($opening->created_at) ? date('d-m-Y', strtotime($opening->created_at)) : '';
    ?>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><?php echo $openingDate; ?></td>
        <td style="<?php echo $cellStyle; ?>">OPENING</td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo (int) $opening->opening_fine_wt_drcr === IssueEntry::DRCR_DEBIT ? number_format((float) $opening->opening_fine_wt, 3) : ''; ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo (int) $opening->opening_fine_wt_drcr === IssueEntry::DRCR_CREDIT ? number_format((float) $opening->opening_fine_wt, 3) : ''; ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo ledgerPdfFormatBalance($runningFineBalance, 3); ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo (int) $opening->opening_amount_drcr === IssueEntry::DRCR_DEBIT ? number_format((float) $opening->opening_amount, 2) : ''; ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo (int) $opening->opening_amount_drcr === IssueEntry::DRCR_CREDIT ? number_format((float) $opening->opening_amount, 2) : ''; ?></td>
        <td colspan="2" style="<?php echo $cellStyle . $numStyle; ?>"><?php echo ledgerPdfFormatBalance($runningAmountBalance, 2); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $cellStyle; ?>">REMARK</td>
        <td colspan="8" style="<?php echo $cellStyle; ?>">Opening Balance</td>
    </tr>
    <?php endif; ?>

    <?php foreach ($issues as $iss): ?>
    <?php
    $isJama = ((int) $iss->drcr === IssueEntry::DRCR_DEBIT);
    $fineWt = (float) $iss->fine_wt;
    $amount = (float) $iss->amount;
    if ($isJama) {
        $jamaFine += $fineWt;
        $jamaAmount += $amount;
        $runningFineBalance += $fineWt;
        $runningAmountBalance += $amount;
    } else {
        $bakiFine += $fineWt;
        $bakiAmount += $amount;
        $runningFineBalance -= $fineWt;
        $runningAmountBalance -= $amount;
    }
    $vouchNo = trim((string) $iss->sr_no);
    $remark = trim((string) $iss->remarks);
    ?>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><?php echo !empty($iss->issue_date) ? date('d-m-Y', strtotime($iss->issue_date)) : ''; ?></td>
        <td style="<?php echo $cellStyle; ?>">VOUCH NO <?php echo CHtml::encode($vouchNo); ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $isJama ? number_format($fineWt, 3) : ''; ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo !$isJama ? number_format($fineWt, 3) : ''; ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo ledgerPdfFormatBalance($runningFineBalance, 3); ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $isJama ? number_format($amount, 2) : ''; ?></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo !$isJama ? number_format($amount, 2) : ''; ?></td>
        <td colspan="2" style="<?php echo $cellStyle . $numStyle; ?>"><?php echo ledgerPdfFormatBalance($runningAmountBalance, 2); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $cellStyle; ?>">REMARK</td>
        <td colspan="8" style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($remark); ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:20px;">
    <tr>
        <td style="<?php echo $thStyle; ?> width:14%;">TOTAL FINE WT</td>
        <td style="<?php echo $thStyle; ?> width:12%;">IN NUMBERS</td>
        <td style="<?php echo $cellStyle . $numStyle; ?>" colspan="8"><?php echo ledgerPdfFormatBalance($runningFineBalance, 3); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>"></td>
        <td style="<?php echo $thStyle; ?>">IN WORDS</td>
        <td style="<?php echo $cellStyle; ?>" colspan="8"><?php echo CHtml::encode(ledgerPdfBalanceWords($runningFineBalance, 3)); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">TOTAL AMOUNT</td>
        <td style="<?php echo $thStyle; ?>">IN NUMBERS</td>
        <td style="<?php echo $cellStyle . $numStyle; ?>" colspan="8"><?php echo ledgerPdfFormatBalance($runningAmountBalance, 2); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>"></td>
        <td style="<?php echo $thStyle; ?>">IN WORDS</td>
        <td style="<?php echo $cellStyle; ?>" colspan="8"><?php echo CHtml::encode(ledgerPdfBalanceWords($runningAmountBalance)); ?></td>
    </tr>
</table>

<?php endforeach; ?>
<?php endif; ?>
