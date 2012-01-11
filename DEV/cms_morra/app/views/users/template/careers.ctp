<?php
	if (!isset($_SESSION['career']))
	{
		$_SESSION['career'] = 'career';
	}
?>

<?php
	echo $this->Html->script('career');
	echo $this->Html->script('split');
?>

<!-- Page: Careers -->
<div class="">
	
	<!-- Left Column -->
	<div class="mr_LeftColumn">
	
		<!-- Heading Block -->
		<div class="mr_Block adjustBlockBG">
			<h1><?php echo $atributPage['Page Heading']; ?></h1>
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

	<!-- Right Column -->
	<div class="mr_RightColumn">
		<div id="list-panel">
			<div class="mr_Block adjustBG">
				<h3>We are looking for:</h3>
				<ol class="mr_CareerList">
					<?php
						$link1 = explode(" ", $title);
						$link2 = implode("_", $link1);
						
						$_SESSION['career'] = strtolower($link2);
					?>
						
					<input type="hidden" value="<?php echo $_SESSION['career']; ?>" class="coba">
					
					
					<?php foreach($project['Careers'] as $info): ?>
					
					<?php
						$project1 = explode(" ", $info['title']);
						$project2 = implode("_", $project1);
					?>
					
					<li class="cProject">
						<a class="show" href="#<?php echo strtolower($link2).'/'.$project2; ?>"><div class="project-id" style="display:none"><?php echo $info['id']; ?></div><?php echo $info['title']; ?></a>
						
						<div class="coba" style="display:none"><?php echo strtolower($link2); ?></div>
						
						<div class="careerDesc" style="display:none"><?php echo $project2; ?></div>
						
						<input type="hidden" value="<?php echo $info['id']; ?>" class="careerId">
						
						<input type="hidden" value="<?php echo $id; ?>" class="hal-id">
						
					</li>
					
					<?php endforeach; ?>
				</ol>
				<p class="lowMargin">These are a few open positions that we currently have. Click on individual position to learn more about the details.</p>
			</div>
		</div>
		
		<div id="info-panel" style="display:none">
			<!-- Block -->
			<div class="mr_Block adjustBG">
				<h3 class="lowMargin">We are looking for:</h3>
				<select class="dropbox">
					<?php foreach($project['Careers'] as $sub_info): ?>
						<option value="<?php echo $sub_info['id']; ?>"><?php echo $sub_info['title']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php foreach($project['Careers'] as $info): ?>
			<div id="project-desc-<?php echo $info['id']; ?>" style="display:none">
				<div class="mr_Block adjustBG">
					<h6 class="lowMargin"><?php echo $info['title']; ?></h6>
					<?php echo $info['description']; ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="clearFix"></div>
	
</div>