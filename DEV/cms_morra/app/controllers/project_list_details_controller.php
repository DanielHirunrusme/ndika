<?php

class ProjectListDetailsController extends AppController {
	public $helpers = array('Form', 'Html', 'Js', 'Time');    
    public $components = array('RequestHandler');
	var $hasOne = array('ProjectList','ProjectListAtribut');
	
	function index() {
	$coba = $this->ProjectListDetail->findAllByParent_id(0);
	$this->set('coba',$coba);
	}
	
	function tambah_tes() {
	if (!empty ($this-> data)) {
	if ($this->ProjectListDetail->save($this->data)){
	$this->Session->setFlash ('Project list has been added.','success');
	$this->redirect (array('action' => 'index'));
	}
	}
	}
	
	function edit(){
		$id=$this->data['ProjectListDetail']['Project_list_id'];

		$this->ProjectListDetail->saveAll($this->data['ProjectListDetail']);
		
		$this->redirect(array('controller'=>'ProjectLists','action'=>'edit',$id));
	}
	function save(){
		//var_dump($this->data);
		//die();
		
		$id=$this->data[0]['ProjectListDetail']['Project_list_id'];
		
		$this->ProjectListDetail->saveAll($this->data);
		
		$this->redirect(array('controller'=>'ProjectLists','action'=>'edit',$id));
		//echo "<pre>"; print_r($this->data); echo "</pre>";
	}
	
}	