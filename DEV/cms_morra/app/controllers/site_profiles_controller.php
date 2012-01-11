<?php

class SiteProfilesController extends AppController {
	public $name = 'SiteProfiles';
	public $helpers = array('Form', 'Html', 'Js', 'Time');    
	public $components = array('RequestHandler');
	//public $title='Site Profile';
	public $uses= array('SiteProfile','SiteProfileDetail','Atribut','Media');
	
	function index() {
		$this->set('title_for_layout', 'Site Profile');
		$this->showThumbBrowser();
		$result=$this->SiteProfile->find('first',array (
			'order'=> array ('SiteProfile.id ASC')
		));
		
		$this->set('profile', $result);
		
		$jakarta=60*60*6;

		/////////For show css
		$cssTemp=$this->SiteProfile->getCss();

		$css=array();
		foreach($cssTemp as $x){
			$modif=date('d-m-Y @ H:i',filemtime(WWW_ROOT.'css'.DS.$x)+$jakarta);
			$css[$x]=array(
				'name'=>$x,
				'uploaded'=>$modif
			);
		}

		$modif=date('d-m-Y @ H:i',filemtime(WWW_ROOT.'css'.DS.'default.css')+$jakarta);
		$defaultCss=array(
				'name'=>'default.css',
				'uploaded'=>$modif        
		);

		$this->set('css',$css);
		$this->set('defaultCss',$defaultCss);

		$cssTemp['default.css']='default.css';
		$this->set('dropbox_css',$cssTemp);
		
		////////For show javascript
		$jsTemp=$this->SiteProfile->getJs();

		$js=array();
		foreach($jsTemp as $x){
			$modif=date('d-m-Y @ H:i',filemtime(WWW_ROOT.'user_js'.DS.$x)+$jakarta);
			$js[$x]=array(
				'name'=>$x,
				'uploaded'=>$modif
			);
		}

		$modif=date('d-m-Y @ H:i',filemtime(WWW_ROOT.'user_js'.DS.'default.js')+$jakarta);
		$defaultJs=array(
				'name'=>'default.js',
				'uploaded'=>$modif        
		);

		$this->set('js',$js);
		$this->set('defaultJs',$defaultJs);

		$jsTemp['default.js']='default.js';
		$this->set('dropbox_js',$jsTemp);
		
		/////////////Show Site Attributes
		
		$this->set('profileAttributes', $this->SiteProfileDetail->find('all'));
		$this->set('atributs', ClassRegistry::init("Atribut")->find('all'));
		
		//////////////// BROWSE MEDIA
		
		// $sqlBelumAda='SELECT * FROM cms_media Media
			// WHERE id NOT IN (Select a.id
			// From cms_child_project_lists Inner Join
			// cms_project_list_media b On cms_child_project_lists.id = b.Project_list_id
			// Inner Join
			// cms_media a On b.media_id = a.id)';
		
		//$this->set('mediaForElement',$this->Media->query($sqlBelumAda));
		
		$this->set('mediaForElement',$this->Media->find('all'));
		
		$icoMedia = $this->SiteProfile->find('first');
		
		$primaryImage=$this->Media->findById($icoMedia['SiteProfile']['fav_icon']);
		$this->set('primaryImage',$primaryImage);
		
	}
	
	function save()
	{
		if (!empty($this->data))
		{
			///////////////// FOR MEDIA /////////////////
			
			//UNTUK MENYIMPAN DATA
				
			$var4 = $this->data['Media'];
			$var4 = array('Media'=>$var4);
			
			//Add Pic to Media
			
			$media['Media']=$this->data['Media'];
			
			/////////////////////////////////////////////
			
			if ($this->SiteProfile->validates($this->data))
			{
				
				$this->SiteProfile->save($this->data);
				
				///////// change value from table cms_site_profile_detail
				
				$detailIds = $this->SiteProfileDetail->find('all');
				
				foreach ($detailIds as $detailId):
					$this->SiteProfileDetail->id = $detailId['SiteProfileDetail']['id'];
					$this->SiteProfileDetail->saveField('value',$this->data['SiteProfile']['coba'.$detailId['SiteProfileDetail']['id']]);
				endforeach;
				
				///////////////// FOR MEDIA /////////////////
				
				if($this->Media->validates($var4))
				{
					//Jika penyimpanan media sukses
					
					if($this->Media->save($var4) !== false)
					{
						$lastImage = $this->Media->find('first', array('order'=>array('id DESC')));
					
						$siteIcon = $this->SiteProfile->find('first');
				
						$this->data['SiteProfile']['id'] = $siteIcon['SiteProfile']['id'];
						$this->data['SiteProfile']['fav_icon'] = $lastImage['Media']['id'];
						
						$this->SiteProfile->save($this->data);
					}					
				}
				
				/////////////////////////////////////////////
				
				$this->Session->setFlash('Site Profile has been updated','success');
			}
			else 
			{
				$this->Session->setFlash('The Site Profile could not be saved. Please try again','failed');
			}
			
			$this->redirect(array('action' => 'index'));
		}
	}
	
