<span class="cms_Thumbnail">
<?php
	if($primaryImage!==false)
		echo $this->Html->image('upload/thumb/'.$primaryImage['Media']['id'].'.'.$primaryImage['Media']['type'], 
			array('id'=>'primary-image-show','alt' => $primaryImage['Media']['name'],'title' => $primaryImage['Media']['name'],'width'=>'50px','heigth'=>'50px'));
	else echo $this->Html->image('upload/thumb/holder.png', 
			array('id'=>'primary-image-show','alt' => $primaryImage['Media']['name'],'title' => $primaryImage['Media']['name'],'width'=>'50px','heigth'=>'50px'));
?>
</span>