<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Supplier Ledger Transaction</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <ul class="breadcrumb breadcrumb-top">
                <li><?php echo CHtml::link('Supplier Ledger', array('supplierLedger/index')); ?></li>
                <li>View</li>
            </ul>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-title"><h2>Transaction #<?php echo CHtml::encode($model->id); ?></h2></div>
    <div class="row">
        <div class="col-sm-6">
            <p><strong>Date:</strong> <?php echo $model->txn_date ? date('d-m-Y', strtotime($model->txn_date)) : '—'; ?></p>
            <p><strong>Supplier:</strong> <?php echo isset($model->supplier) ? CHtml::encode($model->supplier->name) : '—'; ?></p>
            <?php if (!empty($model->sr_no)): ?><p><strong>SR No:</strong> <?php echo CHtml::encode($model->sr_no); ?></p><?php endif; ?>
            <?php if (!empty($model->voucher_number)): ?><p><strong>Voucher No:</strong> <?php echo CHtml::encode($model->voucher_number); ?></p><?php endif; ?>
            <p><strong>Total Fine Wt:</strong> <?php echo number_format((float)$model->total_fine_wt, 3); ?></p>
            <p><strong>Total Amount:</strong> <?php echo number_format((float)$model->total_amount, 2); ?></p>
        </div>
        <div class="col-sm-6 text-right">
            <p>
                <?php echo CHtml::link('Edit', array('update', 'id' => $model->id), array('class' => 'btn btn-success')); ?>
                <?php echo CHtml::link('<i class="fa fa-file-pdf-o"></i> Download PDF', array('supplierLedger/pdf', 'id' => $model->id), array('class' => 'btn btn-primary')); ?>
            </p>
        </div>
    </div>

    <h4>Items</h4>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Sr</th>
                <th>Item</th>
                <th>Ct</th>
                <th>Gross Wt</th>
                <th>Net Wt</th>
                <th>Touch %</th>
                <th>Fine Wt</th>
                <th>Item Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $itemSr = 0; foreach ($model->items as $item): $itemSr++; ?>
            <tr>
                <td><?php echo $itemSr; ?></td>
                <td><?php echo CHtml::encode($item->item_name); ?></td>
                <td><?php echo CHtml::encode($item->ct); ?></td>
                <td><?php echo number_format((float)$item->gross_wt, 3); ?></td>
                <td><?php echo number_format((float)$item->net_wt, 3); ?></td>
                <td><?php echo CHtml::encode($item->touch_pct); ?></td>
                <td><?php echo number_format((float)$item->fine_wt, 3); ?></td>
                <td><?php echo number_format((float)$item->item_total, 2); ?></td>
            </tr>
            <?php if (!empty($item->charges)): ?>
            <tr>
                <td colspan="8" style="padding: 0; vertical-align: top;">
                    <table class="table table-condensed table-bordered" style="margin: 0; max-width: 100%;">
                        <thead>
                            <tr class="active">
                                <th>Sr</th>
                                <th>Charge Type</th>
                                <th>Name</th>
                                <th class="text-right">Qty</th>
                                <th class="text-right">Rate</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $chSr = 0; foreach ($item->charges as $ch): $chSr++; ?>
                            <?php
                            $typeName = isset($ch->subitemType) ? CHtml::encode($ch->subitemType->name) : CHtml::encode($ch->charge_type);
                            $chargeName = $ch->charge_name ? CHtml::encode($ch->charge_name) : '—';
                            ?>
                            <tr>
                                <td><?php echo $chSr; ?></td>
                                <td><?php echo $typeName; ?></td>
                                <td><?php echo $chargeName; ?></td>
                                <td class="text-right"><?php echo number_format((float)$ch->quantity, 3); ?></td>
                                <td class="text-right"><?php echo number_format((float)$ch->rate, 2); ?></td>
                                <td class="text-right"><?php echo number_format((float)$ch->amount, 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </td>
            </tr>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
