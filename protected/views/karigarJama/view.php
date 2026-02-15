<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Jama Voucher</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs text-right">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Karigar Jama', array('karigarJama/index')); ?></li>
                <li>View</li>
            </ul>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-title"><h2>Voucher #<?php echo CHtml::encode($model->id); ?></h2></div>
    <div class="row">
        <div class="col-sm-6">
        <?php
        $totalFineWt = 0;
        $totalAmount = 0;
        foreach ($model->lines as $line) {
            $totalFineWt += (float) $line->fine_wt;
            foreach ($line->stones as $s) $totalAmount += (float) $s->stone_amount;
        }
        ?>
        <p><strong>Date:</strong> <?php echo $model->voucher_date ? date('d-m-Y', strtotime($model->voucher_date)) : '—'; ?></p>
        <p><strong>Karigar:</strong> <?php echo isset($model->karigar) ? CHtml::encode($model->karigar->name) : '—'; ?></p>
        <p><strong>SR No:</strong> <?php echo CHtml::encode($model->sr_no); ?></p>
        <?php if (!empty($model->voucher_number)): ?><p><strong>Voucher No:</strong> <?php echo CHtml::encode($model->voucher_number); ?></p><?php endif; ?>
        <p><strong>Total Fine Wt:</strong> <?php echo number_format($totalFineWt, 3); ?></p>
        <p><strong>Total Amount:</strong> <?php echo number_format($totalAmount, 2); ?></p>
        </div>
        <div class="col-sm-6 text-right">
        <?php echo CHtml::link('Edit', array('update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
        <?php echo CHtml::link('<i class="fa fa-file-pdf-o"></i> Download PDF', array('karigarJama/pdf', 'id' => $model->id), array('class' => 'btn btn-primary')); ?>
        </div>
    </div>

    <h4>Items</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sr</th>
                <th>Order No</th>
                <th>Customer</th>
                <th>Item</th>
                <th>Psc</th>
                <th>Gross</th>
                <th>Net</th>
                <th>Touch %</th>
                <th>Fine Wt</th>
                <th>Stone</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->lines as $line): ?>
            <tr>
                <td><?php echo CHtml::encode($line->sr_no); ?></td>
                <td><?php echo CHtml::encode($line->order_no); ?></td>
                <td><?php echo CHtml::encode($line->customer_name); ?></td>
                <td><?php echo CHtml::encode($line->item_name); ?></td>
                <td><?php echo CHtml::encode($line->psc); ?></td>
                <td><?php echo number_format((float)$line->gross_wt, 3); ?></td>
                <td><?php echo number_format((float)$line->net_wt, 3); ?></td>
                <td><?php echo CHtml::encode($line->touch_pct); ?></td>
                <td><?php echo number_format((float)$line->fine_wt, 3); ?></td>
                <td class="small">
                    <?php if (!empty($line->stones)): ?>
                    <table class="table table-condensed table-bordered margin-bottom-0" style="margin:0;"><thead><tr><th>Item</th><th class="text-right">Weight</th><th class="text-right">Amount</th></tr></thead><tbody>
                    <?php foreach ($line->stones as $s): ?>
                    <tr><td><?php echo CHtml::encode(isset($s->item) ? $s->item : '—'); ?></td><td class="text-right"><?php echo number_format((float)$s->stone_wt, 3); ?></td><td class="text-right"><?php echo number_format((float)$s->stone_amount, 2); ?></td></tr>
                    <?php endforeach; ?>
                    </tbody></table>
                    <?php endif; ?>
                </td>
                <td><?php echo CHtml::encode($line->remark); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
