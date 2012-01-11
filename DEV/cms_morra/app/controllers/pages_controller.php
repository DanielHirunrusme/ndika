<?php

	//===================================================================================================================
	//	Title:
	//		pages controller
	//
	//	Description:
	//		function index for display data in views "pages/index.ctp"
	//
	//		function addpage for new record to table "cms_pages"
	//		add new page in views "pages/index.ctp"
	//
	//		function editpage for change description all about page
	//
	//		function delete for delete record from table "cms_pages"
	//		delete list page in views "pages/index.ctp"
	//
	//		function changeStatus for change page status active or disabled
	//
	//		function uploadTemplate for upload new template
	//		function deleteTemplate for delete template
	//		function downloadTemplate for download template
	//
	//		function add for add new attribute to table "cms_atributs" and "cms_pages_details"
	//		
	//	Tag:
	//		index  page edit changeStatus template beforeRender add getAtribut controller pages
	//===================================================================================================================

	class PagesController extends AppController
	{
		public $name = 'Pages';
		public $helpers = array('Form', 'Html', 'Js', 'Time');    
		public $components = array('RequestHandler');
		public $uses = array('Page','PageDetail','Atribut');
		
		public function index()
		{
			$this->set('title_for_layout', $this->name);

			$jakarta=60*60*6;

			//For add page
			$result=$this->Page->find('all');
			$templateTemp=$this->Page->getTemplate();
			
			$template=array();
			
			foreach($templateTemp as $x)
			{
				$modif=date('d-m-Y @ H:i',filemtime(VIEWS.'users'.DS.'template'.DS.$x)+$jakarta);
				$template[$x]=array(
					'name'=>$x,
					'uploaded'=>$modif
				);
			}
			
			$modif=date('d-m-Y @ H:i',filemtime(VIEWS.'users'.DS.'template'.DS.'default.ctp')+$jakarta);
			$defaultTemplate=array(
					'name'=>'default.ctp',
					'uploaded'=>$modif        
			);
			
			$this->set('pages',$result);
			$this->set('template',$template);
			$this->set('defaultTemplate',$defaultTemplate);
			
			$templateTemp['default.ctp']='default.ctp';
			$this->set('dropbox_template',$templateTemp);
			
			//var_dump($templateTemp);
			//die();
			
		}
		
		public function addpage()
		{
			//ob_start();
			//echo "swt";exit;
			
			///////////////////////////////
			
			$tempPage = array();
			
			$checkPages = $this->Page->find('all', array('conditions'=>array('Page.title'=>$this->data['Page']['title'])));
			
			///////////////////////////////
			
			$this->layout='ajax';
			
			if(!empty($this->data))
			{
			
				if (!$checkPages)
				{
					if($this->RequestHandler->isAjax())
					{
						$this->Page->set($this->data);
						
						if($this->Page->validates())
						{
							$myData=$this->Page->save($this->data);
							
							if(empty($myData) || $myData===false)
							{
								echo '0'; //0 berarti gagal
							}
						}
						else
						{
							echo '0';
						}
					}
				}
				else
				{
					echo '0';
				}
			}
			else
			{
				echo '0';
			}
			//ob_end_flush();
			//die();
		}
		
		public function editpage($id=NULL)
		{
			$this->layout='ajax';
			//Jika load data
			if($id!=NULL)
			{
				//for template
				$sql='SELECT PagesDetail.*, Atribut.name
	FROM `cms_pages_details` PagesDetail, cms_atributs Atribut, cms_pages Page
	WHERE PagesDetail.page_id=Page.id AND PagesDetail.atribut_id=Atribut.id AND PagesDetail.page_id='.$id;
				$atributs=$this->Page->query($sql);
				
				//Fatch Page Detail and Atribut
				$tempPage=$this->Page->read(NULL, $id);
				$pagesDetails=$tempPage['PagesDetail'];
				$temp=array();
				
				foreach($pagesDetails as $pagesDetail)
				{
					$this->Atribut->recursive=0;
					$temp[]=array(
						'PagesDetail'=>$pagesDetail,
						'Atribut'=>$this->Atribut->read(NULL,$pagesDetail['atribut_id'])
					);
				}
				
				//Mencari atribut yang belum di isi/kosong
				$atribut_drop_box=array();
				$sql=sprintf('SELECT Atribut.id, Atribut.name 
				FROM cms_atributs Atribut
				WHERE
				Atribut.id NOT IN (SELECT atribut_id FROM cms_pages_details a WHERE a.page_id=%s)',$id);
				
				foreach($this->Atribut->query($sql) as $y)
				{
					$atribut_drop_box[$y['Atribut']['id']]=$y['Atribut']['name'];
				}
				
				//Mencari parent_id yang bukan id nya sendiri
				$parent_drop_box=array();
				$sql=sprintf('SELECT * 
				FROM `cms_pages` Page
				WHERE id <> %s',$id);
				
				foreach($this->Atribut->query($sql) as $y)
				{
					$parent_drop_box[$y['Page']['id']]=$y['Page']['title'];
				}
				
				
				
				$this->set('page',$tempPage);
				$this->set('template',$this->Page->getTemplate());
				$this->set('atributs',$atributs);
				$this->set('atribut_drop_box',$atribut_drop_box);
				$this->set('parent_drop_box',$parent_drop_box);
				
				$this->data=$this->Page->findById($id);
			}
		}
		
		public function edit($id = null)
		{
		
			/////////////Show Page Attributes
			$this->set('pageAttributes', $this->PageDetail->find('all', array('conditions'=>array('PageDetail.page_id'=>$id))));
			$this->set('tests', ClassRegistry::init("Atribut")->find('all'));
			$this->set(compact('id'));
			
			/////////////
		
			if($id!=null)
			{
				//var_dump($id,$this->data);
				
				//die();
				//for template
				if(empty($this->data))
				{
					$sql='SELECT PageDetail.*, Atribut.name
		FROM `cms_pages_details` PageDetail, cms_atributs Atribut, cms_pages Page
		WHERE PageDetail.page_id=Page.id AND PageDetail.atribut_id=Atribut.id AND PageDetail.page_id='.$id;
					$atributs=$this->Page->query($sql);
					
					//Fatch Page Detail and Atribut
					$tempPage=$this->Page->read(NULL, $id);
					$pagesDetails=$tempPage['PageDetail'];
					$temp=array();
					
					foreach($pagesDetails as $pageDetail)
					{
						$this->Atribut->recursive=0;
						$temp[]=array(
							'PageDetail'=>$pageDetail,
							'Atribut'=>$this->Atribut->read(NULL,$pageDetail['atribut_id'])
						);
					}
					
					//Mencari atribut yang belum di isi/kosong
					$atribut_drop_box=array();
					$sql=sprintf('SELECT Atribut.id, Atribut.name 
					FROM cms_atributs Atribut
					WHERE
					Atribut.id NOT IN (SELECT atribut_id FROM cms_pages_details a WHERE a.page_id=%s)',$id);
					
					foreach($this->Atribut->query($sql) as $y)
					{
						$atribut_drop_box[$y['Atribut']['id']]=$y['Atribut']['name'];
					}
					
					//Mencari parent_id yang bukan id nya sendiri
					$parent_drop_box=array();
					$sql=sprintf('SELECT * 
					FROM `cms_pages` Page
					WHERE id <> %s',$id);
					
					foreach($this->Atribut->query($sql) as $y){
						$parent_drop_box[$y['Page']['id']]=$y['Page']['title'];
					}
					
					$sql='Select Atribut.id, Atribut.name
	From cms_atributs Atribut
	WHERE id NOT IN (select atribut_id from cms_pages_details PagesDetail where PagesDetail.page_id='.$id.')';
					$nonFilledAtributs=$this->Page->query($sql);
					$template=$this->Page->getTemplate();
					$template['default.ctp']='default.ctp';
					
					$this->setTitle('Edit '.$tempPage['Page']['title']);
					$this->set('page',$tempPage);
					$this->set('template',$template);
					$this->set('atributs',$atributs);
					$this->set('nonFilledAtributs',$nonFilledAtributs);
					$this->set('atribut_drop_box',$atribut_drop_box);
					$this->set('parent_drop_box',$parent_drop_box);
					$this->set('pageId',$id);
					
					$this->data=$this->Page->findById($id);                
				}
				else
				{
					
					$conditions = array('NOT' => array('Page.id' => array($id)),'Page.title'=>$this->data['Page']['title']);
					
					$findTitles = $this->Page->find('all', array('limit'=>1,'conditions' => $conditions));
					
					if ($findTitles)
					{
						$this->Session->setFlash('Page Title already used in other projects. Please try again.','failed');
					}
					else
					{
						
						$page['Page']=$this->data['Page'];
					
						$success=false;
						$success=$this->Page->save($page);
						/////////// $success=$this->PageDetail->saveAll($this->data['PageDetail']);
						
						/////////// change value from table cms_pages_detail///////////////
					
						$detailIds = $this->PageDetail->find('all',array('conditions'=>array('PageDetail.page_id'=>$id)));
						
						foreach ($detailIds as $detailId):
							$success = $this->PageDetail->id = $detailId['PageDetail']['id'];
							$success = $this->PageDetail->saveField('value',$this->data['Page']['coba'.$detailId['PageDetail']['id']]);
						endforeach;
						
						///////////////////////////////////////////////////////////////////
						
						if ($success)
						{
							$this->Session->setFlash('Page has been updated','success');
						}
						else
						{
							$this->Session->setFlash('Edit page failed. Please try again','failed');
						}
						
					}
					
					$this->redirect(array('action'=>'edit',$id));
				}
				
			}
		}
		
		public function deletepage($id=NULL)
		{
			$this->layout='ajax';
			
			if($id!=NULL)
			{
				if(!$this->Page->delete($id))
				{
					echo '0'; //mean failed
				}
			}
		}
		
		public function changeStatus($id=NULL)
		{
			$this->layout='ajax';
			$this->autoRender=false;
			
			if($id!=NULL)
			{
				$data=$this->Page->findById($id);
				$data['Page']['status']=$data['Page']['status']==0?1:0;
				
				if($this->Page->save($data)===false)
				{
					echo '0'; //mean failed
				}
			}
		}
		
		public function pagelist()
		{
			$this->layout='ajax';
		}
		
		public function getpage()
		{
			$this->layout='ajax';
			
			$this->set('page',$this->Page->getPageMaxId());
		}
		
		public function uploadTemplate()
		{
			//var_dump(get_defined_constants(true));
			//die();
			if(!empty($this->data)){
				$template=$this->data['Page'];
				$match=preg_match('/.ctp$/',$template['template']['name']);
				//var_dump($match>0);
				//die();
				if($match>0 && $template['template']['name']!='default.ctp')
				{
					$dest=VIEWS.'users'.DS.'template'.DS.$template['template']['name'];
					//var_dump($dest);
					//die();
					//Upload file to webroot/files/
					$uploaded=move_uploaded_file($template['template']['tmp_name'],$dest);
					
					//Update time modification
					touch($dest);
					
					//var_dump($dest,$template);
					//var_dump($uploaded);
					//die();
					
					if($uploaded)
						$this->Session->setFlash('Template has been uploaded','success');
					else
						$this->Session->setFlash('Uploading template failed. Please try again','failed');
				}
				else
				{
					$this->Session->setFlash('Filename must not "default.ctp" AND extenstion MUST ".ctp"','failed');                
				}
			}

			$this->redirect(array('controller'=>'pages','action'=>'index'));
		}
		
		public function deleteTemplate($template=null)
		{
			if($template!=null)
			{
				//Delete template
				unlink(VIEWS.'users'.DS.'template'.DS.$template);
				
				//Ubah semua page yang menggunakan template tersebut menjadi default.ctp
				$sql=sprintf("UPDATE cms_pages SET template='default.ctp' WHERE template='%s'",$template);
				$this->Page->query($sql);
				
				$this->Session->setFlash('Template '.$template.' has been deleted','success');  
			}
			
			$this->redirect(array('action'=>'index'));
		}
		
		public function downloadTemplate($template=null)
		{
			if($template!=null)
			{
				$file = VIEWS.'users'.DS.'template'.DS.$template;
			
				// your file to download  
				header("Expires: 0");  
				header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
				header("Cache-Control: no-store, no-cache, must-revalidate");  
				header("Cache-Control: post-check=0, pre-check=0", false);  
				header("Pragma: no-cache");  
				header("Content-type: application/ctp");  
				// tell file size  
				header('Content-length: '.filesize($file));
				// set file name  
				header('Content-disposition: attachment; filename='.basename($file));  
				readfile($file);  
				// Exit script. So that no useless data is output-ed.  
				exit;
			}
			$this->redirect(array('action'=>'index'));
		}
		
		public function beforeRender($activePage='Pages')
		{
			parent::beforeRender($activePage);
		}
		
		public function add()
		{
			$this->layout='ajax';
			
			if(!empty($this->data))
			{
			
				/////////////////////////////////
			
				$checkAtribut = $this->Atribut->find('count',array('conditions'=>array('Atribut.name'=>$this->data['Atribut']['name'])));
				
				///////////// CHECK ATTRIBUTE //////////////
				
				$checkNames = $this->Atribut->find('all',array('limit'=>1,'conditions'=>array('Atribut.name'=>$this->data['Atribut']['name'])));
			
				$tempId = array();
				
				foreach ($checkNames as $checkName):
					$tempId = $checkName['Atribut']['id']; 
				endforeach;
				
				$selfChecks = $this->PageDetail->find('all',array('limit'=>1,'conditions'=>array('PageDetail.page_id'=>$this->data['Page']['pageId'],'PageDetail.atribut_id'=>$tempId)));
				
				///////////////////////////////////////////
				
				if (!$selfChecks)
				{
				
					if ($checkAtribut == 1)
					{
						if($this->RequestHandler->isAjax())
						{
							$this->PageDetail->set($this->data);
							
							if($this->PageDetail->validates())
							{
								
								$idAtributs = $this->Atribut->find('all',array('limit' => 1, 'conditions'=>array('Atribut.name'=>$this->data['Atribut']['name'])));
						
								foreach ($idAtributs as $idAtribut):
									$this->PageDetail->atribut_id = $idAtribut['Atribut']['id'];
									$this->data['PageDetail']['atribut_id'] = $idAtribut['Atribut']['id'];
									$this->data['PageDetail']['page_id'] = $this->data['Page']['pageId'];
									$this->data['PageDetail']['value'] = $this->data['Page']['atribValue'];
								endforeach;
						
								$this->PageDetail->create();
								$myData = $this->PageDetail->save($this->data);
								
								if(empty($myData) || $myData===false)
								{
									echo '0'; //0 berarti gagal
								}
								
							}
							else
							{
								echo '0';
							}
						}
					}
					else
					{
						if($this->RequestHandler->isAjax())
						{
							$this->Atribut->set($this->data);
							
							if($this->Atribut->validates())
							{
								$myData=$this->Atribut->save($this->data);
								
								// if(empty($myData) || $myData===false)
								// {
									// echo '0'; //0 berarti gagal
								// }
								
								$atributIds = $this->Atribut->find('all',array('limit' => 1,'order'=>array('Atribut.id DESC')));
						
								foreach ($atributIds as $atributId):
									$this->PageDetail->atribut_id = $atributId['Atribut']['id'];
									$this->data['PageDetail']['atribut_id'] = $atributId['Atribut']['id'];
									$this->data['PageDetail']['page_id'] = $this->data['Page']['pageId'];
									$this->data['PageDetail']['value'] = $this->data['Page']['atribValue'];
								endforeach;
						
								$this->PageDetail->create();
								$theData = $this->PageDetail->save($this->data);
								
								if(empty($myData) || $myData===false)
								{
									echo '0'; //0 berarti gagal
								}
								else
								{
									if(empty($theData) || $theData===false)
									{
										echo '0'; //0 berarti gagal
									}
								}
								
							}
							else
							{
								echo '0';
							}
						}
					}
				
				}
				else
				{
					echo '0';
				}
				
				/////////////////////////////////
			
			}
			else
			{
				echo '0';
			}
		}
		
		public function getatribut()
		{
			$this->layout='ajax';
			
			//var_dump($this->PageDetail->test());
			//var_dump($this->PagesDetail->find('all'));
			$this->set('pageAttribute',$this->PageDetail->getPageAtributMaxId());
			//$this->set('pageAttribute', $this->PagesDetail->find('first', array('conditions'=>array('PagesDetail.page_id'=>'49'))));
			$this->set('tests', ClassRegistry::init("Atribut")->find('all'));
		}
		
		public function delete($id=null)
		{
			if($id!=null)
			{
				
				//Delete page detail
				
				$tempPage = array();
				$findPages = $this->PageDetail->find('all',array('conditions'=>array('PageDetail.page_id'=>$id)));
				
				foreach ($findPages as $findPage):
					if ($findPage['PageDetail']['page_id'] == $id)
					{
						$tempPage = $findPage['PageDetail']['id'];
						$this->PageDetail->delete($tempPage);
					}					
				endforeach;
			
				//Delete page
				$this->Page->delete($id);
				$this->Session->setFlash('Page has been deleted','success');
			}
			
			$this->redirect(array('controller'=>'pages','action'=>'index'));
		}
		
	}

?>