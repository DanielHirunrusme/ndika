<h2> View Photo </h2>
<h3> Id Photo : <?php echo $media['Media']['id']; ?> </h3><br/>

<?php 
echo $form->create('Media', array('inputDefaults' => array('label' =>false , 'div' => false)));
?>

<table border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><?php echo $html->image('upload/'.$media['Media']['id'].'.'.$media['Media']['type'], array('alt' => $media['Media']['name'],'title' => $media['Media']['name'])); ?></td>
	</tr>
	<tr>
		<h2><td> <?php echo"<h2>"; echo $form->Html->link(__('Back', true),'index');echo "</h2>"; ?> </td></h2> 
		<td colspan='2'> </td>
	</tr>
</table>