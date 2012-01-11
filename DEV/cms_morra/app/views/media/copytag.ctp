<h2> Copy Tag </h2>
<h3> Id Photo : <?php echo $media['Media']['id']; ?> </h3>
<br/>	
<table border="1" cellpadding="0" cellspacing="0">
	<tr>
		
		<td> 
			<?php 
				echo '<textarea rows ="4" style="width:100%">';
					// echo htmlentities($this->Html->image('upload/'.$media['Media']['id'].'.'.$media['Media']['type'],
						// array('alt'=>$media['Media']['name'],
							  // 'title'=>$media['Media']['name'],
							  // 'width'=>$dimension['width'],
							  // 'height'=>$dimension['height']))
					// );
					
					if ($dimension['width'] >= '430')
					{
						$width = $dimension['width'] * 85/100;
						$height = $dimension['height'] * 85/100;
						
						echo '<?php echo '.'$this->Html->image($pic['.$media["Media"]["id"].'],array("width"=>'.$width.',"height"=>'.$height.')); ?>';
					}
					else
					{
						echo '<?php echo '.'$this->Html->image($pic['.$media["Media"]["id"].'],array("width"=>'.$dimension["width"].',"height"=>'.$dimension['height'].')); ?>';
					}
					
				echo '</textarea>';
			?>
		</td>
	</tr>

	<tr>
		<td><h2> <?php echo $form->Html->link(__('Back', true),'index'); ?> </h2></td> 
		<td colspan='2'> </td>
	</tr>
</table>