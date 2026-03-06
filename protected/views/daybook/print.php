<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Print Day Book</title>
    <style>
        body { margin: 0; padding: 8mm; font-family: Arial, sans-serif; color: #111; }
        @page { size: A4 portrait; margin: 8mm; }
        .print-date { margin-bottom: 10px; font-size: 13px; font-weight: 700; }
        .daybook-table-wrap { width: 100%; }
        .daybook-table { width: 100%; }
    </style>
</head>
<body>
<div class="print-date">DATE : <?php echo CHtml::encode($selectedDateDisplay); ?></div>
<?php $printMode = true; ?>
<?php $this->renderPartial('_table', get_defined_vars()); ?>
<script type="text/javascript">
(function() {
    window.onload = function() {
        window.print();
        setTimeout(function(){ window.close(); }, 300);
    };
})();
</script>
</body>
</html>
