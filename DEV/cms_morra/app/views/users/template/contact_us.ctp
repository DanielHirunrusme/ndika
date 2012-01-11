<?php
	echo $this->Html->script('contact');
?>

<!-- Page: Contacts -->
<div class="">
	
	<!-- Left Column -->
	<div class="mr_LeftColumn">
	
		<!-- Heading Block -->
		<div class="mr_Block adjustBlockBG">
			<h1><?php //echo $atribut['Page Heading'] ?></h1>
			<?php echo $content; ?>
			<ul id="mr_SocMedList" class="isLarge">
				<li class="isFacebook"><a href="<?php echo $atributSite['Facebook']; ?>" target="_blank">Like us</a></li>
				<li class="isTwitter"><a href="<?php echo $atributSite['Twitter']; ?>" target="_blank">Follow us</a></li>
			</ul>
			<div class="clearFix"></div>
		</div>	
	</div>

	<!-- Right Column -->
	<div class="mr_RightColumn">
	
		<!-- Block -->
		<div class="mr_Block adjustBG byEmail">
			<h5 class="isLast"><a href="mailto:<?php echo $atributSite['Email']; ?>"><?php echo $atributSite['Email']; ?></a></h5>
		</div>
		
		<!-- Block -->
		<div class="mr_Block adjustBG byPhone">
			<h4 class="isLast"><?php echo $atributSite['Phone']; ?></h4>
		</div>
		
		<!-- Block -->
		<div class="mr_Block adjustBG byPostal">
			<p class="isLast"><?php echo $atributSite['Address']; ?></p>
		</div>
		
		<!-- Block -->
		
		<div id="mr_Form" class="mr_Block adjustBG theForm">
			
			<div id="responseName">name</div>
			<div id="responseEmail">email</div>
			<div id="responseSubject">subject</div>
			<div id="responseMessage">message</div>
			<div id="responseReport">report</div>
		
			<?php echo $this->Form->create('User',array('action'=>'sendmail')); ?>			
				<input name="data[contact][page_id]" type="hidden" value="<?php echo $id; ?>">
				<div><label>Name</label><input name="data[contact][name]" type="text" size="24" id="dname"></div>
				<div><label>E-mail</label><input name="data[contact][email]" type="text" size="24" id="demail"></div>
				<div><label>Subject</label><input name="data[contact][subject]" type="text" size="24" id="dsubject"></div>
				<textarea name="data[contact][body]" rows="5" id="dmessage"></textarea>
				<input type="image" src="<?php echo Router::url("/"); ?>img/icon/send_button.png" class="mr_SendButton" id="sendmail">
				
				<div class="clearFix"></div>
			<?php echo $this->Form->end(); ?>
		</div>

	</div>
	<div class="clearFix"></div>
	
</div>