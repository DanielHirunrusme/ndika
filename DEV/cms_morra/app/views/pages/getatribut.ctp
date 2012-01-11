<?php
	$atribs=array();
	foreach ($tests as $atribut):
		$atribs[$atribut['Atribut']['id']]=$atribut['Atribut']['name'];
	endforeach;
?>

<tr class="page-info">
	<th>
		<label><?php echo $atribs[$pageAttribute['PageDetail']['atribut_id']]; ?></label>
	</th>
	<td>
		<input name="<?php echo 'data[Page][coba'.$pageAttribute['PageDetail']['id'].']'; ?>" value="<?php echo $pageAttribute['PageDetail']['value']; ?>" size="43" type="text">
	</td>
</tr>