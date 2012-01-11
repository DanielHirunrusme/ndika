<?php
define('IS_SELECTED','class="isSelected"',false);

echo $html->docType('html4-trans');
?>

<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
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
		
            echo $html->css('default');
			echo $html->script('define');
            echo $html->script('jquery');
			echo $html->script('jquery.color');
            echo $scripts_for_layout;
        ?>
	<!-- Date: 2011-10-31 -->
</head>
<body>
<div id="flash_message_container">
    <?php echo $this->Session->flash(); ?>
</div>

<!--MODAL POP-UP OVERLAY-->

<!--OVERLAY-->
<div id="cms_Overlay" class="isHidden">
	<!--SAVED-->
	<span id="cms_Alert" class="isGood">
		You changes have been saved...
	</span>
	
</div>

<?php
if($needThumbBrowser){
	echo $this->element('thumb',array('mediaForElement',$mediaForElement));
}
?>

<!--HEADER-->
<div id="cms_Header" class="">
	<ul id="cms_SignOut">
		<li><h5></h5></li>
		<li><a href="#"></a></li>
		<li><a href="#"></a></li>
	</ul>
	<h1><?php echo $site; ?></h1>
	<ul id="cms_Navigation">
		
	</ul>

</div>

<!--BODY-->
<div id="cms_Body">
    <?php echo $content_for_layout; ?>
</div>

<!--FOOTER-->
<div id="cms_Footer">

</div>

<?php echo $this->element('sql_dump'); ?>

</body>
</html>
