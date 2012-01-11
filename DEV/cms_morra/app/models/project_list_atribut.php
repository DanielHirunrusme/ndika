<?php
class ProjectListAtribut extends AppModel {
	var $name = 'ProjectListAtribut';
	var $hasMany = array(
		'ProjectListDetail'=>array(
			'className'=>'ProjectListDetail',
			'foreignKey'=>'Project_list_atribut_id'
		)
	);
	
	public $validate=array(
		'name'=>'notEmpty',
		'message' => 'name of attribute can not be empty'
	);
}
?>