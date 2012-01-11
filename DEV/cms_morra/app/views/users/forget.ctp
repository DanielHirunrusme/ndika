<div id="cms_Body">
<!--FORGET PASSWORD FORM-->
	<div id="cms_Main" class="isLoginForm">
	<?php
		echo $this->Session->flash('auth');
	        echo $this->Session->flash();
	        echo $this->Session->flash('email');
	?>
	<?php echo $this->Form->create('User'); ?>
	<h3>Forget Password</h3>
	<div>
		<label>E-mail Address</label>
		<?php echo $this->Form->input('email',array('size'=>36,'div'=>false,'label'=>'')); ?>
	</div>
	<div>
		<?php echo $this->Form->submit('Send Me My Password',array('div'=>false,'label'=>'')); ?>
		<input type="button" value="Cancel" onclick="javascript: windows.location=<?php echo FULL_BASE_URL; ?>">
	</div>
	<?php echo $this->Form->end(); ?>
	</div>
</div>