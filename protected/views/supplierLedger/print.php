<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Print Supplier Voucher</title>
    <style>
        body { margin: 10px; font-family: Arial, sans-serif; }
        @page { margin: 8mm; }
    </style>
</head>
<body>
<?php $this->renderPartial('viewPdf', array('model' => $model)); ?>
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
