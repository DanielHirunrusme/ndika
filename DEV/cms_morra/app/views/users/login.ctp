<div id="cms_Body">
	
	<!--LOG IN FORM-->
	<div id="cms_Main" class="isLoginForm">
	<?php echo $this->Form->create('User', array ('action'=>'login'));?>
		<?php //echo $this->Session->flash(); ?>
		<?php
			$status=$this->Session->flash('auth');
			if($status!==false):
		?>
			<div id="cms_Alert" class="isBad"><?php echo $status; ?></div>
		<?php endif; ?>
		<h3>Log In</h3>
		
		<?php echo $this->Form->input('email',array('label'=>'E-mail Address','size'=>36)); ?>
		<?php echo $this->Form->input('password',array('size'=>36)); ?>
		<div>
			<?php echo $this->Form->submit('Login',array('div'=>false)); ?>
			<input type="button" value="Cancel" class="isOff space10">			
			<?php echo $this->Html->link('Forget password?',array('controller'=>'users','action'=>'forget')); ?>
		</div>
		
	<?php echo $this->Form->end(); ?>
	</div>
</div>
