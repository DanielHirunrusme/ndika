<?php
    //echo "<pre>"; echo print_r($option);echo "</pre>";
class ProjectListsController extends AppController {
	public $name='ProjectLists';
    public $uses = array ('ProjectList','ProjectListDetail','Media','ProjectListMedia','Simpledb','PageDetail','Atribut');
    public $helpers = array('Form', 'Html', 'Js', 'Time');
    public $components = array('RequestHandler');
    
    private $activeSimpleDb=null;
    private $deepSearch=5;
    
    //public function beforeRender($activePage='ProjectList'){
	//	if(!empty($this->activeSimpleDb)){
	//		$activePage=$this->activeSimpleDb['Simpledb']['title'];
	//	}
    //    parent::beforeRender($activePage);
    //}
	
	public function beforeRender($activePage='Database'){
		 parent::beforeRender($activePage);
    }
    
    public function test(){
	$this->ProjectList->recursive=5;
	$this->ProjectList->unbindModel(
	    array('hasMany' => array('ProjectListDetail'))
	);
	
	$contain=array('contain'=>'ProjectList','conditions'=>array('ProjectList.id'=>'27'));
	//$rows=$this->ProjectList->findByParent_id(0);
	
	//$rows=$this->ProjectList->find('all',$contain);
	$rows=$this->Media->query('CALL test()');
    }

    function index($id=null) {
	if($id!=null){
	    $this->activeSimpleDb=$this->Simpledb->findById($id);
	    $this->setTitle($this->activeSimpleDb['Simpledb']['title']);
	    
	    //$coba = $this->ProjectList->findAllByParent_id(0,array('recursive'=>0));
	    //$this->set('coba',$coba);
	    
	    //UNTUK MENAMPILKAN Project
	    $pertamax='SELECT ProjectList.* FROM `cms_project_lists`
		    ProjectList WHERE
		    ProjectList.parent_id=0 AND simpledb_id='.$id;
	    
	    $project = $this->ProjectList->query($pertamax);
	    
	    $newProject=array();
	    foreach($project as $mrp){
		$keduax='SELECT ProjectList.* FROM `cms_project_lists`
		    ProjectList WHERE
		    ProjectList.parent_id!=0 AND ProjectList.parent_id='.$mrp['ProjectList']['id'];
		    
		$sub=$this->ProjectList->query($keduax);
		
		$newProject[]=array(
		    'ProjectList'=>$mrp,
		    'SubProjectList'=>$sub);
	    }
	    
	    $this->ProjectList->unBindModel(array('hasMany'=>array('ProjectListDetail','ProjectListMedia')));
	    $projects=$this->ProjectList->find('all',array(
		'recursive'=>$this->deepSearch,
		'conditions' => array(
		    'ProjectList.parent_id' => '0',
		    'ProjectList.simpledb_id'=> $id
		)
	    ));
	    
	    $this->set('newProject',$newProject);
	    $this->set('projects',$projects);
	    
	    //var_dump($output);
	    //var_dump($projects);
	    //die();

	    //UNTUK MENAMPILKAN SUBTITLE PROJECT DI DALAM index PROJECT
	    $sql='SELECT ProjectList.* FROM `cms_project_lists`
		    ProjectList WHERE
		    ProjectList.parent_id=37';

	    $subtitle=$this->ProjectList->query($sql);
	    $this->set('subtitle',$subtitle);
		    
		    
	    $jakarta=60*60*6;			
	    $this->set('jakarta',$jakarta);

	    //for reference image from media
	    $medias=array();
	    
	    foreach($this->Media->find('all') as $media){
		    //Get Id and filename(id+ext)
		    $medias[$media['Media']['id']]=sprintf('%s.%s',$media['Media']['id'],$media['Media']['type']);
	    }
	    $this->set('medias',$medias);
	    
	    $media = $this->Media->find('all',array (
			'recursive'=>0,
			'order'=> array ('Media.id ASC')
		    ));
	    
	    $this->set('media', $media);
	    $result = array ();
	    foreach ($media as $ax) {
		    $result[$ax['Media']['id']] = $ax['Media']['name'];
	    }
    
	    $this->set('result', $result);
	    
	    //Mencari Count atau jumlah baris project yang ada
	    $rowEntry = $this->ProjectList->find('count', array(
		'fields' => 'ProjectList.id',
		'conditions' => array('ProjectList.parent_id' => '0','ProjectList.simpledb_id'=>$id)
	    ));
		    
	    $this->set('rowEntry', $rowEntry);
	    
	    //Mencari parent_id yang belum di isi/kosong
	    $parent_id_isi=array();$parent_id_isi[0]='As Parent';
	    $sql3='SELECT ProjectList.id, ProjectList.title 
	    FROM cms_project_lists ProjectList WHERE ProjectList.simpledb_id='.$id;
	    
	    foreach($this->ProjectList->query($sql3) as $q){
		$parent_id_isi[$q['ProjectList']['id']]=$q['ProjectList']['title'];
	    }
	        
	    $this->set('parent_id_isi', $parent_id_isi);
	    $this->set('post', 
	    $this->ProjectList->find('all',array (
		'recursive'=>0,
		'order'=> array ('ProjectList.id ASC')
	    )));
	    
	    $this->set('media', 
	    $this->Media->find('all',array (
		'order'=> array ('Media.id ASC')
	    )));
	    
	    $this->set('simpledbId',$id);
	    $conditions = array ('ProjectList.parent_id <>'=>'0');
	    $tes = $this->ProjectList->find('all',array ('conditions'=>$conditions));
	    $this->set('tes',$tes);
	    $this->set('simpledb',$this->Simpledb->findById($id));
	}else{
	    $this->redirect(array('controller'=>'SiteProfiles','action'=>'index'));
	}
    }
    
