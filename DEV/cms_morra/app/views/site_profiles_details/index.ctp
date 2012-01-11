<?php 
	echo $this->Html->script(
	array('project','cancel','projectList','fancybox/jquery.mousewheel-3.0.4.pack','fancybox/jquery.fancybox-1.3.4.pack'),false);
?>

<?php
	echo $form->create('SiteProfile', array('action'=>'save','class'=>'notif-change','inputDefaults' => array('label' =>false , 'div' => false)));
?>

<div align="right" class="cms_PageButton">
	<input type="submit" value="Save">
	<input type="button" value="Cancel" class="isOff" onclick="javascript: window.location=site+'pages/'">
</div>
		
		<h2>Edit Site Profile</h2>
		<p class="isMeta"></p>
		<div class="splitLeft">

			<table>
				<colgroup>
					<col class="isLabel">
					<col>
				</colgroup>
				<tbody>
					<tr class="isHeader">
						<th colspan="2">Basic Setting</th>
					</tr>
					
					<tr>
						<th><label>Site Title</label></th>
						<td>
						<input name="data[SiteProfile][id]" value="<?php echo $profile['SiteProfile']['id'];?>" size="43" type="hidden">
						<input name="data[SiteProfile][site_title]" value="<?php echo $profile['SiteProfile']['site_title'];?>" size="43" type="text"></td>
					</tr>
					<tr>
						<th><label>Site URL</label></th>
						<td><input name="data[SiteProfile][site_url]" value="<?php echo $profile['SiteProfile']['site_url'];?>" size="43" type="text"></td>

					</tr>
					<tr>
						<th class="isTop"><label>Site Description</label></th>
						<td>
							<textarea type="text" name="data[SiteProfile][site_description]" 
							cols="50" rows="2"><?php echo $profile['SiteProfile']['site_description'];?> </textarea>
							<label class="isMeta">150 words or less to describe what it is</label>
						</td>

					</tr>
					<tr class="isHeader">
						<th colspan="2">Page Meta &amp; Script</th>
					</tr>
					<tr>
						<th class="isTop"><label>Header</label></th>
						<td><textarea type="text" name="data[SiteProfile][header]" 
						 cols="50" rows="3"><?php echo $profile['SiteProfile']['header'];?></textarea></td>

					</tr>
					<tr>
						<th class="isTop"><label>Body (Top)</label></th>
						<td><textarea type="text" 
						name="data[SiteProfile][top]"  cols="50" rows="3"><?php echo $profile['SiteProfile']['top'];?></textarea></td>
					</tr>
					<tr>
						<th class="isTop"><label>Body (Bottom)</label></th>

						<td><textarea type="text"
						name="data[SiteProfile][bottom]"  cols="50" rows="3"><?php echo $profile['SiteProfile']['bottom'];?></textarea></td>
					</tr>
					
					<?php echo $form->end(); ?>
					
					<tr class="isHeader">
						<th colspan="2">Attributes</th>
					</tr>
					
					<tr id="tr_atrib">
						<td></td>
						<td colspan="1"><a id="add_new_atrib" href="#form_atribut">Add New Attribute</a></td>
					</tr>
					
					<tr class="form_atribut">
						<th><label>New Attribute Label</label></th>
						<td>
							<?php echo $form->create('SiteProfile',array('action'=>'add'));?>
								<input type="text" size="30" class="space10" name="data[Atribut][name]"/>
								<?php echo $form->Submit('Add', array('class'=>'space3','div'=>false)); ?>
								<input id = "14" type="Button" value="Cancel" class="isOff">
							<?php echo $form->end(); ?>
						</td>	
					</tr>
					
				</tbody>
			</table>
			
		</div>
		
		<div class="splitRight">
			
			<!--STATUS & SAVE BUTTON-->
			<div class="cms_Module">

				<h5 class="cms_SidebarTitle">Status</h5>
				<table>
					<colgroup>
						<col class="isMetaLabel">
						<col>
					</colgroup>
					<tbody>
						<tr>

							<th><label>Created:</label></th>
							<td>
								<h5><?php echo $user['User']['username']; ?></h5>
								<p><?php echo $profile['SiteProfile']['created']; ?></p>
							</td>
						</tr>
						<tr>

							<th><label>Edited:</label></th>
							<td>
								<h5><?php echo $user['User']['username']; ?></h5>
								<p><?php echo $profile['SiteProfile']['modified']; ?></p>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
			
			<div class="cms_Module">
				<h5 class="cms_SidebarTitle">CSS</h5>
				<ul class="cms_SidebarList">
					<?php foreach($css as $x): ?>
					<li>
						<span class="isAction">
							<?php
								echo $this->Html->link('Download', array('action'=>'downloadCss',$x['name']),array(), 'Are you sure want to download '.$x['name'].' ?');
								echo ' | ';
								echo $this->Html->link('Delete', array('action'=>'deleteCss',$x['name']),array(), 'Are you sure want to delete '.$x['name'].' ?');
							?>
						</span>
						<h6><?php echo $x['name']; ?></h6>
						<p>Uploaded: <?php echo $x['uploaded']; ?></p>
					</li>
					<?php endforeach; ?>
					
					<li class="isUpload">
						<?php
							echo $this->Form->create('SiteProfile',array('action'=>'uploadCss','type'=>'file'));
							echo $this->Form->input('css',array('type'=>'file','size'=>14,'div'=>false,'label'=>false));
						?>
							<input type="submit" value="upload" class="isSmall alignRight">
						<?php
							echo $this->Form->end();						
						?>
					</li>
				</ul>
			</div>
			
			<div class="cms_Module">
				<h5 class="cms_SidebarTitle">JavaScript</h5>
				<ul class="cms_SidebarList">
					<?php foreach($js as $x): ?>
					<li>
						<span class="isAction">
							<?php
								echo $this->Html->link('Download', array('action'=>'downloadJs',$x['name']),array(), 'Are you sure want to download '.$x['name'].' ?');
								echo ' | ';
								echo $this->Html->link('Delete', array('action'=>'deleteJs',$x['name']),array(), 'Are you sure want to delete '.$x['name'].' ?');
							?>
						</span>
						<h6><?php echo $x['name']; ?></h6>
						<p>Uploaded: <?php echo $x['uploaded']; ?></p>
					</li>
					<?php endforeach; ?>
					
					<li class="isUpload">
						<?php
							echo $this->Form->create('SiteProfile',array('action'=>'uploadJs','type'=>'file'));
							echo $this->Form->input('js',array('type'=>'file','size'=>14,'div'=>false,'label'=>false));
						?>
							<input type="submit" value="upload" class="isSmall alignRight">
						<?php
							echo $this->Form->end();						
						?>
						<div class="clearFix"></div>
					</li>
				</ul>
			</div>
		</div>
		<div class="clearFix"></div>
		
		<div>
			<a href="<?php echo $_SESSION['back']; ?>">Back to Previous Page</a>
			<?php $_SESSION['back'] = htmlentities($_SERVER['REQUEST_URI']); ?>
		</div>