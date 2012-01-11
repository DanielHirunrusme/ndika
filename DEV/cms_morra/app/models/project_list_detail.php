<?php
class ProjectListDetail extends AppModel {
	var $name = 'ProjectListDetail';
	//public $belongsTo=array('ProjectList','ProjectListAtribut');
	//var $hasOne = array(
	//	'ProjectListAtribut',
	//	'ProjectList'
	//);
	
	public $validate=array(
        'title'=>array(
            'rule'=>'notEmpty',
            'message'=>'Title tidak boleh kosong'
        )
    );
	
	public function getProjectAtributMaxId(){
        $condition=array('order'=>array('ProjectListDetail.id DESC'));
        //var_dump($this->find('all'));
		//exit;
        return $this->find('first',$condition);
    }
	
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	 var $belongsTo = array(
		 'ProjectList' => array(
			 'className' => 'ProjectList',
			 'foreignKey' => 'Project_list_id',
			 'conditions' => '',
			 'fields' => '',
			 'order' => ''
		 ),
		 'Atribut' => array(
			 'className' => 'Atribut',
			 'foreignKey' => 'Project_list_atribut_id',
			 'conditions' => '',
			 'fields' => '',
			 'order' => ''
		 )
	 );
	
}
?>