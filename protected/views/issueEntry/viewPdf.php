<?php
$cellStyle = 'border:1px solid #333; padding:6px 8px;';
$thStyle = 'border:1px solid #333; padding:6px 8px; background:#e8e8e8; font-weight:bold;';
$drcrOptions = IssueEntry::getDrcrOptions();
?>
<div style="margin-bottom:10px;"><strong>Issue Entry <?php echo CHtml::encode($model->sr_no); ?></strong></div>
<table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse; margin-bottom:12px;">
    <tr>
        <td style="<?php echo $thStyle; ?> width:25%;">SR No</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo CHtml::encode($model->sr_no); ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">Issue Date</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo !empty($model->issue_date) ? date('d-m-Y', strtotime($model->issue_date)) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">Account</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo isset($model->customer) ? CHtml::encode($model->customer->name) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">Carat</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo !empty($model->carat) ? CHtml::encode($model->carat) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">Weight</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo ($model->weight !== null && $model->weight !== '') ? number_format((float)$model->weight, 3) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">Fine Wt</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo ($model->fine_wt !== null && $model->fine_wt !== '') ? number_format((float)$model->fine_wt, 3) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">Amount</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo ($model->amount !== null && $model->amount !== '') ? number_format((float)$model->amount, 2) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">DR/CR</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo isset($drcrOptions[$model->drcr]) ? CHtml::encode($drcrOptions[$model->drcr]) : '—'; ?></td>
    </tr>
    <tr>
        <td style="<?php echo $thStyle; ?>">Remarks</td>
        <td style="<?php echo $cellStyle; ?>"><?php echo !empty($model->remarks) ? nl2br(CHtml::encode($model->remarks)) : '—'; ?></td>
    </tr>
</table>
