<?php
class SiteProfileDetail extends AppModel {
	var $name = 'SiteProfileDetail';
	
	//var $validate = array(
	//	'atribute_id' => array('numeric'),
	//	'name'=>'notEmpty',
	//	'message' => 'name of attribute can not be empty'
	//);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Atribut' => array(
			'className' => 'Atribut',
			'foreignKey' => 'atribut_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $validate=array(
        'title'=>array(
            'rule'=>'notEmpty',
            'message'=>'Title tidak boleh kosong'
        )
    );
	
	public function getSiteAtributMaxId(){
        $condition=array('order'=>array('SiteProfileDetail.id DESC'));
        
        return $this->find('first',$condition);
    }
}
?>