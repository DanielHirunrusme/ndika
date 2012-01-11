<?php
	$atribs=array();
	foreach ($cobas as $atribut):
		$atribs[$atribut['Atribut']['id']]=$atribut['Atribut']['name'];
	endforeach;
?>

<tr class="project-info">
	<th>
		<label><?php echo $atribs[$projectId['ProjectListDetail']['Project_list_atribut_id']]; ?></label>
	</th>
	<td>
		<input name="<?php echo 'data[ProjectList][coba'.$projectId['ProjectListDetail']['id'].']'; ?>" value="<?php echo $projectId['ProjectListDetail']['value']; ?>" size="50" type="text">
	</td>
</tr>