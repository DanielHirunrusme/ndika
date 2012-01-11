<h3> Add CmsProjectList </h3>

<?php 
echo $form->create('CmsProjectList', array('inputDefaults' => array('label' =>false , 'div' => false)));
?>

<table>
<tr>
	<td> title </td><td> : </td>
	<td> <?php echo $form->input('title',array ('size' => 30)); ?> </td>
</tr>
<tr>
	<td> description </td><td> : </td>
	<td> <?php echo $form->textarea('description', array ('cols' => 40,'rows' => 4) ); ?> </td>
</tr>
<tr>
	<td> category </td><td> : </td>
	<td> <?php echo $form->input('category'); ?> </td>
</tr>
<tr>
	<td> created_by </td><td> : </td>
	<td> <?php echo $form->input('created_by'); ?> </td>
</tr>
<tr>
	<td> image1 </td><td> : </td>
	<td> <?php echo $form->input('image1'); ?> </td>
</tr>
<tr>
	<td> date </td><td> : </td>
	<td> <?php echo $form->input('date'); ?> </td>
</tr>
<tr>
	<td colspan='2'>  </td>
	<td> <?php echo $form->end('Save'); ?> </td>
</tr>
</table>

