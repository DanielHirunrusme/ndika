<?php

class ProjectListMediasController extends AppController {
	public $helpers = array('Form', 'Html', 'Js', 'Time');
	public $name = 'ProjectListMedias';
	public $components = array('RequestHandler');
	
	function index() {
	$listmedia = $this->ProjectListMedia->find('all');
	$this->set('listmedia',$listmedia);
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
		$this->ProjectListMedia->saveAll($this->data['ProjectListMedia']);
		$this->redirect(array('controller'=>'ProjectListMedia','action'=>'index'));
	}
	
	function add(){
		//var_dump($this->data);
		//
		//die();
		$id=$this->data['ProjectList']['id'];

		if(!empty($this->data)){
			$this->ProjectListMedia->save($this->data);		
		}
		
		$this->redirect(array('controller'=>'ProjectLists','action'=>'edit',$id));
	}
	
}	