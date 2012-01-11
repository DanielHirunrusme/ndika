<?php
    //var_dump($media);
    //die();
?>
<!--MODAL POP-UP-->
<div id="cms_Modal" class="isMedium isHidden eMedia">
	<h3>Media Library</h3>
	<div class="cms_ModalBody">
		<!---THUMBNAIL CONTAINER-->
		<div id="project-list-media" class="cms_ThumbnailContainer doSelect">
			<?php
				foreach($mediaForElement as $i):
					$filename=$i['Media']['id'].'.'.$i['Media']['type'];
			?>
					<span class="cms_Thumbnail">
						<div class="media-id isHidden"><?php echo $i['Media']['id']; ?></div>
						<?php echo $this->Html->image('upload/thumb/'.$filename,array('width'=>'50px', 'height'=>'50px')); ?>
					</span>
			<?php endforeach; ?>
			<div class="clearFix"></div>	
		</div>
		<div class="clearFix"></div>
	</div>
	<div class="cms_ModalFooter">
		<input type="button" value="Close" class="isOff">
		<input type="button" value="Add" class="space10">
		<div class="clearFix"></div>
	</div>
</div>