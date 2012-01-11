<?php
	echo $this->Html->script(array('database','project','cancel'),false);
?>
		
	<h2 class="hasMeta">Database</h2>
		<p class="isMeta"><?php echo $countDb.' Database Found'; ?></p>
		
			<table>

				<colgroup>
					<col/>
					<col class="isTimestamp"/>
				</colgroup>
				<thead>
					<tr>
						<th>Database Name</th>
						<th>Last Edited</th>
					</tr>
				</thead>
				<tbody>
				
					<?php foreach ($simpledbs as $simpledb): ?>
												
					<tr>
						<td>
							<span class="isAction">
								<?php echo $html->link(__('Delete', true), array('controller'=>'simpledbs','action' => 'delete', $simpledb['Simpledb']['id']), null, sprintf(__('Deleting a database %s will delete all the sub-entries within. Are you sure?', true), $simpledb['Simpledb']['title'])); ?>
							</span>
						
							<h5>
								<?php 
									echo $this->Html->link($simpledb['Simpledb']['title'],array('controller'=>'project_lists','action'=>'index',$simpledb['Simpledb']['id']));
								?>
							</h5>
						</td>
						<td>
							<?php
								echo date('d-m-Y @ H:i',$jakarta+strtotime($simpledb['Simpledb']['modified']));
								
								//echo $simpledb['Simpledb']['modified'];
							?>
						</td>
					</tr>
						
					<?php endforeach; ?>
					
					<tr id="tr_add_database">
						<td><input id="add-new-database" type="button" value="Add New Database"></td>
						<td></td>
					</tr>
					
					<tr id="add-new-database-form">
						<td>	
							<label>New Database</label>
							<?php echo $this->Form->create('Simpledb', array('action'=>'add')); ?>
							<input id="title" type="text" size="40" name="data[Simpledb][title]" value="" class="space8">
							<?php echo $this->Js->submit('Submit',array('confirm'=>'Are you sure?','div'=>false,'id'=>'hello')); ?>
							<input id='add-new-database-form-cancel' type="button" value="Cancel" class="isOff">
							<?php echo $this->Form->end(); ?>
						</td>
						<td></td>
					</tr>
					 
				</tbody>
			</table>
		
		
		<div class="clearFix"></div>
		
		<div>
			<a href="<?php echo $_SESSION['back']; ?>">Back to Previous Page</a>
			<?php $_SESSION['back'] = htmlentities($_SERVER['REQUEST_URI']); ?>
		</div>