	public function beforeRender($activePage='Profiles'){
		parent::beforeRender($activePage);
	}

	public function uploadCss(){
        //var_dump(get_defined_constants(true));
        //die();
        if(!empty($this->data)){
            $css=$this->data['SiteProfile'];
            $match=preg_match('/.css$/',$css['css']['name']);
            //var_dump($match>0);
            //die();
            if($match>0){
                $dest=WWW_ROOT.'css'.DS.$css['css']['name'];
                //var_dump($dest);
                //die();
                //Upload file to webroot/files/
                $uploaded=move_uploaded_file($css['css']['tmp_name'],$dest);
                
                //Update time modification
                touch($dest);
                
                //var_dump($dest,$template);
                //var_dump($uploaded);
                //die();
                
                if($uploaded)
                    $this->Session->setFlash('CSS has been uploaded','success');
                else
                    $this->Session->setFlash('Uploading CSS failed. Please try again','failed');
            }else{
                $this->Session->setFlash('Filename extenstion MUST ".css"','failed');                
            }
        }
		
		$this->redirect(array('action'=>'index'));
    }
	
	public function uploadJs(){
        //var_dump(get_defined_constants(true));
        //die();
        if(!empty($this->data)){
            $js=$this->data['SiteProfile'];
            $match=preg_match('/.js$/',$js['js']['name']);
            //var_dump($match>0);
            //die();
            if($match>0){
                $dest=WWW_ROOT.'user_js'.DS.$js['js']['name'];
                //var_dump($dest);
                //die();
                //Upload file to webroot/files/
                $uploaded=move_uploaded_file($js['js']['tmp_name'],$dest);
                
                //Update time modification
                touch($dest);
                
                //var_dump($dest,$template);
                //var_dump($uploaded);
                //die();
                
                if($uploaded)
                    $this->Session->setFlash('Javascript has been uploaded','success');
                else
                    $this->Session->setFlash('Uploading Javascript failed. Please try again','failed');
            }else{
                $this->Session->setFlash('Filename extenstion MUST ".js"','failed');                
            }
        }
		
		$this->redirect(array('action'=>'index'));
    }
	
