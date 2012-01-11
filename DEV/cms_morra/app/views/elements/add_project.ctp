<?php
	echo $this->Html->script('project',false);
?>

<!--MODAL POP-UP-->
<div id="cms_Modal" class="isSmall isHidden add-new-project">
    <h3>Create New Database</h3>
    <div class="cms_ModalBody">
	<?php echo $this->Form->create('Simpledb',array('action'=>'add')); ?>
	<label class=”isBlock”>Database Name </label><?php echo $this->Form->input('title',array('id'=>'idTitle','div'=>false,'label'=>'')); ?>
    </div>
    <div class="cms_ModalFooter">
	<input type="button" value="Cancel" class="isOff" onclick="javascript: $('.add-new-project').fadeOut('fast'); ">
	<input type="submit" value="Add" class="space10">
	<div class="clearFix"></div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>