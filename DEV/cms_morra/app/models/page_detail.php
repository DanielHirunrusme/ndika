<?php

class PageDetail extends AppModel {
    public $name='PageDetail';
    public $useTable='pages_details';
    public $belongsTo=array('Page');
    
	public $validate=array(
        'title'=>array(
            'rule'=>'notEmpty',
            'message'=>'Title tidak boleh kosong'
        )
    );
	//public $validate=array(
    //    'value'=>'notEmpty'
    //);
    
    public function add($id=NULL){
        if(!empty($this->data)){
            $this->save($this->data);
        }
        
        if($id!=NULL)
            redirect(array('controller'=>'pages','action'=>'editpage'));
        else
            redirect(array('controller'=>'pages','action'=>'index'));
    }
	
	public function getPageAtributMaxId(){
        $condition=array('order'=>array('PageDetail.id DESC'));
        //var_dump($this->find('all'));
		//exit;
        return $this->find('first',$condition);
    }
	
	//public function test(){
	//	return $this->find('all');
	//}
}