<?php

class ProjectListAtributsController extends AppController {
	public $name = 'ProjectListAtributs';
	var $uses = array('ProjectList','ProjectListAtribut','ProjectListDetail','SiteProfile','SiteProfileDetail','Atribut');
        
	
	function add() {
		$this->loadModel('Atribut');
	
		$this->layout='ajax';
		//var_dump($this->data);
		//die();
		
		$id = $this->data['ProjectList']['id'];

		//var_dump($this->data);
		//die();
		
		if($id!=null || !empty($id)){
			$this->Atribut->create();
		
			$this->Atribut->set($this->data);
			if ($this->Atribut->validates()){
				$this->Atribut->save($this->data);
				//$this->Session->setFlash('Add attribute in project list have successfully','success');
				//$this->redirect(array('controller'=>'ProjectLists','action' => 'edit',$id));
			} else {
				//$this->Session->setFlash('Add attribute in project list have failed. Please try again','failed');
				//$this->redirect(array('controller'=>'ProjectLists','action' => 'edit',$id));
				echo '0'; //mean failed;
			}
		}
		else{
			//$this->redirect(array('controller'=>'ProjectLists','action' => 'index'));
			echo '0'; //mean failed;
		}
		
		die();
	}

	public function test(){
            
            $this->set('media',$this->Media->find('all'));
        }

	function index(){
		$this->set('atribut', 
		$this->ProjectListAtribut->find('all',array (
			'order'=> array ('ProjectListAtribut.id ASC')
		)));
        }

	//@param integer arrayIndex Index array that send from projectlist/edit
	public function getNewestAtribut($arrayIndex=null,$projectId=null){
		$this->layout='ajax';
		if($arrayIndex!=null && $projectId!=null){
			$sql='SELECT * FROM cms_project_list_atributs ProjectListAtribut ORDER BY id DESC';
			$rows=$this->ProjectListDetail->query($sql);
			//var_dump($rows);
			//die();
			$row=$rows[0];
			
			//var_dump($row);
			$this->set('arrayIndex',$arrayIndex);
			$this->set('projectId',$projectId);
			$this->set('projectAtribut',$row['ProjectListAtribut']);
		}
	}
	
}
?>