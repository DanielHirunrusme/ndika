<?php

class SiteProfilesController extends AppController {
	var $name = 'SiteProfiles';
	public $helpers = array('Form', 'Html', 'Js', 'Time');    
	public $components = array('RequestHandler');
	public $title='Site Profile';
	
	function index() {
		$this->set('title_for_layout', $this->name);

		$result=$this->SiteProfile->find('first',array (
			
			'order'=> array ('SiteProfile.id ASC')
			));
		
		//$jakarta=60*60*6;
		//$result['SiteProfile']['created']=date('d/m/y @ G:i',$jakarta+strtotime($result['SiteProfile']['created']));
		//$result['SiteProfile']['modified']=date('d/m/y @ G:i',$jakarta+strtotime($result['SiteProfile']['modified']));
		
		$this->set('profile', $result);
			
		/* $hasil = array ();
		foreach ($profile as $p) {
			foreach($p['SiteProfile'] as $key=>$value) {
			$hasil[$key] = $value;
		}
		}
	
		$this->set('hasil', $hasil); */
	
	}
	
	function save() {
		if ($this->SiteProfile->validates($this->data)){
			$this->SiteProfile->save($this->data);
			$this->Session->setFlash('SiteProfile Has Updated');
			$this->redirect(array('action' => 'index'));
		}
		else {
			$this->Session->setFlash('The SiteProfile could not be saved. Please try again');
		}
	}
	
	public function beforeRender($activePage='Profiles'){
		parent::beforeRender($activePage);
	}

	
}	