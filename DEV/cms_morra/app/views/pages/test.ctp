<?php
var_dump($this->data);

echo $this->Form->create('Media', array('action'=>'add','type'=>'file'));
echo $this->Form->input('name',array('type'=>'file'));
echo $this->Form->submit('Upload');
echo $this->Form->end();
?>