    function add()
	{
		$simpledbId=$this->data['ProjectList']['simpledb_id'];
		$this->ProjectList->set($this->data);
		
		if ($this->ProjectList->validates())
		{
			$this->ProjectList->save($this->data);
			$this->ProjectList->saveField('status',1);
			
			$this->Simpledb->id = $this->data['Simpledb']['idDatabase'];
            $this->Simpledb->saveField('title', $this->data['Simpledb']['tempTitle']);
		}
		else 
		{
			$this->Session->setFlash('Add new entry failed. Please try again','failed');
		}
	
		$this->redirect (array('controller'=>'project_lists','action' => 'index',$simpledbId));
    }
	
	public function addlist()
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
			
			$selfChecks = $this->ProjectListDetail->find('all',array('limit'=>1,'conditions'=>array('ProjectListDetail.Project_list_id'=>$this->data['ProjectList']['idProject'],'ProjectListDetail.Project_list_atribut_id'=>$tempId)));
			
			///////////////////////////////////////////
			
			if (!$selfChecks)
			{	
				
				if ($checkAtribut == 1)
				{
					if($this->RequestHandler->isAjax())
					{
						$this->ProjectListDetail->set($this->data);
						
						if ($this->SiteProfileDetail->validates())
						{
							$idAtributs = $this->Atribut->find('all',array('limit' => 1, 'conditions'=>array('Atribut.name'=>$this->data['Atribut']['name'])));
								
							foreach ($idAtributs as $idAtribut):
								$this->ProjectListDetail->Project_list_atribut_id = $idAtribut['Atribut']['id'];
								$this->data['ProjectListDetail']['Project_list_atribut_id'] = $idAtribut['Atribut']['id'];
								$this->data['ProjectListDetail']['Project_list_id'] = $this->data['ProjectList']['idProject'];
								$this->data['ProjectListDetail']['value'] = $this->data['ProjectList']['atribValue'];
							endforeach;
					
							$this->ProjectListDetail->create();
							$myData = $this->ProjectListDetail->save($this->data);
							
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
							
							/////////insert tabel cms_project_list_detail
							
							$atributIds = $this->Atribut->find('all',array('limit' => 1,'order'=>array('Atribut.id DESC')));
					
							foreach ($atributIds as $atributId):
								$this->ProjectListDetail->Project_list_atribut_id = $atributId['Atribut']['id'];
								$this->data['ProjectListDetail']['Project_list_atribut_id'] = $atributId['Atribut']['id'];
								$this->data['ProjectListDetail']['Project_list_id'] = $this->data['ProjectList']['idProject'];
								$this->data['ProjectListDetail']['value'] = $this->data['ProjectList']['atribValue'];
							endforeach;
					
							$this->ProjectListDetail->create();
							$theData = $this->ProjectListDetail->save($this->data);
							
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
    
    function change($id=null) {
		if($id!=NULL){
			$data=$this->ProjectList->findById($id);
			$data['ProjectList']['status']=$data['ProjectList']['status']==0?1:0;
			if($this->ProjectList->save($data)===false){
			echo '0'; //mean failed
			}
			$this->redirect (array('controller'=>'project_lists','action' => 'index',$data['ProjectList']['simpledb_id']));
		}
    }
    
    
    
    function view($id=null) {
	$this->ProjectList->id = $id;
	$this->set('post', $this->ProjectList->read());
    }
    
    function edit($id=null)
	{
		
		/////////////Show Project Attributes
		$this->set('projectIds', $this->ProjectListDetail->find('all',array('conditions'=>array('ProjectListDetail.Project_list_id'=>$id))));
		$this->set('cobas', ClassRegistry::init("Atribut")->find('all'));
		$this->set(compact('id'));
		
		/////////////
	
		parent::showThumbBrowser();
		//$this->set('title_for_layout', 'Project List');
		if ($id!=null)
		{
			$this->set('projectListId', $id);
		
			//UNTUK MENAMPILKAN SUBTITLE PROJECT DI DALAM EDIT PROJECT
			$sql='SELECT ProjectList.* FROM `cms_project_lists`
			ProjectList WHERE
			ProjectList.parent_id='.$id;

			$subtitle=$this->ProjectList->query($sql);
			$this->set('subtitle',$subtitle);
			
			
			//Fatch ProjectList Detail and Atribut
			//var_dump($tempProject);
			//die();
			$tempProject=$this->ProjectList->read(NULL, $id);
			$this->setTitle('Edit '.$tempProject['ProjectList']['title']);

			//Get Simple Db Row by knowing ProjectList ID
			$this->activeSimpleDb=$this->Simpledb->findById($tempProject['ProjectList']['simpledb_id']);
		
			
			$ProjectListDetails=$tempProject['ProjectListDetail'];
			$temp=array();
			foreach($ProjectListDetails as $ProjectListDetail)
			{
				$this->Atribut->recursive=0;
				$temp[]=array(
					'ProjectListDetail'=>$ProjectListDetail,
					'Atribut'=>$this->Atribut->read(NULL,$ProjectListDetail['Project_list_atribut_id'])
				);
			}
			$this->set('ProjectList',$tempProject);
			
			//for template
			//$this->loadModel('ProjectListDetail');
			
			$sql='SELECT ProjectListDetail.*, Atribut.name FROM `cms_project_list_details`
				ProjectListDetail,cms_atributs Atribut,cms_project_lists ProjectList WHERE
				ProjectListDetail.project_list_id=ProjectList.id AND ProjectListDetail.project_list_atribut_id=Atribut.id AND
				ProjectListDetail.project_list_id='.$id;
		
			$atributs=$this->ProjectList->query($sql);
			$this->set('atributs',$atributs);
			$this->set('simpledbId',$tempProject['ProjectList']['simpledb_id']);
			
			//for reference image from media yang belum ada
			$belumada =array();
			$this->set('media', 
			$this->Media->find('all'));
			//$this->Media->query('CALL showAllChild('.$id.')');
			
			$this->ProjectList->showAllChild($id);
			
			$sqlBelumAda='SELECT * FROM cms_media Media
				WHERE id NOT IN (Select a.id
				From cms_child_project_lists Inner Join
				cms_project_list_media b On cms_child_project_lists.id = b.Project_list_id
				Inner Join
				cms_media a On b.media_id = a.id)';
				
			$sql5='Select DISTINCT Media.*
				From cms_child_project_lists Inner Join
				cms_project_list_media ProjectListMedia On cms_child_project_lists.id =
				ProjectListMedia.Project_list_id Inner Join
				cms_media Media On ProjectListMedia.media_id = Media.id
				WHERE cms_child_project_lists.id<>'.$id.
				' ORDER BY Media.created DESC';
			
			$sqlMediaParentAdded='Select DISTINCT Media.*
				From cms_child_project_lists Inner Join
				cms_project_list_media ProjectListMedia On cms_child_project_lists.id =
				ProjectListMedia.Project_list_id Inner Join
				cms_media Media On ProjectListMedia.media_id = Media.id
				WHERE cms_child_project_lists.id='.$id.
				' ORDER BY Media.created DESC';
			
			//die($sql5);
			
			foreach($this->Media->query($sql5) as $meds)
			$belumada[$meds['Media']['id']]=$meds['Media']['name'];
		
			//$this->set('belumada',$this->Media->query($sqlBelumAda));
			$this->set('mediaForElement',$this->Media->query($sqlBelumAda));
			//$this->set('sql5',$sql5);
		
		
			//Mencari parent_id yang belum di isi/kosong
			$parent_id_isi=array();
			$parent_id_isi[0]='As Parent';
			$sql3='SELECT * from cms_project_lists ProjectList where id NOT IN (select id from cms_child_project_lists)';
		
			foreach($this->ProjectList->query($sql3) as $q){
				$parent_id_isi[$q['ProjectList']['id']]=$q['ProjectList']['title'];
			}
			
			$this->set('parent_id_isi', $parent_id_isi);
				
			//Mencari atribut yang belum di isi/kosong
			$atribut_drop_box=array();
			$sql=sprintf('SELECT Atribut.id, Atribut.name 
				FROM cms_atributs Atribut
				WHERE
				Atribut.id NOT IN (SELECT project_list_atribut_id FROM cms_project_list_details a WHERE
					a.project_list_id=%s)',$id);
			
			foreach($this->Atribut->query($sql) as $y)
			$atribut_drop_box[$y['Atribut']['id']]=$y['Atribut']['name'];
				
			$this->set('atribut_drop_box', $atribut_drop_box);			
			
			$media = $this->Media->find('all',array (
			'recursive'=>0,
			'order'=> array ('Media.id ASC')
			));
		
			$this->set('media', $media);
			
			//Media Added
			$sql=sprintf('SELECT * FROM cms_media Media WHERE id IN (SELECT media_id FROM cms_project_list_media WHERE project_list_id=%s)',$id);	    
				
			$result = array ();
			foreach ($media as $ax) 
				$result[$ax['Media']['id']] = $ax['Media']['name'];
			
			$primaryImage=$this->Media->findById($tempProject['ProjectList']['media_id']);
			//var_dump($primaryImage);
			//var_dump($this->Simpledb->findById(0));
			//die();
			
			$this->set('result', $result);
			$this->set('media_added',$this->Media->query($sql5)); //Media add all child only
			$this->set('media_parent_added',$this->Media->query($sqlMediaParentAdded)); //Media added parent only
			$this->set('mediaList',$this->Media->find('all'));
			$this->set('primaryImage',$primaryImage);
			
			//var_dump($this->Media->findById(30));
			//die();
				
			$atribut = $this->Atribut->find('all',array (
			'recursive'=>0,
			'order'=> array ('Atribut.id ASC')
			));
				
			$hasil = array ();
			foreach ($atribut as $ay)
			{
				$hasil[$ay['Atribut']['id']] = $ay['Atribut']['name'];
			}
				
			$this->set('hasil', $hasil);
			$this->ProjectList->id = $id;
			$this->set('post',
			$this->ProjectList->read());
		
			if (!$id)
			{
				$this->Session->setFlash('Invalid id ProjectList');
				$this->redirect(array('action' => 'index'), null, true);
			}
		
			if (empty($this->data))
			{
				$this->data = $this->ProjectList->find(array('id' => $id));
			}
			//UNTUK MENYIMPAN DATA
			else 
			{		
				//$var2 = $this->data['ProjectListDetail'];
				$var1 = $this->data['ProjectList'];
				$var3 = $this->data['ProjectListMedia'];
				$var4 = $this->data['Media'];
				$var4=array('Media'=>$var4);
						
				//var_dump($var1);
				//var_dump($var2);
				//var_dump($var3);
				//echo 'media'; var_dump($var4);
				//die();
				
				
				$projectId=$this->data['ProjectListMedia']['Project_list_id'];

				$deleteImages=array();
				
				if(array_key_exists('delete',$this->data))
				{
					$deleteImages=$this->data['delete'];
					
					//delete images from cms_project_lists_media
					foreach($deleteImages['mediaid'] as $image)
					{
						$sql=sprintf('DELETE FROM cms_project_list_media WHERE project_list_id=%s AND media_id=%s',
								 $projectId,$image);
						
						//echo $sql.'<br />';
						$this->ProjectListMedia->query($sql);
					}
				}
				
				//die();
				
				//Add Pic to Media
				$media['Media']=$this->data['Media'];
					
				$id=$this->data['ProjectList']['id'];
				
				if ($this->ProjectList->validates($this->data))
				{
					$this->ProjectList->saveAll($var1);
					//$this->ProjectListDetail->saveAll($var2);
					
					//Double Add
					//var_dump($var4);
					//var_dump($this->Media->validates($var4));
					//die();
					
					if($this->Media->validates($var4))
					{
						//Jika penyimpanan media sukses
						
						if($this->Media->save($var4)!==false)
						{
							//Add Media to Project List Media
							//Get New ID Media First
							$sql = 'SELECT * FROM cms_media Media ORDER BY created DESC';
							$media = $this->Media->query($sql);
							$mediaId = $media[0]['Media']['id'];
							
							//Create array to save in cms_project_media db
							$projectListMedia['ProjectListMedia']=array(
								'Project_list_id'=>$projectId,
								'media_id'=>$mediaId
							);
							
							$this->ProjectListMedia->save($projectListMedia);
						}
					}
								
					//Check media id on this project list are still have on cms_project_list_media
					$row=$this->ProjectList->findById($projectId);
					
					//Update with child newest image one
					//$query=$this->ProjectListMedia->query('CALL showAllChild('.$projectId.')');
					
					$this->ProjectList->showAllChild($projectId);
					
					$sql='Select DISTINCT Media.*
						From cms_child_project_lists Inner Join
						cms_project_list_media ProjectListMedia On cms_child_project_lists.id =
						ProjectListMedia.Project_list_id Inner Join
						cms_media Media On ProjectListMedia.media_id = Media.id
						WHERE Media.id='.$row['ProjectList']['media_id'].'
						ORDER BY Media.id DESC';
					$query=$this->ProjectListMedia->query($sql);
					
					//First check are media id have set
					if($row['ProjectList']['media_id']!=0)
					{
						$cond=array('conditions'=>array('project_list_id'=>$id,'media_id'=>$row['ProjectList']['media_id']));
						$row=$this->ProjectListMedia->find('first',$cond);
						if($row===false) $this->ProjectList->updateMediaId($id);
					}
					
					//$this->Session->setFlash($this->data['ProjectList']['title'].' has updated','success');
					
					///////// change value from table cms_project_list_detail////////////////
				
					$detailIds = $this->ProjectListDetail->find('all',array('conditions'=>array('ProjectListDetail.Project_list_id'=>$id)));
					
					foreach ($detailIds as $detailId):
						$this->ProjectListDetail->id = $detailId['ProjectListDetail']['id'];
						$this->ProjectListDetail->saveField('value',$this->data['ProjectList']['coba'.$detailId['ProjectListDetail']['id']]);
					endforeach;
					
					/////////////////////////////////////////////////////////////////////////
					
					///////// change field modified from table cms_simpledbs////////////////
					
					$findTitles = $this->Simpledb->find('all',array('limit'=>1,'conditions'=>array('Simpledb.id'=>$this->data['ProjectList']['simpledb'])));
					
					foreach ($findTitles as $findTitle):
						if ($findTitle['Simpledb']['id']==$this->data['ProjectList']['simpledb'])
						{
							$this->Simpledb->id = $this->data['ProjectList']['simpledb'];
							$this->Simpledb->saveField('title', $findTitle['Simpledb']['title']);
						}
					endforeach;
					
					/////////////////////////////////////////////////////////////////////////
					
					//$this->Session->setFlash('Changes has been saved.','success');
					$this->Session->setFlash($this->data['ProjectList']['title'].' has been updated','success');
					$this->redirect(array('controller'=>'project_lists','action' => 'edit',$id));
				} 
				else
					$this->Session->setFlash($this->data['ProjectList']['title'].' could not be saved. Please try again','failed');
					//$this->Session->setFlash('Error found!','failed');
			}
		}
    }
    
    function delete ($id = null) {
	if ($id==null) {
	    $this->Session->setFlash('invalid id ProjectList','failed');
	    $this->redirect(array('action' => 'index'),null,true);
	}else{
	    //Get SimpleDb ID from this project list ID
	    $row=$this->ProjectList->FindById($id);
	    #$this->ProjectList->query('SET GLOBAL max_sp_recursion_depth = 40');
	    //$this->ProjectList->query('CALL showAllChild('.$id.')');
	    $this->ProjectList->showAllChild($id);
	    //die();
	    $sql='DELETE FROM cms_project_lists WHERE id IN (SELECT id FROM cms_child_project_lists)';
	    
	    if ($this->ProjectList->query($sql)) {
		$this->Session->setFlash('ProjectList #'.$id.' Deleted and all child','success');
	    }
	    
	    $this->redirect(array('controller'=>'project_lists','action' => 'index',$row['ProjectList']['simpledb_id']));	    
	}	
    }

    function share($customer_id, $recipe_id) {
	//action logic goes here..
    }

    function search($query) {
	//action logic goes here..
    }
    
    function addMedia($id=null)
	{
		//var_dump($id);
		//var_dump($this->data);
		$this->layout='ajax';
		if(!empty($this->data))
		{
			foreach($this->data as $x)
			$projectListMedia[]=array('Project_list_id'=>$id,
							'media_id'=>$x);
			
			//$projectListMedia=array('ProjectListMedia'=>$projectListMedia);
			$this->ProjectListMedia->saveAll($projectListMedia);
			
			$this->Session->setFlash('New image(s) has been added','success');
		}
		die();
    } 
	
	function database()
	{
		$jakarta=60*60*6;			
        $this->set('jakarta',$jakarta);
		
		$result=$this->Simpledb->find('all');
		$this->set('simpledbs',$result);
		
		$countDb = $this->Simpledb->find('count');
	
		// $this->paginate = array('limit' => 3, 'page' => 1);
		// $this->set('simpledbs', $this->paginate('Simpledb'));
		
		$this->set(compact('countDb'));
    }
    
	public function getatribut(){
        $this->layout='ajax';
        $this->set('projectId',$this->ProjectListDetail->getProjectAtributMaxId());
		$this->set('cobas', ClassRegistry::init("Atribut")->find('all'));
    }
	
}
?>