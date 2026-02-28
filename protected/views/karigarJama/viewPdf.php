<?php
$borderColor = '#111';
$cellStyle = 'border:1px solid ' . $borderColor . '; padding:3px 4px; font-size:9px;';
$headStyle = 'border:1px solid ' . $borderColor . '; padding:4px 4px; font-size:9px; font-weight:bold;';
$numStyle = 'text-align:right;';

$totalFineWt = 0;
$totalAmount = 0;
foreach ($model->lines as $line) {
    $totalFineWt += (float) $line->fine_wt;
    foreach ($line->stones as $s) {
        $totalAmount += (float) $s->stone_amount;
    }
}

$drcrLabel = '';
if (isset($model->drcr)) {
    $drcrOptions = IssueEntry::getDrcrOptions();
    $drcrLabel = isset($drcrOptions[$model->drcr]) ? $drcrOptions[$model->drcr] : '';
}

$voucherNo = $model->voucher_number ? $model->voucher_number : $model->id;
$printDate = date('d-m-Y');

if (!function_exists('karigarVoucherNumberToWords')) {
    function karigarVoucherNumberToWords($number)
    {
        $number = (float) $number;
        if ($number == 0) {
            return 'Zero';
        }

        $integerPart = (int) floor($number);
        $decimalPart = (int) round(($number - $integerPart) * 100);

        $words = array(
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen',
            20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
            60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );

        $convertBelowThousand = function ($num) use (&$words) {
            $result = '';
            if ($num >= 100) {
                $result .= $words[(int) floor($num / 100)] . ' Hundred ';
                $num = $num % 100;
            }
            if ($num > 0) {
                if ($num < 21) {
                    $result .= $words[$num] . ' ';
                } else {
                    $result .= $words[(int) (floor($num / 10) * 10)] . ' ';
                    if (($num % 10) > 0) {
                        $result .= $words[$num % 10] . ' ';
                    }
                }
            }
            return trim($result);
        };

        $parts = array(
            10000000 => 'Crore',
            100000 => 'Lakh',
            1000 => 'Thousand'
        );

        $text = '';
        foreach ($parts as $value => $label) {
            if ($integerPart >= $value) {
                $chunk = (int) floor($integerPart / $value);
                $integerPart = $integerPart % $value;
                $text .= $convertBelowThousand($chunk) . ' ' . $label . ' ';
            }
        }

        if ($integerPart > 0) {
            $text .= $convertBelowThousand($integerPart) . ' ';
        }

        $text = trim(preg_replace('/\s+/', ' ', $text));
        if ($decimalPart > 0) {
            $text .= ' Point ' . str_replace('  ', ' ', $convertBelowThousand($decimalPart));
        }
        return trim($text);
    }
}
?>

