<?php
	if (!isset($_SESSION['back']))
	{
		$_SESSION['back'] = htmlentities($_SERVER['REQUEST_URI']);
	}
?>

<?php
echo $this->Html->script('pages',FALSE);
echo $this->Html->script('tiny_mce/tiny_mce.js',FALSE);
//echo $this->Html->script('pages_tiny_mce.js');

//echo $this->Js->writeBuffer(); // Write cached scripts
?>
<h2 class="hasMeta">Pages</h2>
<p class="isMeta">List of available pages and templates</p>

<div class="splitLeft">
	<table>
		<colgroup>
			<col/>
			<col class="isTimestamp"/>
			<col class="isStatus"/>
		</colgroup>
		<thead>
			<tr>
				<th>Page Title</th>
				<th>Last Edited</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
		    <?php foreach($pages as $page): ?>
			<tr class="page-info">
			    <td>
				<span class="isAction"><a href="#status-page-<?php echo $page['Page']['id']; ?>" ><?php echo $page['Page']['status']=='0'?'Active':'Disable'; ?></a> | <?php echo $html->link('Delete', array('action'=>'delete',$page['Page']['id']), null,'Are you sure want to delete this page?'); ?></span>
				
				<h5>
					<?php echo $this->Html->link($page['Page']['title'],array('action'=>'edit',$page['Page']['id'])); ?>
				</h5>
				<p><strong><?php echo $page['Page']['title']; ?></strong> - <?php echo $page['Page']['description']; ?></p>
			    </td>
			    <td><?php echo $page['Page']['modified']; ?></td>
			    <td>
				<span id="status-page-<?php echo $page['Page']['id']; ?>" class="cms_Status <?php echo $page['Page']['status']!=0?'isGood':'isBad'; ?>">
				    <?php echo $page['Page']['status']!='0'?'Active':'Disabled'; ?>
				</span>
			    </td>
			</tr>                                        
		    <?php endforeach; ?>
			
			<tr id="tr_add_page"><td colspan="3"><input id="add-new-page" type="button" value="Add New Page"></td></tr>
			<tr id="add-new-page-form">
				<td colspan="3">
					<?php echo $this->Form->create('Page', array('action'=>'addpage')); ?>
					<input id="title" type="text" size="40" name="data[Page][title]" value="">
					<?php echo $this->Form->select('template',$dropbox_template,'default.ctp',array('empty'=>false)); ?>
					<span class="alignRight">
						<?php echo $this->Js->submit('Submit',array('confirm'=>'Are you sure?','div'=>false)); ?>
						<input id='add-new-page-form-cancel' type="button" value="Cancel" class="isOff">
					</span>
					<?php echo $this->Form->end(); ?>
				   
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="splitRight">
	<div class="cms_Module">
		<h5 class="cms_SidebarTitle">Templates</h5>
		<ul class="cms_SidebarList">
			<li>
				<h6><?php echo $defaultTemplate['name']; ?></h6>
				<p>Uploaded: <?php echo $defaultTemplate['uploaded']; ?></p>
			</li>
			<?php foreach($template as $x): ?>
			<li>
				<span class="isAction">
					<?php
						echo $this->Html->link('Download', array('action'=>'downloadTemplate',$x['name']),array(), 'Are you sure want to download '.$x['name'].' template?');
						echo ' | ';
						echo $this->Html->link('Delete', array('action'=>'deleteTemplate',$x['name']),array(), 'Are you sure want to delete '.$x['name'].' template?');
					?>
				</span>
				<h6><?php echo $x['name']; ?></h6>
				<p>Uploaded: <?php echo $x['uploaded']; ?></p>
			</li>
			<?php endforeach; ?>
			<li class="isUpload">
				<?php
					echo $this->Form->create('Page',array('action'=>'uploadTemplate','type'=>'file'));
					echo $this->Form->input('template',array('id'=>'text-template','type'=>'file','size'=>14,'div'=>false,'label'=>false));
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