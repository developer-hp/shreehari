<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Print Ledger Report</title>
    <style>
        body { margin: 10px; font-family: Arial, sans-serif; }
        @page { margin: 8mm; }
    </style>
</head>
<body>
<?php $this->renderPartial('reportPdf', get_defined_vars()); ?>
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
