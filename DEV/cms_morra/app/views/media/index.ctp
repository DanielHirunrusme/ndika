<?php
	//echo $this->Html->script('kosong',false);
	//session_start();
	//echo $this->Html->script('zeroclipboard/ZeroClipboard',false);
	echo $this->Html->script('media',false);
	echo $this->Html->css('customize',false);
?>
<div class="cms_MediaUpload">
<?php echo $form->create('Media', array('action'=>'add','type'=>'file', 'inputDefaults' => array('label' =>false , 'div' => false)));?>
	<input id="textbox-file" type="file" size="16" name="data[Media][name]" class="space5">
	<input id="button-submit" type="button" value="Upload">
	
</div>
<h2 class="hasMeta">Media Library</h2>

<p class="isMeta"><?php echo $count; ?> Files uploaded</p>

<table>
	<colgroup>
		<col>
		<col class="isStatus">
		<col class="isTimestamp">
	</colgroup>
	<thead>
		<tr>
			<th>File Name</th>
			<th>Size</th>
			<th>Created</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($media as $p): ?>
		<tr>
			<td>
				<span class="isAction">
					<a href="#copy-notification-<?php echo $p['Media']['id']; ?>">Copy Tag<a> |
					<a href="#delete-notification-<?php echo $p['Media']['id']; ?>">Delete</a>
				</span>
				<span class="cms_Thumbnail">
					<?php echo $this->Html->image('upload/thumb/'.$p['Media']['id'].'.'.$p['Media']['type'], array('alt' => $p['Media']['name'],'title' => $p['Media']['name'],'width'=>'50')); ?>
				</span>
<?php $b = $p['Media']['name'];?>
				
				<h5>
					<?php 
						//echo $form->Html->link($b,array('action'=>'view', $p['Media']['id']));
						echo $b;
					?>
				</h5>
			</td>
			<td>
				<?php echo $p['Media']['size']/1000; ?> kb
			</td>
			<td><?php echo $p['Media']['modified']; ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div>
	<a href="<?php echo $_SESSION['back']; ?>">Back to Previous Page</a>
	<?php $_SESSION['back'] = htmlentities($_SERVER['REQUEST_URI']); ?>
</div>

</div>
<div id="cms_Modal" class="media-notification isMedium isHidden">

</div>

<div id="cms_Modal" class="tag-notification isMedium isHidden">

</div>