<?php
//var_dump($siteProfile);
//die();
echo $html->docType('html4-trans');
?>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title><?php echo $siteProfile['SiteProfile']['site_title']; ?></title>
	<meta name="author" content="Morra">
        <?php
			if ($iconMedias)
			{
				echo $html->meta('icon', $html->url($favicon));
			}
			else
			{
				echo $html->meta('icon');
			}
			
			echo $html->meta('description', $siteProfile['SiteProfile']['site_description']);
            echo $html->css('user_default');
			echo $html->script('define');
            echo $html->script('jquery');
			echo $html->script('jquery.color');
			echo $html->script('jquery.ba-hashchange.min');
			echo $html->script('frontpage');
            echo $scripts_for_layout;
			echo $siteProfile['SiteProfile']['header'];
        ?>
	<!-- Date: 2011-11-07 -->
</head>
<body>
	<?php echo $siteProfile['SiteProfile']['top']; ?>
	<!-- Canvas: Wrapper to set colors on the following containers -->
	<div id="mr_Canvas" class="isHome">
		
		<!-- Header -->
		<div id="mr_Header">
			<div id="mr_Logo" class="adjustBG">
				<a href="#1">
					<?php echo $this->Html->image($pic[74]); ?>
				</a>
			</div>
			<ul id="mr_Navigation" class="navigation">
				<?php
					foreach($pages as $page):
						if($page['Page']['id']!=1):
				?>
				<li>
					<?php
						$link1 = explode(" ", $page['Page']['title']);
						$link2 = implode("_", $link1);
					?>
				
					<a href="#<?php echo strtolower($link2); ?>"><?php echo $page['Page']['title']; ?></a>
					
					<div class="page-id" style="display:none"><?php echo strtolower($link2); ?></div>
					
					<input type="hidden" name="<?php echo 'data[Page]['.$page['Page']['id'].']'; ?>" value="<?php echo $page['Page']['id']; ?>" class="checking">
					
				</li>
				<?php
						endif;
					endforeach;
				?>
				<!--
				<li><a href="#about-us">about</a></li>
				<li><a href="#services">services</a></li>
				<li class="isSelected"><a href="#partners">partners</a></li>
				<li><a href="#career">career</a></li>
				<li><a href="#contact-us">contact us</a></li>
				-->
			</ul>
			<div class="clearFix"></div>		
		</div>
		
		<!-- Body: Main content area -->
		<div id="mr_Body">
			<!-- EDITABLE CONTENT -->
                        <?php echo $content_for_layout; ?>
		</div>
		
		<!-- Footer -->
		<div id="mr_Footer" class="adjustBG">
			<div id="mr_Footnote">
				<span class="alignLeft">&copy; 2011 Morra | Design: <a href="http://www.corsedesignfactory.com" target="_blank" >Corse Design Factory</a></span>
			</div>
		</div>
	</div>
	<?php echo $siteProfile['SiteProfile']['bottom']; ?>
</body>
</html>
