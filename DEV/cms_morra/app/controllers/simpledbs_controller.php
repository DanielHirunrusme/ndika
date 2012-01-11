<?php

	//===================================================================================================================
	//	Title:
	//		simpledbs controller
	//
	//	Description:
	//		function add for new record to table "cms_simpledbs"
	//		add new database in views "project_lists/database.ctp"
	//
	//		function delete for delete record from table "cms_simpledbs"
	//		delete list database in views "project_lists/database.ctp"
	//
	//	Tag:
	//		add delete controller simpledb
	//===================================================================================================================

	class SimpledbsController extends AppController
	{
		public $name = 'Simpledbs';
		public $uses = array('ProjectList','ProjectListDetail','ProjectListMedia');
		
		public function add()
		{	
			if(!empty($this->data))
			{
				if($this->Simpledb->save($this->data))
				{
					$conditions=array('order'=>array('id desc'));
					$row=$this->Simpledb->find('first',$conditions);
					$this->Session->setFlash('Create new project successfully','success');
					$this->redirect(array('controller'=>'project_lists','acton'=>'index',$row['Simpledb']['id']));
				}
				else
				{
					$this->Session->setFlash('Create new project failed. Please try again. Make sure project name is not same with other project.','failed');
				}
			}
			
			$this->redirect(array('controller'=>'project_lists','action'=>'index'));
		}
		
		public function delete($id=NULL)
		{	
			$title = array();
			$dbNames = $this->Simpledb->find('all',array('limit'=>1,'conditions'=>array('Simpledb.id'=>$id)));
			
			foreach ($dbNames as $dbName):
				$title[$dbName['Simpledb']['id']] = $dbName['Simpledb']['title'];
			endforeach;
				
			$tempProjectList = array();
			$findProjectLists = $this->ProjectList->find('all',array('conditions'=>array('ProjectList.simpledb_id'=>$id)));
			
			foreach ($findProjectLists as $findProjectList):
				
				if ($findProjectList['ProjectList']['simpledb_id'] == $id)
				{	
					$tempProjectList = $findProjectList['ProjectList']['id'];
					
					//////////////////////////////////////////////////////
					
					$tempProjectListDetail = array();
					$findProjectListDetails = $this->ProjectListDetail->find('all',array('conditions'=>array('ProjectListDetail.Project_list_id'=>$tempProjectList)));
					
					foreach ($findProjectListDetails as $findProjectListDetail):
						
						if ($findProjectListDetail['ProjectListDetail']['Project_list_id'] == $tempProjectList)
						{
							$tempProjectListDetail = $findProjectListDetail['ProjectListDetail']['id'];
							
							$this->ProjectListDetail->delete($tempProjectListDetail);
						}
						
					endforeach;
					
					//////////////////////////////////////////////////////
					
					$tempProjectListMedia = array();
					$findProjectListMedias = $this->ProjectListMedia->find('all',array('conditions'=>array('ProjectListMedia.Project_list_id'=>$tempProjectList)));
					
					foreach ($findProjectListMedias as $findProjectListMedia):
						
						if ($findProjectListMedia['ProjectListMedia']['Project_list_id'] == $tempProjectList)
						{
							$tempProjectListMedia = $findProjectListMedia['ProjectListMedia']['id'];
							
							$this->ProjectListMedia->delete($tempProjectListMedia);
						}
						
					endforeach;
					
					//////////////////////////////////////////////////////
					
					$this->ProjectList->delete($tempProjectList);
				}
				
			endforeach;
			
			if($id!=NULL)
			{
			
				if(!$this->Simpledb->delete($id))
				{
					$this->Session->setFlash('Delete database '.$title[$id].' failed. Please try again.','failed');
					
					$this->redirect(array('controller'=>'project_lists','action'=>'database'));
				}
				else
				{
					$this->Session->setFlash('Database '.$title[$id].' has been deleted','success');
					
					$this->redirect(array('controller'=>'project_lists','action'=>'database'));
				}
			}
			else
			{
				$this->Session->setFlash('Delete database '.$title[$id].' failed. Please try again.','failed');
			
				$this->redirect(array('controller'=>'project_lists','action'=>'database'));
			}
		}
		
	}

?>