<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:9px;">
    <tr>
        <td colspan="16" style="<?php echo $headStyle; ?> text-align:center; font-size:13px; font-style:italic;">KARIGAR VOUCHER</td>
    </tr>
    <tr>
        <td colspan="2" style="<?php echo $headStyle; ?> width:12%;">DATE</td>
        <td colspan="7" style="<?php echo $headStyle; ?> width:44%; text-align:center;"><?php echo $model->voucher_date ? date('d-m-Y', strtotime($model->voucher_date)) : ''; ?></td>
        <td colspan="2" style="<?php echo $headStyle; ?> width:10%; text-align:center;">VOUCHER NO</td>
        <td colspan="5" style="<?php echo $headStyle; ?> width:34%; text-align:center;"><?php echo CHtml::encode($voucherNo); ?></td>
    </tr>
    <tr>
        <td colspan="2" style="<?php echo $headStyle; ?>">KARIGAR NAME</td>
        <td colspan="14" style="<?php echo $cellStyle; ?>"><?php echo isset($model->karigar) ? CHtml::encode($model->karigar->name) : ''; ?></td>
    </tr>

    <tr><td colspan="16" style="border-left:1px solid <?php echo $borderColor; ?>; border-right:1px solid <?php echo $borderColor; ?>; height:22px;"></td></tr>

    <tr>
        <td style="<?php echo $headStyle; ?> width:6%;">SR. NO</td>
        <td style="<?php echo $headStyle; ?> width:12%;">ORDER ITEM</td>
        <td style="<?php echo $headStyle; ?> width:6%;">PCS</td>
        <td style="<?php echo $headStyle; ?> width:10%;">CARAT</td>
        <td style="<?php echo $headStyle; ?> width:8%;">GR.WT</td>
        <td style="<?php echo $headStyle; ?> width:8%;">NT.WT</td>
        <td style="<?php echo $headStyle; ?> width:6%;">TOUCH</td>
        <td style="<?php echo $headStyle; ?> width:8%;">FINE WT</td>
        <td colspan="8" style="<?php echo $headStyle; ?> width:36%; text-align:center;">OTHERS</td>
    </tr>

    <?php if (!empty($model->lines)): ?>
        <?php foreach ($model->lines as $lnumber=>$line): ?>
            <tr>
                <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($lnumber+1); ?></td>
                <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->item_name); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo $line->psc !== null && $line->psc !== '' ? number_format((float)$line->psc, 0) : ''; ?></td>
                <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->carat); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$line->gross_wt, 3); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$line->net_wt, 3); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$line->touch_pct, 2); ?></td>
                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$line->fine_wt, 3); ?></td>
                <td colspan="8" style="<?php echo $cellStyle; ?> padding:0;">
                    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; font-size:8px;">
                        <tr>
                            <td style="<?php echo $headStyle; ?> border-top:none; border-left:none; width:14%; text-align:center;">SR.NO</td>
                            <td style="<?php echo $headStyle; ?> border-top:none; width:46%; text-align:center;">ITEM</td>
                            <td style="<?php echo $headStyle; ?> border-top:none; width:20%; text-align:center;">WT</td>
                            <td style="<?php echo $headStyle; ?> border-top:none; border-right:none; width:20%; text-align:center;">AMT</td>
                        </tr>
                        <?php if (!empty($line->stones)): ?>
                            <?php $stoneSr = 1; foreach ($line->stones as $stone): ?>
                                <tr>
                                    <td style="<?php echo $cellStyle; ?> border-left:none; text-align:center;"><?php echo $stoneSr++; ?></td>
                                    <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($stone->item); ?></td>
                                    <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$stone->stone_wt, 3); ?></td>
                                    <td style="<?php echo $cellStyle . $numStyle; ?> border-right:none;"><?php echo number_format((float)$stone->stone_amount, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td style="<?php echo $cellStyle; ?> border-left:none;">&nbsp;</td>
                                <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
                                <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
                                <td style="<?php echo $cellStyle; ?> border-right:none;">&nbsp;</td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="<?php echo $headStyle; ?> text-align:center;">REMARK</td>
                <td colspan="15" style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($line->remark); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td style="<?php echo $cellStyle; ?>">&nbsp;</td>
            <td colspan="8" style="<?php echo $cellStyle; ?>">&nbsp;</td>
        </tr>
        <tr>
            <td style="<?php echo $headStyle; ?> text-align:center;">REMARK</td>
            <td colspan="15" style="<?php echo $cellStyle; ?>">&nbsp;</td>
        </tr>
    <?php endif; ?>

    <tr><td colspan="16" style="border-left:1px solid <?php echo $borderColor; ?>; border-right:1px solid <?php echo $borderColor; ?>; height:18px;"></td></tr>

    <tr>
        <td colspan="2" style="<?php echo $headStyle; ?>">TOTAL FINE WT</td>
        <td colspan="3" style="<?php echo $headStyle; ?>">IN NUMBERS</td>
        <td colspan="11" style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format($totalFineWt, 3); ?></td>
    </tr>
    <tr>
        <td colspan="2" style="<?php echo $cellStyle; ?>"></td>
        <td colspan="3" style="<?php echo $headStyle; ?>">IN WORDS</td>
        <td colspan="11" style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode(karigarVoucherNumberToWords($totalFineWt)); ?></td>
    </tr>
    <tr>
        <td colspan="2" style="<?php echo $headStyle; ?>">TOTAL AMOUNT</td>
        <td colspan="3" style="<?php echo $headStyle; ?>">IN NUMBERS</td>
        <td colspan="11" style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format($totalAmount, 2); ?></td>
    </tr>
    <tr>
        <td colspan="2" style="<?php echo $cellStyle; ?>"></td>
        <td colspan="3" style="<?php echo $headStyle; ?>">IN WORDS</td>
        <td colspan="11" style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode(karigarVoucherNumberToWords($totalAmount)); ?></td>
    </tr>

    <tr>
        <td colspan="16" style="padding-top:26px; padding-bottom:8px; border:none;"></td>
    </tr>
    <tr>
        <td colspan="16" style="border:none;">
            <div style="height:200px; width:42%; float:left; border:none;">
                <div style="font-size:10px; font-weight:bold; margin-bottom:58px;"><br><br>SIGNATURE:<br><br><br><br></div>
            </div>
            <div style="height:90px; width:42%; float:left; border:none;">
                <div style="font-size:10px;">DATE : <?php echo $printDate; ?></div>
            </div>
            <div style="clear:both;"></div>
        </td>
    </tr>
</table>
