<!-- Page: Home -->
<div class="">
	
	<!-- Left Column -->
	<div class="mr_LeftColumn">
	
		<!-- Heading Block -->
		<div class="">
			<?php echo $this->Html->image($pic[73]); ?>
		</div>
	
	</div>

	<!-- Right Column -->
	<div class="mr_RightColumn">
	
		<!-- Block -->
		<div class="mr_Block adjustBG">
			<h2><?php echo $atributPage['Page Heading']; ?></h2>
			<?php echo $content; ?>
		</div>
	
		<!-- Address Block -->
		<div class="mr_Address mr_Block">
			<ul id="mr_SocMedList">
				<li class="isFacebook"><a href="<?php echo $atributSite['Facebook']; ?>" target="_blank">Like us</a></li>
				<li class="isTwitter"><a href="<?php echo $atributSite['Twitter']; ?>" target="_blank">Follow us</a></li>
			</ul>
			<h6 class="lowMargin">HELLO MORRA</h6>
			<p>
				<?php echo $atributSite['Address']; ?>
			</p>
			
			<p class="isLast"><?php echo $atributSite['Phone']; ?> &nbsp;&nbsp;&nbsp; <a href="mailto:<?php echo $atributSite['Email']; ?>"><?php echo $atributSite['Email']; ?></a></p>
		</div>

	</div>
	<div class="clearFix"></div>
	
</div>