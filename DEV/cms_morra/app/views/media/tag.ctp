<h3>COPY TAG</h3>

<div class="cms_ModalBody">
	<h5>File Name : <?php echo $media['Media']['name']; ?></h5>
	
	<table>
		<tr>
			<td> 
				<?php 
					echo '<textarea rows ="4" style="width:100%">';
						
					echo '<?php echo '.'$this->Html->image($pic['.$media["Media"]["id"].']); ?>';
						
					echo '</textarea>';
				?>
			</td>
		</tr>
	</table>
	
</div>

<div class="cms_ModalFooter">
	<input type="button" value="Close" class="isOff" onclick="javascript: $('.tag-notification').fadeOut('fast');" />
	<div class="clearFix"></div>
</div>