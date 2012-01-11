<?php echo $this->Html->script(
	array('projectatribut','project','cancel','projectList','fancybox/jquery.mousewheel-3.0.4.pack','fancybox/jquery.fancybox-1.3.4.pack'),false); ?>
<?php $this->Html->css(array('fancybox/jquery.fancybox-1.3.4'),'stylesheet', array('inline' => false ) ); 
//echo "<pre>"; echo print_r($post);echo "</pre>";
?>

<!--BODY-->
<?php
	echo $this->Form->create('ProjectList',array('action'=>'addMedia'));
?>
	
<?php
	//echo $this->Form->submit('Halo');
	echo $this->Form->end();
?>


<?php echo $form->create('ProjectList', array ('type'=>'file','class'=>'notif-change'));?>
<div class="cms_PageButton">
	<input type="submit" value="Save">
	<input type="button" value="Cancel" class="isOff" onclick="javascript: window.location=site+'project_lists/index/<?php echo $simpledbId; ?>'">
</div>
<h2 class="hasMeta">Edit <?php echo $post['ProjectList']['title']; ?></h2>

<p class="isMeta">Last Modified : <?php echo $post['ProjectList']['modified']; ?></p>
<table >
	<colgroup>
		<col class="isLabel">
		<col>
	</colgroup>
	<tbody><tr class="isHeader">
		<th colspan="2">Project Detail</th>

	</tr>
	
	<tr>
		<th><label>Project Title</label></th>
		<td>
		<input type="hidden" value="<? echo $post['ProjectList']['id']; ?>" size="50" name="data[ProjectList][id]" />
		<input type="hidden" value="<? echo $post['ProjectList']['simpledb_id']; ?>" size="50" name="data[ProjectList][simpledb]" />
		<input type="text" value="<? echo $post['ProjectList']['title']; ?>" size="50" name="data[ProjectList][title]" />
		</td>
	</tr>
	
	
	
	<tr>
		<th class="isTop"><label>Description</label></th>
		<td>
		
		<textarea type="text"  size="30" rows="4" cols="59" name="data[ProjectList][description]"><? echo $post['ProjectList']['description']; ?></textarea>
		</td>

	</tr>
				<tr>
		<th><label>Child of</label></th>
		<td>
			<?php echo $this->Form->select('parent_id',$parent_id_isi); ?>
		</td>
	</tr>
	<tr>
		<th class="isTop"><label>Images</label></th>

		<td>
			<?php echo $this->Form->hidden('media_id'); ?>
			<div id="deleted-images" style="display:none"></div>
			<div id="primary-image" class="cms_ThumbnailContainer doSelect">
					<?php foreach ($media_parent_added as $key => $q): ?>
						<span class="cms_Thumbnail isParent">
						<div class="media-id" style="display:none"><?php echo $q['Media']['id']; ?></div>
						<?php echo $this->Html->image('upload/thumb/'.$q['Media']['id'].'.'.$q['Media']['type'], 
						array('alt' => $q['Media']['name'],'title' => $q['Media']['name'],'width'=>'50','heigth'=>'50px')); ?>
						</span>
					<?php endforeach; ?>
					<?php foreach ($media_added as $key => $q): ?>
						<span class="cms_Thumbnail isChild">
						<div class="media-id" style="display:none"><?php echo $q['Media']['id']; ?></div>
						<?php echo $this->Html->image('upload/thumb/'.$q['Media']['id'].'.'.$q['Media']['type'], 
						array('alt' => $q['Media']['name'],'title' => $q['Media']['name'],'width'=>'50','heigth'=>'50px')); ?>
						</span>
					<?php endforeach; ?>
				<div class="clearFix"></div>	
			</div>
			<span class="cms_Thumbnail">
				<div class="media-id" style="display:none"><?php echo $q['Media']['id']; ?></div>
				<?php
					if($primaryImage!==false)
						echo $this->Html->image('upload/thumb/'.$primaryImage['Media']['id'].'.'.$primaryImage['Media']['type'], 
							array('id'=>'primary-image-show','alt' => $primaryImage['Media']['name'],'title' => $primaryImage['Media']['name'],'width'=>'84px','heigth'=>'84px'));
					else echo $this->Html->image('upload/thumb/holder.png', 
							array('id'=>'primary-image-show','alt' => $primaryImage['Media']['name'],'title' => $primaryImage['Media']['name'],'width'=>'84px','heigth'=>'84px'));

				?>
			</span>							
			<div class="clearFix"></div>
			
			<!-- Media -->
			<!-- Media -->
			<!-- Media -->
			<div>
				<?php echo $this->Form->hidden('ProjectListMedia.Project_list_id',array('value'=>$projectListId));?>
				<?php echo $this->Form->input('Media.name',array('type'=>'file','div'=>false,'label'=>false));?>
				<a href="#set-as-primary-image" class="primary-id isHidden">Set as primary image</a>
				<span class="primary-temp">Select an image to set it as primary or to delete</span>
				<span class="separate-id isHidden">|</span>
				<a href="#delete-image" class="delete-id isHidden">Delete</a>
				<p class="isLabel">or
				<a id="upload_media" href="#34">Add photos from media<a>
				</p>
			</div>
			<!-- Media -->
			<!-- Media -->
			<!-- Media -->
		</td>
	
		
	</tr>
	<!-- ATTRIBUT -->
	<!-- ATTRIBUT -->
	<!-- ATTRIBUT -->
	<!-- ATTRIBUT -->
	
	<?php echo $form->end(); ?>
	
	<!----------------------------->
	
	<tr class="isHeader">
		<th colspan="2">Attributes</th>
	</tr>
	
	<?php
		$atribs=array();
		foreach ($cobas as $coba):
			$atribs[$coba['Atribut']['id']]=$coba['Atribut']['name'];
		endforeach;	
	?>
	
	<tr class="project-info isHidden">
		<th>
			<label></label>
		</th>
		<td>
		</td>
	</tr>
	
	<?php foreach ($projectIds as $projectId): ?>
		<tr class="project-info">
			<th>
				<label><?php echo $atribs[$projectId['ProjectListDetail']['Project_list_atribut_id']]; ?></label>
			</th>
			<td>
				<input name="<?php echo 'data[ProjectList][coba'.$projectId['ProjectListDetail']['id'].']'; ?>" value="<?php echo $projectId['ProjectListDetail']['value']; ?>" size="50" type="text">
			</td>
		</tr>
	<?php endforeach; ?>
	
	<!----------------------------->
	
	
	<!-- TAMBAH ATRIBUT BARU -->	
	
	<tr id="tr_atrib">
		<td></td>
		<!-- <td colspan="1"><a id="add_new_atrib" href="#">Add New Attribute</a></td> -->
		<td colspan="3"><input id="add_new_atrib" type="button" value="Add New Attribute"></td>
	</tr>
	<tr class="form_atribut" id="add-new-atribut-form">
		<th><label>New Attribute Label</label></th>
		<td>
			<?php echo $form->create('ProjectList',array('action'=>'addlist'));?>
				<?php echo $form->input('idProject',array('type'=>'hidden','value'=>$id)); ?>
				<?php echo $form->input('atribValue',array('type'=>'hidden','value'=>'')); ?>
				<input type="text" size="30" class="space10" name="data[Atribut][name]" id="content"/>
				<?php echo $this->Js->submit('Submit',array('id'=>'bSubmit','confirm'=>'Are you sure?','div'=>false)); ?>
				<?php //echo $form->Submit('Add', array('class'=>'space3','div'=>false)); ?>
				<input id = "14" type="Button" value="Cancel" class="isOff">
			<?php echo $form->end(); ?>
		</td>	
	</tr>
						
</tbody>
</table>