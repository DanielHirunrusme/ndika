<?php
echo $this->Html->script(array('project','cancel','fancybox/jquery.mousewheel-3.0.4.pack','fancybox/jquery.fancybox-1.3.4.pack'),false); 
echo $this->Html->css(array('fancybox/jquery.fancybox-1.3.4'),'stylesheet', array('inline' => false ) );
//echo "<pre>"; echo print_r($subtitle);echo "</pre>";
?>

	<!--TEMPLATE: MAIN AREA-->
		<h2 class="hasMeta"><?php echo $simpledb['Simpledb']['title']; ?></h2>
		
		<p class="isMeta">
			<?php echo $rowEntry; ?>
			Entries Found
		</p>	
		<table>
			<colgroup>
				<col>
				<col class="isTimestamp">
				<col class="isStatus">
			</colgroup>
			<thead>
				<tr>
					<th>Name</th>
					<th>Created/Edited</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($projects as $newOne):
					$new=array('ProjectList'=>$newOne);
				?>
				<tr>
					<td>
						<?php
							$confirm=null;
							if($new['ProjectList']['ProjectList']['status']==0)
								$status = "Activate";
							else
							{
								$status = "Disable";
								$confirm='Are you sure want to disable '.$new['ProjectList']['ProjectList']['title'];
							}
						?>
						<span class="isAction">
						<?php	
							echo $form->Html->link($status,array('action'=>'change', $new['ProjectList']['ProjectList']['id']),
							null,$confirm);
							echo ' | '; 
							echo $form->Html->link('Delete',array('action'=>'delete', $new['ProjectList']['ProjectList']['id']),
							null,sprintf('If you delete %s. All child of %s will be deleted too. Are you sure want to delete %s ?',
                                              $new['ProjectList']['ProjectList']['title'],
                                              $new['ProjectList']['ProjectList']['title'],
                                              $new['ProjectList']['ProjectList']['title']));
						?>
						</span>
						<span class="cms_Thumbnail">
						<?php
							$mediaId=$new['ProjectList']['ProjectList']['media_id'];
							if ($mediaId==0) { 
								echo $this->Html->image('holder.png', array('alt' => 'CakePHP','width'=>'50'));						 
							}else
								echo $this->Html->image('upload/thumb/'.$medias[$mediaId], array('width'=>'50'));
						?>
						</span>
						<? $b=$new['ProjectList']['ProjectList']['title']; ?>
						<h5><?php echo $form->Html->link($b,array('action'=>'edit', $new['ProjectList']['ProjectList']['id']));?></h5>
												
						<p>
						<?php 
							if (isset($new['ProjectList']['ProjectList']['description'])) {
								echo substr ($new['ProjectList']['ProjectList']['description'],0,30)."..."; 
							}
						?>
						</p>
					</td>
					<td>
						<?php
							//echo date('d-m-Y @ H:i',$jakarta+strtotime($new['ProjectList']['ProjectList']['modified']));
							echo $new['ProjectList']['ProjectList']['modified'];
						?>
					</td>
					<td>
						<span class="cms_Status <?php echo $new['ProjectList']['ProjectList']['status']==0?'isBad':'isGood'; ?>">
						<?php
							if($new['ProjectList']['ProjectList']['status'] ==0)
							{
								echo "Disabled";
							}
							else
								echo "Active";
						?>
						</span>
					</td>
				</tr>
				
				<?php
					$output = array_slice($newOne['ProjectList'], 9);
					$output = array('ProjectList'=>$output,'padding'=>72);
					
					//var_dump($output);
					//die();
					echo $this->element('project_recursive',$output);
				endforeach;
				?>
				
				<!-- ADD NEW ENTRY PROJECT -->
				
				<tr id="tr_entry">
					<td colspan="3"><input class="add_new_entry" value="Add New Entry" type="button"></td>
				</tr>
				<tr class="tambah cms_InlineForm">
					<td colspan="3">
						<?php
							echo $form->create('ProjectList', 
								array('action'=>'add','inputDefaults' => array('label' =>false , 'div' => false)));
							echo $this->Form->hidden('simpledb_id',array('value'=>$simpledbId));
							
						?>
						
						<input name="data[Simpledb][idDatabase]" value="<?php echo $simpledb['Simpledb']['id'];?>" type="hidden">
						<input name="data[Simpledb][tempTitle]" value="<?php echo $simpledb['Simpledb']['title'];?>" type="hidden">
						<input name="data[Simpledb][tempCreated]" value="<?php echo $simpledb['Simpledb']['created'];?>" type="hidden">
						
						<h6>Add New Entry</h6>
						<span class="alignLeft space10">
							<?php echo $form->input('title',array ('size' => 30)); ?>
							<label>Apply entry TITLE for Project</label>
						</span>
						<span class="alignLeft space10">

							<?php echo $this->Form->select('parent_id',$parent_id_isi, '0', array('class'=>'space10','empty'=>false)); ?>
							<label>Parent</label>
						</span>
						<span class="alignLeft">
							<?php echo $form->submit('Add',array('class'=>'space3','div'=>false,'label'=>'false')); ?>
							<input value="cancel" id="11" class="isOff" type="button">
						</span>
						<div class="clearFix"></div>
					</td>
				</tr>
				</tr>
			</tbody>
		</table>
		
		<div>
			<?php
				echo $this->Html->link('Back to Database Page',array('controller'=>'project_lists','action'=>'database'));
			?>
		</div>
		
	</div>