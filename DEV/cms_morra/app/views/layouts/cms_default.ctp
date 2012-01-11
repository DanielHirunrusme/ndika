<?php
define('IS_SELECTED','class="isSelected"',false);

//var_dump($simpledbs);
//die();

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
		
            echo $html->css('morra_cms');
			echo $html->script('define');
            echo $html->script('jquery');
			echo $html->script('jquery.color');
			echo $html->script('admin');
            echo $scripts_for_layout;
        ?>
	<!-- Date: 2011-10-31 -->
</head>
<body>
<!--MODAL POP-UP OVERLAY-->

<?php
if($needThumbBrowser){
	echo $this->element('thumb',array('mediaForElement',$mediaForElement));
}
echo $this->element('add_project');
?>

<!--HEADER-->
<div id="cms_Header" class="">
	<ul id="cms_SignOut">
		<li><h5><?php echo $user['User']['username']; ?></h5></li>
		<li><?php echo $this->Html->link('Visit Site',array('controller'=>'users','action'=>'index'),array('target'=>'_blank')); ?></li>
		<li><?php echo $this->Html->link('Sign Out',array('controller'=>'users','action'=>'logout')); ?></li>
	</ul>
	<h1><?php echo $site; ?></h1>
	<ul id="cms_Navigation">
		<li <?php echo $activePage=='Index'?IS_SELECTED:''; ?>><a href="#">Home</a></li>
		<li <?php echo $activePage=='Profiles'?IS_SELECTED:''; ?>><?php echo $this->Html->link('Profile',array('controller'=>'site_profiles','action'=>'index')); ?></li>
		<li <?php echo $activePage=='Media'?IS_SELECTED:''; ?>><a href="#"><?php echo $this->Html->link('Media Library',array('controller'=>'media','action'=>'index')); ?></a></li>
		<li <?php echo $activePage=='Pages'?IS_SELECTED:''; ?>><?php echo $this->Html->link('Pages',array('controller'=>'pages','action'=>'index')); ?></li>
		<li <?php echo $activePage=='User'?IS_SELECTED:''; ?>><?php echo $this->Html->link('User',array('controller'=>'users','action'=>'add')); ?></li>
		<li <?php echo $activePage=='Database'?IS_SELECTED:''; ?>><?php echo $this->Html->link('Database',array('controller'=>'project_lists','action'=>'database')); ?></li>
		<!-- <li class="isNew"><a href="#">Add New</a></li> -->
	</ul>

</div>

<!--BODY-->
<div id="cms_Body">
	<div id="cms_Main">
		<?php echo $this->Session->flash(); ?>
		<?php echo $content_for_layout; ?>
	</div>
</div>

<!--FOOTER-->
<div id="cms_Footer">

</div>

<?php echo $this->element('sql_dump'); ?>

</body>
</html>