	public function downloadCss($css=null){
        if($css!=null){
			$file = WWW_ROOT.'css'.DS.$css;
		
			// your file to download  
			header("Expires: 0");  
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
			header("Cache-Control: no-store, no-cache, must-revalidate");  
			header("Cache-Control: post-check=0, pre-check=0", false);  
			header("Pragma: no-cache");  
			header("Content-type: application/css");  
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
	
	public function downloadJs($Js=null){
        if($Js!=null){
			$file = WWW_ROOT.'user_js'.DS.$Js;
		
			// your file to download  
			header("Expires: 0");  
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
			header("Cache-Control: no-store, no-cache, must-revalidate");  
			header("Cache-Control: post-check=0, pre-check=0", false);  
			header("Pragma: no-cache");  
			header("Content-type: application/js");  
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
	
	public function deleteCss($css=null)
	{
        if($css!=null){
            //Delete css
            $delete = unlink(WWW_ROOT.'css'.DS.$css);
			
			if($delete)
				$this->Session->setFlash('CSS has been deleted','success');
			else
				$this->Session->setFlash('Delete CSS failed. Please try again','failed');
			
        }
        
        $this->redirect(array('action'=>'index'));
	
    }
	
	public function deleteJs($js=null)
	{
        if($js!=null){
            //Delete js
            $delete = unlink(WWW_ROOT.'user_js'.DS.$js);
			
			if($delete)
				$this->Session->setFlash('JavaScript has been deleted','success');
			else
				$this->Session->setFlash('Delete JavaScript failed. Please try again','failed');
			
        }
        
        $this->redirect(array('action'=>'index'));
    }
	
	//public function add(){
	//	if(!empty($this->data)){
	//		if($this->Atribut->save($this->data)){
			
				/////////insert tabel cms_site_profile_detail
	//			$atributIds = $this->Atribut->find('all',array('limit' => 1,'order'=>array('Atribut.id DESC')));
				
	//			foreach ($atributIds as $atributId):
	//				$this->SiteProfileDetail->atribut_id = $atributId['Atribut']['id'];
	//				$this->data['SiteProfileDetail']['atribut_id'] = $atributId['Atribut']['id'];
	//				$this->data['SiteProfileDetail']['value']='';
	//			endforeach;
			
	//			$this->SiteProfileDetail->create();
	//			$this->SiteProfileDetail->save($this->data);
			
	//			$this->Session->setFlash('Attribute have been added.', 'success');
	//		}else{
	//			$this->Session->setFlash('Failed to add attribute. Please try again', 'failed');
	//		}
	//	}
		
	//	$this->redirect(array('action'=>'index'));
	//}
	
	// public function add(){	
        // $this->layout='ajax';
        // if(!empty($this->data)){
			
			// $this->loadModel('Atribut');
			
			// $checks = $this->Atribut->find('all',array('conditions'=>array('Atribut.name'=>$this->data[Atribut][name])));
			
			// foreach($checks as $atribut):
				// $tempAtrib = $atribut[Atribut][id];
			// endforeach;
			
			// $yes = $this->Atribut->read(null, $tempAtrib);
			//$this->set(compact('user'));
			
			// if(!$yes)
			// {
				// if($this->RequestHandler->isAjax())
				// {
					// $this->Atribut->set($this->data);
					
					// if($this->Atribut->validates()){
						// $myData=$this->Atribut->save($this->data);
						// if(empty($myData) || $myData===false){
							// echo '0'; //0 berarti gagal
						// }
						
						///////insert tabel cms_site_profile_detail
						// $atributId = $this->Atribut->find('first',array('order'=>array('Atribut.id DESC')));
					
						// $this->SiteProfileDetail->atribut_id = $atributId['Atribut']['id'];
						// $this->data['SiteProfileDetail']['atribut_id'] = $atributId['Atribut']['id'];
						// $this->data['SiteProfileDetail']['value']='';
				
						// $this->SiteProfileDetail->create();
						// $this->SiteProfileDetail->save($this->data);
						
					// }
					// else
					// {
						// echo '0';
					// }
				// }
			// }
			// else
			// {
				///////insert tabel cms_site_profile_detail
				//$atributId = $this->Atribut->find('first',array('order'=>array('Atribut.id DESC')));
				
				// if($this->RequestHandler->isAjax())
				// {
					// $this->SiteProfileDetail->atribut_id = $tempAtrib;
					// $this->data['SiteProfileDetail']['atribut_id'] = $tempAtrib;
					// $this->data['SiteProfileDetail']['value']='';
			
					// $this->SiteProfileDetail->create();
					// $myData = $this->SiteProfileDetail->save($this->data);
					
					// if(empty($myData) || $myData===false)
					// {
						// echo '0'; //0 berarti gagal
					// }
				// }
			// }
		
            
			
        // }
		// else
		// {
            // echo '0';
        // }
    // }
	
	public function add()
	{
        $this->layout='ajax';
        if(!empty($this->data))
		{
		
			/////////////////////////////////
		
			$checkAtribut = $this->Atribut->find('count',array('limit' => 1, 'conditions'=>array('Atribut.name'=>$this->data['Atribut']['name'])));
			
			///////////// CHECK ATTRIBUTE //////////////
			
			$checkNames = $this->Atribut->find('all',array('limit'=>1,'conditions'=>array('Atribut.name'=>$this->data['Atribut']['name'])));
		
			$tempId = array();
			
			foreach ($checkNames as $checkName):
				$tempId = $checkName['Atribut']['id']; 
			endforeach;
			
			$selfChecks = $this->SiteProfileDetail->find('all',array('limit'=>1,'conditions'=>array('SiteProfileDetail.atribut_id'=>$tempId)));
			
			////////////////////////////////////
			
			if (!$selfChecks)
			{
			
				if ($checkAtribut == 1)
				{
					
					if($this->RequestHandler->isAjax())
					{
						$this->SiteProfileDetail->set($this->data);
						
						if ($this->SiteProfileDetail->validates())
						{
							$idAtributs = $this->Atribut->find('all',array('limit' => 1, 'conditions'=>array('Atribut.name'=>$this->data['Atribut']['name'])));
						
							foreach ($idAtributs as $idAtribut):
								$this->SiteProfileDetail->atribut_id = $idAtribut['Atribut']['id'];
								$this->data['SiteProfileDetail']['atribut_id'] = $idAtribut['Atribut']['id'];
								$this->data['SiteProfileDetail']['value']='';
							endforeach;
					
							$this->SiteProfileDetail->create();
							$myData = $this->SiteProfileDetail->save($this->data);
							
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
							$myData = $this->Atribut->save($this->data);
							
							// if(empty($myData) || $myData===false)
							// {
								// echo '0'; //0 berarti gagal
							// }
							
							/////insert tabel cms_site_profile_detail
							$atributIds = $this->Atribut->find('all',array('limit' => 1,'order'=>array('Atribut.id DESC')));
						
							foreach ($atributIds as $atributId):
								$this->SiteProfileDetail->atribut_id = $atributId['Atribut']['id'];
								$this->data['SiteProfileDetail']['atribut_id'] = $atributId['Atribut']['id'];
								$this->data['SiteProfileDetail']['value']='';
							endforeach;
					
							$this->SiteProfileDetail->create();
							$theData = $this->SiteProfileDetail->save($this->data);
							
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
	
	public function getatribut(){
        $this->layout='ajax';
        $this->set('profileAttribute',$this->SiteProfileDetail->getSiteAtributMaxId());
		$this->set('atributs', ClassRegistry::init("Atribut")->find('all'));
    }
	
	function addMedia()
	{
		$this->layout='ajax';
	
		if(!empty($this->data))
		{
			
			$siteIcon = $this->SiteProfile->find('first');
			
			$this->data['SiteProfile']['id'] = $siteIcon['SiteProfile']['id'];
			$this->data['SiteProfile']['fav_icon'] = $this->data['SiteProfile']['icon'];
			
			$this->SiteProfile->save($this->data);
			
			//$this->Session->setFlash('Changes has been saved.','success');
		}
		
		die();
    }
	
	function getfavicon()
	{
		$icoMedia = $this->SiteProfile->find('first');
		
		$primaryImage=$this->Media->findById($icoMedia['SiteProfile']['fav_icon']);
		$this->set('primaryImage',$primaryImage);
		
	}
	
	function deleteFavicon()
	{
		$this->layout='ajax';
	
		//if(!empty($this->data))
		//{
			
			$siteIcon = $this->SiteProfile->find('first');
			
			$this->data['SiteProfile']['id'] = $siteIcon['SiteProfile']['id'];
			$this->data['SiteProfile']['fav_icon'] = 0;
			
			$this->SiteProfile->save($this->data);
			
		//}
		
		die();
    }
	
	// function addFavicon() 
	// {
		//$this->layout='ajax';
	
		// if ($this->Media->save($this->data))
		// {
			// $this->Session->setFlash ('Media successfully uploaded','success');
		// }
		// else
		// {
			// $this->Session->setFlash ('Upload media failed. Please try again','failed');                    
		// }
        
        // $this->redirect (array('action' => 'index'));
		
		//die();
    //}
	
	// function uploadFavicon() 
	// {
		// if (!empty($this->data))
		// {
			////UNTUK MENYIMPAN DATA
			
			// $var4 = $this->data['Media'];
			// $var4 = array('Media'=>$var4);
			
			////Add Pic to Media
			
			// $media['Media']=$this->data['Media'];
			
			// if ($this->SiteProfile->validates($this->data))
			// {
				// if($this->Media->validates($var4))
				// {
					////Jika penyimpanan media sukses
					
					// if($this->Media->save($var4)!==false)
					// {
						// $this->Session->setFlash('Fav icon has been saved','failed');
					// }
				// }
			// }
			// else
			// {
				// $this->Session->setFlash('Fav icon could not be saved. Please try again','failed');
			// }
			
		// }
		// else
		// {
			
		// }
    // }
	
}	