<?php

	//===================================================================================================================
	//	Title:
	//		atributs controller
	//
	//	Description:
	//		function add for new record to table "cms_atributs"
	//
	//	Tag:
	//		add test controller atribut
	//===================================================================================================================

	class AtributsController extends AppController
	{
		public $name = 'Atributs';
		public $uses = array('PagesDetail');
			
		public function add()
		{
			//$this->loadModel('Atribut');
			//$this->loadModel('PagesDetail');
			
			if(!empty($this->data))
			{
				if($this->Atribut->save($this->data))
				{
				
					/////////insert tabel cms_project_list_details
					$atributIds = $this->Atribut->find('all',array('limit' => 1,'order'=>array('Atribut.id DESC')));
					
					foreach ($atributIds as $atributId):
						$this->PagesDetail->atribut_id = $atributId['Atribut']['id'];
						$this->data['PagesDetail']['atribut_id'] = $atributId['Atribut']['id'];
						$this->data['PagesDetail']['page_id'] = $this->data['Page']['id'];
						$this->data['PagesDetail']['value'] = '';
					endforeach;
				
					$this->PagesDetail->create();
					$this->PagesDetail->save($this->data);
					
					$this->Session->setFlash('Attribute have been added.', 'success');
				}
				else
				{
					$this->Session->setFlash('Failed to add attribute. Please try again', 'failed');
				}
			}
			
			$this->redirect(array('controller'=>'pages','action'=>'edit',$this->data['Page']['id']));
		}
		
		public function test()
		{
			$this->set('page',$this->Media->find('all'));
		}
	}

?>	