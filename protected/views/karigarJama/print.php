<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Print Karigar Voucher</title>
    <style>
        body { margin: 10px; font-family: Arial, sans-serif; }
        @page { margin: 8mm; }
    </style>
</head>
<body>
<?php $this->renderPartial('viewPdf', array('model' => $model)); ?>
<?php $returnUrl = Yii::app()->request->getParam('returnUrl', $this->createUrl('view', array('id' => $model->id))); ?>
<script type="text/javascript">
(function() {
    var fallbackUrl = <?php echo CJavaScript::encode($returnUrl); ?>;
    window.onload = function() {
        window.print();
        setTimeout(function() {
            window.close();
            setTimeout(function() {
                if (!window.closed) {
                    window.location.href = fallbackUrl;
                }
            }, 200);
        }, 300);
    };
})();
</script>
</body>
</html>
