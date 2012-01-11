<h2> View CmsProjectList </h2>
<h3> Id CmsProjectList : <?php echo $post['CmsProjectList']['id']; ?> </h3>


<?php 
echo $form->create('CmsProjectList', array('inputDefaults' => array('label' =>false , 'div' => false)));
?>

<table border="1" cellpadding="0" cellspacing="0">
<tr>
	<td> title </td><td> : </td>
	<td> <?php echo $post['CmsProjectList']['title']; ?> </td>
</tr>
<tr>
	<td> description </td><td> : </td>
	<td> <?php echo "<img src='"; echo $post['CmsProjectList']['description'];echo "'>"; ?> </td>
</tr>
<tr>
	<td> category </td><td> : </td>
	<td> <?php echo $post['CmsProjectList']['category']; ?> </td>
</tr>
<tr>
	<td> image1 </td><td> : </td>
	<td> <?php echo $post['CmsProjectList']['image1']; ?> </td>
</tr>
<tr>
	<td> date </td><td> : </td>
	<td> <?php echo $post['CmsProjectList']['date']; ?> </td>
</tr>

<tr>

	<td colspan='2'>  </td>
	<td> <?php echo $form->Html->link(__('Back', true),'index'); ?> </td>
</tr>
</table>
