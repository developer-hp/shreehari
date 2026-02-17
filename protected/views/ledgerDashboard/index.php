<div class="content-header">
    <div class="row">
        <div class="col-sm-6">
            <div class="header-section">
                <h1>Ledger Dashboard</h1>
            </div>
        </div>
        <div class="col-sm-6 hidden-xs">
            <div class="header-section">
                <ul class="breadcrumb breadcrumb-top">
                    <li><?php echo CHtml::link('Home', array('site/index')); ?></li>
                    <li>Ledger Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if (Yii::app()->user->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <p><?php echo Yii::app()->user->getFlash('success'); ?></p>
    </div>
<?php endif; ?>
<?php if (Yii::app()->user->hasFlash('danger')): ?>
    <div class="alert alert-danger alert-dismissable">
        <p><?php echo Yii::app()->user->getFlash('danger'); ?></p>
    </div>
<?php endif; ?>

<!-- Date filter -->
<div class="row">
    <div class="col-lg-12">
        <div class="block block-condensed">
            <div class="block-content">
                <?php
                $formUrl = Yii::app()->createUrl('ledgerDashboard/index');
                $currentDateYmd = isset($filterDate) ? $filterDate : date('Y-m-d');
                ?>
                <form method="get" action="<?php echo $formUrl; ?>" class="form-inline">
                    <label for="ledger-filter-date" class="control-label">Filter by date:</label>
                    <input type="date" id="ledger-filter-date" name="date" value="<?php echo CHtml::encode($currentDateYmd); ?>" class="form-control" style="width: 160px; margin: 0 8px;" />
                    <button type="submit" class="btn btn-primary">Apply</button>
                    <?php if (isset($filterDate) && $filterDate !== date('Y-m-d')): ?>
                    <a href="<?php echo $formUrl; ?>" class="btn btn-default" style="margin-left: 6px;">Show today</a>
                    <?php endif; ?>
                </form>
                <p class="text-muted small" style="margin-top: 8px; margin-bottom: 0;">Showing data for selected date in summary and widgets below. Overall ledger balance is for all time.</p>
            </div>
        </div>
    </div>
</div>

<!-- Ledger In / Out / Balance -->
<div class="row" style="margin-top: 10px;">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title">
                <h2>Ledger summary</h2>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="sub-header"><?php echo isset($filterDateDisplay) ? 'Selected date (' . CHtml::encode($filterDateDisplay) . ')' : 'Today'; ?></h4>
                        <table class="table table-condensed table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 120px;">Amount In (CR)</td>
                                    <td class="text-right"><strong class="text-success">₹ <?php echo number_format((float) $todayInAmount, 2); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Amount Out (DR)</td>
                                    <td class="text-right"><strong class="text-danger">₹ <?php echo number_format((float) $todayOutAmount, 2); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Balance (In − Out)</td>
                                    <td class="text-right"><strong><?php echo number_format((float) $todayBalanceAmount, 2); ?> <?php echo $todayBalanceAmount >= 0 ? '<span class="text-success">(CR)</span>' : '<span class="text-danger">(DR)</span>'; ?></strong></td>
                                </tr>
                                <tr><td colspan="2" class="border-top"></td></tr>
                                <tr>
                                    <td class="text-muted">Fine Wt In</td>
                                    <td class="text-right"><strong class="text-success"><?php echo number_format((float) $todayInFineWt, 3); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Fine Wt Out</td>
                                    <td class="text-right"><strong class="text-danger"><?php echo number_format((float) $todayOutFineWt, 3); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Fine Wt Balance</td>
                                    <td class="text-right"><strong><?php echo number_format((float) $todayBalanceFineWt, 3); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4 class="sub-header">Overall (all time)</h4>
                        <table class="table table-condensed table-borderless">
                            <tbody>
                                <tr>
                                    <td class="text-muted" style="width: 120px;">Amount In (CR)</td>
                                    <td class="text-right"><strong class="text-success">₹ <?php echo number_format((float) $totalInAmount, 2); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Amount Out (DR)</td>
                                    <td class="text-right"><strong class="text-danger">₹ <?php echo number_format((float) $totalOutAmount, 2); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Ledger Balance</td>
                                    <td class="text-right"><strong>₹ <?php echo number_format((float) $ledgerBalanceAmount, 2); ?> <?php echo $ledgerBalanceAmount >= 0 ? '<span class="text-success">(CR)</span>' : '<span class="text-danger">(DR)</span>'; ?></strong></td>
                                </tr>
                                <tr><td colspan="2" class="border-top"></td></tr>
                                <tr>
                                    <td class="text-muted">Fine Wt In</td>
                                    <td class="text-right"><strong class="text-success"><?php echo number_format((float) $totalInFineWt, 3); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Fine Wt Out</td>
                                    <td class="text-right"><strong class="text-danger"><?php echo number_format((float) $totalOutFineWt, 3); ?></strong></td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Fine Wt Balance</td>
                                    <td class="text-right"><strong><?php echo number_format((float) $ledgerBalanceFineWt, 3); ?></strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Today's summary widgets -->
<div class="row" style="margin-top: 10px;">
    <div class="col-sm-6 col-lg-4">
        <a href="<?php echo Yii::app()->createUrl('issueEntry/index'); ?>" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-arrow-circle-right text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong><?php echo (int) $issueEntryCount; ?></strong>
                </h2>
                <span class="text-muted">Issue Entry (<?php echo isset($filterDateDisplay) ? $filterDateDisplay : date('d-m-Y'); ?>)</span>
                <div class="text-muted small">₹ <?php echo number_format((float) $issueEntryTotalAmount, 2); ?></div>
                <div class="text-muted small">Fine Wt: <?php echo number_format((float) $issueEntryTotalFineWt, 3); ?></div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="<?php echo Yii::app()->createUrl('supplierLedger/index'); ?>" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-book text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong><?php echo (int) $supplierLedgerCount; ?></strong>
                </h2>
                <span class="text-muted">Supplier Ledger (<?php echo isset($filterDateDisplay) ? $filterDateDisplay : date('d-m-Y'); ?>)</span>
                <div class="text-muted small">₹ <?php echo number_format((float) $supplierLedgerTotalAmount, 2); ?></div>
                <div class="text-muted small">Fine Wt: <?php echo number_format((float) $supplierLedgerTotalFineWt, 3); ?></div>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="<?php echo Yii::app()->createUrl('karigarJama/index'); ?>" class="widget">
            <div class="widget-content widget-content-mini text-right clearfix">
                <div class="widget-icon pull-left themed-background">
                    <i class="fa fa-file-text-o text-light-op"></i>
                </div>
                <h2 class="widget-heading h3 text">
                    <strong><?php echo (int) $karigarJamaCount; ?></strong>
                </h2>
                <span class="text-muted">Karigar Jama (<?php echo isset($filterDateDisplay) ? $filterDateDisplay : date('d-m-Y'); ?>)</span>
                <div class="text-muted small">₹ <?php echo number_format((float) $karigarJamaTotalAmount, 2); ?></div>
                <div class="text-muted small">Fine Wt: <?php echo number_format((float) $karigarJamaTotalFineWt, 3); ?></div>
            </div>
        </a>
    </div>
</div>

<!-- Charts row -->
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-8">
        <div class="block">
            <div class="block-title">
                <h2>Amount by day (Last 7 days)</h2>
            </div>
            <div class="block-content">
                <div id="ledger-chart-bars" style="height: 280px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="block">
            <div class="block-title">
                <h2>Today's amount split</h2>
            </div>
            <div class="block-content">
                <div id="ledger-chart-pie" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>
<!-- Fine weight by day chart -->
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-12">
        <div class="block">
            <div class="block-title">
                <h2>Fine weight by day (Last 7 days)</h2>
            </div>
            <div class="block-content">
                <div id="ledger-chart-finewt" style="height: 280px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- Recent activity blocks -->
<div class="row" style="margin-top: 20px;">
    <div class="col-lg-4">
        <div class="block" style="min-height: 320px;">
            <div class="block-title">
                <h2>Recent Issue Entries</h2>
                <div class="block-options">
                    <?php echo CHtml::link('View all', array('issueEntry/admin'), array('class' => 'btn btn-xs btn-default')); ?>
                </div>
            </div>
            <table class="table table-striped table-borderless table-vcenter">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Account</th>
                        <th class="text-right">DR/CR</th>
                        <th class="text-right">Fine Wt</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentIssueEntries)): ?>
                        <tr><td colspan="5">No result found</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentIssueEntries as $entry): ?>
                            <tr>
                                <td><?php echo !empty($entry->issue_date) ? date('d-m-Y', strtotime($entry->issue_date)) : '-'; ?></td>
                                <td><?php echo isset($entry->customer) ? CHtml::encode($entry->customer->name) : '-'; ?></td>
                                <td class="text-right"><?php echo $entry->drcr == IssueEntry::DRCR_DEBIT ? 'DR' : 'CR'; ?></td>
                                <td class="text-right"><?php echo number_format((float) $entry->fine_wt, 3); ?></td>
                                <td class="text-right">₹ <?php echo number_format((float) $entry->amount, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="block" style="min-height: 320px;">
            <div class="block-title">
                <h2>Recent Supplier Ledger</h2>
                <div class="block-options">
                    <?php echo CHtml::link('View all', array('supplierLedger/admin'), array('class' => 'btn btn-xs btn-default')); ?>
                </div>
            </div>
            <table class="table table-striped table-borderless table-vcenter">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th class="text-right">Fine Wt</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentSupplierLedger)): ?>
                        <tr><td colspan="4">No result found</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentSupplierLedger as $txn): ?>
                            <tr>
                                <td><?php echo !empty($txn->txn_date) ? date('d-m-Y', strtotime($txn->txn_date)) : '-'; ?></td>
                                <td><?php echo isset($txn->supplier) ? CHtml::encode($txn->supplier->name) : '-'; ?></td>
                                <td class="text-right"><?php echo number_format((float) $txn->total_fine_wt, 3); ?></td>
                                <td class="text-right">₹ <?php echo number_format((float) $txn->total_amount, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="block" style="min-height: 320px;">
            <div class="block-title">
                <h2>Recent Karigar Jama</h2>
                <div class="block-options">
                    <?php echo CHtml::link('View all', array('karigarJama/admin'), array('class' => 'btn btn-xs btn-default')); ?>
                </div>
            </div>
            <table class="table table-striped table-borderless table-vcenter">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Karigar</th>
                        <th class="text-right">Fine Wt</th>
                        <th class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentKarigarJama)): ?>
                        <tr><td colspan="4">No result found</td></tr>
                    <?php else: ?>
                        <?php foreach ($recentKarigarJama as $voucher): ?>
                            <tr>
                                <td><?php echo !empty($voucher->voucher_date) ? date('d-m-Y', strtotime($voucher->voucher_date)) : '-'; ?></td>
                                <td><?php echo isset($voucher->karigar) ? CHtml::encode($voucher->karigar->name) : '-'; ?></td>
                                <td class="text-right"><?php echo number_format((float) $voucher->total_fine_wt, 3); ?></td>
                                <td class="text-right">₹ <?php echo number_format((float) $voucher->total_amount, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
(function() {
    var chartLabels = <?php echo json_encode($chartLabels); ?>;
    var chartIssueEntry = <?php echo json_encode($chartIssueEntry); ?>;
    var chartSupplierLedger = <?php echo json_encode($chartSupplierLedger); ?>;
    var chartKarigarJama = <?php echo json_encode($chartKarigarJama); ?>;
    var chartIssueEntryFineWt = <?php echo json_encode($chartIssueEntryFineWt); ?>;
    var chartSupplierLedgerFineWt = <?php echo json_encode($chartSupplierLedgerFineWt); ?>;
    var chartKarigarJamaFineWt = <?php echo json_encode($chartKarigarJamaFineWt); ?>;
    var chartTodayPie = <?php echo json_encode($chartTodayPie); ?>;

    var ticksBars = [];
    for (var i = 0; i < chartLabels.length; i++) {
        ticksBars.push([i + 1, chartLabels[i]]);
    }
    var dataIssue = [], dataSup = [], dataJama = [];
    for (var j = 0; j < chartLabels.length; j++) {
        var x = j + 1;
        dataIssue.push([x - 0.2, chartIssueEntry[j] || 0]);
        dataSup.push([x, chartSupplierLedger[j] || 0]);
        dataJama.push([x + 0.2, chartKarigarJama[j] || 0]);
    }
    var dataIssueFw = [], dataSupFw = [], dataJamaFw = [];
    for (var k = 0; k < chartLabels.length; k++) {
        var x = k + 1;
        dataIssueFw.push([x - 0.2, chartIssueEntryFineWt[k] || 0]);
        dataSupFw.push([x, chartSupplierLedgerFineWt[k] || 0]);
        dataJamaFw.push([x + 0.2, chartKarigarJamaFineWt[k] || 0]);
    }

    function initCharts() {
        if (typeof jQuery === 'undefined' || typeof jQuery.plot !== 'function') return;
        var $ = jQuery;

        // Bar chart: last 7 days
        var $bars = $('#ledger-chart-bars');
        if ($bars.length) {
            $.plot($bars,
                [
                    { label: 'Issue Entry', data: dataIssue, bars: { show: true, barWidth: 0.18, align: 'center', lineWidth: 0, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 0.8 }] } } },
                    { label: 'Supplier Ledger', data: dataSup, bars: { show: true, barWidth: 0.18, align: 'center', lineWidth: 0, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 0.8 }] } } },
                    { label: 'Karigar Jama', data: dataJama, bars: { show: true, barWidth: 0.18, align: 'center', lineWidth: 0, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 0.8 }] } } }
                ],
                {
                    colors: ['#5ccdde', '#454e59', '#9b59b6'],
                    legend: { show: true, position: 'nw', backgroundOpacity: 0 },
                    grid: { borderWidth: 0, hoverable: true },
                    yaxis: { min: 0, tickColor: '#f5f5f5', tickFormatter: function(v) { return '₹ ' + v; } },
                    xaxis: { ticks: ticksBars, tickColor: '#f5f5f5' }
                }
            );
        }

        // Pie chart: today's split
        var pieData = [];
        var totalToday = 0;
        for (var p = 0; p < chartTodayPie.length; p++) {
            var amt = parseFloat(chartTodayPie[p].amount) || 0;
            totalToday += amt;
            if (amt > 0)
                pieData.push({ label: chartTodayPie[p].label + ' (₹' + amt.toFixed(0) + ')', data: amt });
        }
        if (pieData.length === 0) pieData = [{ label: 'No data today', data: 1 }];
        var $pie = $('#ledger-chart-pie');
        if ($pie.length && pieData.length) {
            $.plot($pie, pieData, {
                colors: ['#5ccdde', '#454e59', '#9b59b6'],
                legend: { show: false },
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        label: {
                            show: true,
                            radius: 2/3,
                            formatter: function(label, series) {
                                return '<div class="chart-pie-label">' + label + '<br>' + (series.percent ? Math.round(series.percent) + '%' : '') + '</div>';
                            },
                            background: { opacity: 0.75, color: '#000' }
                        }
                    }
                }
            });
        }

        // Fine weight by day (last 7 days)
        var $fineWt = $('#ledger-chart-finewt');
        if ($fineWt.length) {
            $.plot($fineWt,
                [
                    { label: 'Issue Entry', data: dataIssueFw, bars: { show: true, barWidth: 0.18, align: 'center', lineWidth: 0, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 0.8 }] } } },
                    { label: 'Supplier Ledger', data: dataSupFw, bars: { show: true, barWidth: 0.18, align: 'center', lineWidth: 0, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 0.8 }] } } },
                    { label: 'Karigar Jama', data: dataJamaFw, bars: { show: true, barWidth: 0.18, align: 'center', lineWidth: 0, fillColor: { colors: [{ opacity: 0.8 }, { opacity: 0.8 }] } } }
                ],
                {
                    colors: ['#5ccdde', '#454e59', '#9b59b6'],
                    legend: { show: true, position: 'nw', backgroundOpacity: 0 },
                    grid: { borderWidth: 0, hoverable: true },
                    yaxis: { min: 0, tickColor: '#f5f5f5', tickFormatter: function(v) { return v; } },
                    xaxis: { ticks: ticksBars, tickColor: '#f5f5f5' }
                }
            );
        }
    }
    // Run after layout scripts (jQuery, Flot) are loaded
    if (typeof jQuery !== 'undefined' && typeof jQuery.plot === 'function')
        initCharts();
    else
        window.addEventListener('load', function() { initCharts(); });
})();
</script>
