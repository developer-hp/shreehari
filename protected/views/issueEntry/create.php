<?php
/* @var $this IssueEntryController */
/* @var $model IssueEntry */

$this->breadcrumbs=array(
	'Issue Entry'=>array('admin'),
	'Create',
);
?>

<div class="row">
	<div class="col-md-12">
		<div class="block">
			<div class="block-title">
				<h2>Issue Entry - Create</h2>
			</div>
			<div class="block-content">
				<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
			</div>
		</div>
	</div>
</div>

