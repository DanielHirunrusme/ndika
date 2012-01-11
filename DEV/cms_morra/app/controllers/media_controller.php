<?php

	//===================================================================================================================
	//	Title:
	//		media controller
	//
	//	Description:
	//		function index for display data in views "media/index.ctp"
	//		function view for display data in views "media/view.ctp"
	//		function copytag for display data in views "media/copytag.ctp"
	//
	//		function add for new record to table "cms_media"
	//		add new image in views "media/index.ctp"
	//
	//		function delete for delete record from table "cms_media"
	//		delete list image in views "media/index.ctp"
	//		
	//	Tag:
	//		index view copytag add mediaused delete doubleAdd beforeRender controller media
	//===================================================================================================================

	class MediaController extends AppController
	{
		public $name = 'Media';
		public $uses=array('SiteProfile','Media','ProjectListMedia');

		function index() 
		{
			$count = $this->Media->find('count');
			$this->set('count',$count);
		
			$this->set('title_for_layout', $this->name);
			$sql='Select cms_project_lists.id, cms_project_lists.title
					From cms_project_list_media Inner Join
					  cms_project_lists On cms_project_lists.media_id =
						cms_project_list_media.media_id AND cms_project_list.media_id=1';
				
			//die($sql);
			$this->setTitle('Media Library');
			$this->set('media', $this->Media->find('all', array ('order'=> array ('Media.created DESC'))));
			
		}
		
		function view($id=null)
		{
			$this->Media->id = $id;
			$this->setTitle('View Media');
			$this->set('media', $this->Media->read());		
		}
		
		function copytag($id=null)
		{
			$this->Media->id = $id;
			$this->set('media', $this->Media->read());
			$this->set('dimension',$this->Media->getDimension($id));
		}
		
		function add()
		{
			if (!empty ($this-> data))
			{
				if ($this->Media->save($this->data))
				{
					$this->Session->setFlash ('Media successfully uploaded','success');
				}
				else
				{
					$this->Session->setFlash ('Upload media failed. Please try again','failed');                    
				}
			}
			
			$this->redirect (array('action' => 'index'));	
		}
		
		function mediaused($id=NULL)
		{
			$this->layout='ajax';
			
			if($id!=NULL)
			{
			
				//////////////// CHECK MEDIA FOR FAV ICON ///////////////
			
				$checkFavicon = $this->SiteProfile->find('count',array('conditions'=>array('SiteProfile.fav_icon'=>$id)));
				
				if ($checkFavicon == '1')
				{
					$favicon = '<h6>This image used as the fav icon</h6>';
				}
				else
				{
					$favicon = '';
				}
				
				$this->set(compact('favicon'));
				
				/////////////////////////////////////////////////////////
				
				$this->set('simpledbs', ClassRegistry::init("Simpledb")->find('all'));
				
				$findProjectMedias = $this->ProjectListMedia->find('all',array('conditions'=>array('ProjectListMedia.media_id'=>$id)));
				
				$this->set(compact('findProjectMedias'));
				
				$this->set('projectlists', ClassRegistry::init("ProjectList")->find('all'));
				
				/////////////////////////////////////////////////////////
				
				$sql="SELECT * FROM cms_project_lists ProjectList WHERE media_id=".$id;
				$this->set('ProjectList',$this->Media->query($sql));
				
				$sql="Select DISTINCT ProjectList.id, ProjectList.title
				From cms_project_list_media ProjectListMedia Inner Join
				cms_project_lists ProjectList On ProjectList.id =
				ProjectListMedia.Project_list_id
				Where ProjectListMedia.media_id = ".$id;
				
				$link=sprintf('%s/%s/%s/%s/%s',
							  FULL_BASE_URL,
							  'cms_morra',
							  'media',
							  'delete',
							  $id);
				
				$this->set('project_list_media',$this->Media->query($sql));
				$this->set('media_id',$id);
				$this->set('link',$link);
			}
		}
		
		function delete ($id = null)
		{
			if ($id==NULL)
			{
				$this->Session->setFlash('Invalid ID Media','failed');
			}
			else 
			{
				if($this->Media->delete($id))
				{
					/////////// CHANGE ID FAV ICON IN CMS_SITE_PROFILES ///////////
					
					$siteProfiles = $this->SiteProfile->find('first');
					
					$this->data['SiteProfile']['id'] = $siteProfiles['SiteProfile']['id'];
					$this->data['SiteProfile']['fav_icon'] = 0;
					
					$this->SiteProfile->save($this->data);
					
					///////////////////////////////////////////////////////////////
				
					//$this->Session->setFlash('Media #'.$id.' Deleted','success');
					
					$this->Session->setFlash($id.'.'.$this->data['Media']['type'].' has been deleted','success');
				}
			}
			
			$this->redirect(array('action' => 'index'),null,true);
		}
		
		public function doubleAdd()
		{
			var_dump($this->data);
			die();
			if(!empty($this->data))
			{
				$this->ProjectListMedia=ClassRegistry::init('ProjectListMedia');
				
				$projectId=$this->data['ProjectListMedia']['Project_list_id'];
				//Add Pic to Media
				$media['Media']=$this->data['Media'];
				//var_dump($media);
				
				//Jika penyimpanan media sukses
				if($this->Media->save($media))
				{               
					//Add Media to Project List Media
					//Get New ID Media First
					$sql='SELECT * FROM cms_media Media ORDER BY created DESC';
					$media=$this->Media->query($sql);
					$mediaId=$media[0]['Media']['id'];
					
					//Create array to save in cms_project_media db
					$projectListMedia['ProjectListMedia']=array(
						'Project_list_id'=>$projectId,
						'media_id'=>$mediaId
					);
					
					//var_dump($projectListMedia);
					//die();
					
					$this->ProjectListMedia->save($projectListMedia);
					
					//Redirect to Project List action edit
					$this->Session->setFlash('Media successfully uploaded','success');
					$this->redirect(array('controller'=>'ProjectLists','action'=>'edit',$projectId));
				}
				else
				{ //Jika tidak kembali ke halaman sebelumnya
					$this->Session->setFlash('Upload media failed. Please try again','failure');
					$this->redirect(array('controller'=>'ProjectLists','action'=>'edit',$projectId));
				}
			}
			
			$this->redirect(array('controller'=>'ProjectList','action'=>'index'));
		}
		
		function tag($id=NULL)
		{
			$this->layout='ajax';
			
			if($id!=NULL)
			{
				$this->Media->id = $id;
				$this->set('media', $this->Media->read());	
			}
		}
		
		public function beforeRender($activePage='Media')
		{
			parent::beforeRender($activePage);
		}
	}

?>