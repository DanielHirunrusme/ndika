<h3>WARNING!</h3>
<div class="cms_ModalBody">
	<h6>The following image is currently associated with the following database(s):</h6>
	<table>
		<thead>
			<tr>
				<td>No.</td>
				<td>Database</td>
				<td>Project Title</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$databases = array();
				foreach ($simpledbs as $simpledb):
					$databases[$simpledb['Simpledb']['id']]=$simpledb['Simpledb']['title'];
				endforeach;
			?>
			
			<?php
			    $i=1;
			    foreach($ProjectList as $project):
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $databases[$project['ProjectList']['simpledb_id']]; ?></td>
				<td><?php echo $project['ProjectList']['title']; ?></td>
			</tr>
			<?php
			    $i++;
			    endforeach;
			?>
			<tr>
			</tr>
		</tbody>
	</table>
	
	<div class="clearFix"></div>
	
	<h6>The following image is currently associated with the following project list(s):</h6>
	<table>
		<thead>
			<tr>
				<td>No.</td>
				<td>Database</td>
				<td>Project Title</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$titles = array();
				foreach ($projectlists as $projectlist):
					$titles[$projectlist['ProjectList']['id']]=$projectlist['ProjectList']['title'];
				endforeach;
			?>
		
			<?php
			    $i=1;
			    foreach($findProjectMedias as $findProjectMedia):
			?>
			<tr>
				<td><?php echo $i; ?></td>
				<td></td>
				<td><?php echo $titles[$findProjectMedia['ProjectListMedia']['Project_list_id']]; ?></td>
			</tr>
			<?php
			    $i++;
			    endforeach;
			?>
			<tr>
			</tr>
		</tbody>
	</table>
	
	<?php echo $favicon; ?>
	
	<span>Deleting this image will also remove the image from the associated database(s) or fav icon. Are you sure?</span>
	
</div>
<div class="cms_ModalFooter">
	<input type="button" value="Cancel" class="isOff" onclick="javascript: $('.media-notification').fadeOut('fast');" />		
	<input type="button" value="Delete" class="space10" onclick="javascript: window.location='<?php echo $link; ?>';" />
	<div class="clearFix"></div>
</div>