<?php
$cellStyle = 'border:1px solid #333; padding:4px 6px;';
$thStyle = 'border:1px solid #333; padding:5px 6px; background:#e8e8e8; font-weight:bold;';
$numStyle = 'text-align:right;';
?>
<div style="margin-bottom:10px;"><strong>Supplier Ledger Transaction #<?php echo CHtml::encode($model->id); ?></strong></div>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:12px;">
    <tr>
        <td style="<?php echo $cellStyle; ?> width:20%;"><strong>Date</strong></td>
        <td style="<?php echo $cellStyle; ?>"><?php echo $model->txn_date ? date('d-m-Y', strtotime($model->txn_date)) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>Supplier</strong></td>
        <td style="<?php echo $cellStyle; ?>"><?php echo isset($model->supplier) ? CHtml::encode($model->supplier->name) : '—'; ?></td>
    </tr>
    <?php if (!empty($model->sr_no)): ?>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>SR No</strong></td>
        <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($model->sr_no); ?></td>
    </tr>
    <?php endif; ?>
    <?php if (!empty($model->voucher_number)): ?>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>Voucher No</strong></td>
        <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($model->voucher_number); ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>Total Fine Wt</strong></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$model->total_fine_wt, 3); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $cellStyle; ?>"><strong>Total Amount</strong></td>
        <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$model->total_amount, 2); ?></td>
    </tr>
</table>

<div style="margin-bottom:8px;"><strong>Items</strong></div>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:12px;">
    <thead>
        <tr>
            <th width="4%" style="<?php echo $thStyle; ?>">Sr</th>
            <th width="18%" style="<?php echo $thStyle; ?>">Item</th>
            <th width="8%" style="<?php echo $thStyle; ?>">Ct</th>
            <th width="12%" style="<?php echo $thStyle . $numStyle; ?>">Gross Wt</th>
            <th width="12%" style="<?php echo $thStyle . $numStyle; ?>">Net Wt</th>
            <th width="10%" style="<?php echo $thStyle; ?>">Touch %</th>
            <th width="12%" style="<?php echo $thStyle . $numStyle; ?>">Fine Wt</th>
            <th width="12%" style="<?php echo $thStyle . $numStyle; ?>">Other Items</th>
            <th width="12%" style="<?php echo $thStyle . $numStyle; ?>">Item Total</th>
        </tr>
    </thead>
    <tbody>
        <?php $itemSr = 0; foreach ($model->items as $item): $itemSr++; ?>
        <tr>
            <td style="<?php echo $cellStyle; ?>"><?php echo $itemSr; ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($item->item_name); ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($item->ct); ?></td>
            <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$item->gross_wt, 3); ?></td>
            <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$item->net_wt, 3); ?></td>
            <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($item->touch_pct); ?></td>
            <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$item->fine_wt, 3); ?></td>
            <td>
                <?php if (!empty($item->charges)): ?>
                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin:0;">
                            <tr>
                                <td width="20%" style="<?php echo $thStyle; ?>">Charge Type</td>
                                <td width="25%" style="<?php echo $thStyle; ?>">Name</td>
                                <td width="15%" style="<?php echo $thStyle . $numStyle; ?>">Qty</td>
                                <td width="15%" style="<?php echo $thStyle . $numStyle; ?>">Rate</td>
                                <td width="20%" style="<?php echo $thStyle . $numStyle; ?>">Amount</td>
                            </tr>
                            <?php $chSr = 0; foreach ($item->charges as $ch): $chSr++;
                                $typeName = isset($ch->subitemType) ? CHtml::encode($ch->subitemType->name) : CHtml::encode($ch->charge_type);
                                $chargeName = $ch->charge_name ? CHtml::encode($ch->charge_name) : '—';
                            ?>
                            <tr>
                                <td style="<?php echo $cellStyle; ?>"><?php echo $typeName; ?></td>
                                <td style="<?php echo $cellStyle; ?>"><?php echo $chargeName; ?></td>
                                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$ch->quantity, 3); ?></td>
                                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$ch->rate, 2); ?></td>
                                <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$ch->amount, 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                <?php endif; ?>
            </td>
            <td style="<?php echo $cellStyle . $numStyle; ?>"><?php echo number_format((float)$item->item_total, 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
