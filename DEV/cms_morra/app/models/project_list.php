<?php
class ProjectList extends AppModel {
	public $name = 'ProjectList';
	//public $belongsTo=array('Page');
	public $hasMany = array (
		 'ProjectListDetail'=>array(
			 'className'=>'ProjectListDetail',
			 'foreignKey'=>'id'
		 ),
		 'ProjectListMedia'=>array(
			 'className'=>'ProjectListMedia',
			 'foreignKey'=>'Project_list_id'		
		 ),
		 'ProjectList'=>array(
			 'className'=>'ProjectList',
			 'foreignKey'=>'parent_id'
		 )
	);
	
	public $validate = array(
		'parent_id' => array (
			'rule'=>'notEmpty',
			'message'=>'Field tidak Boleh kosong'
		),
		'title' => array (
			'rule'=>'notEmpty',
			'message'=>'Field tidak Boleh kosong'
		)
	);
	
	public function find( $conditions = NULL, $fields = array ( ), $order = NULL, $recursive = NULL ){
		$modelName='ProjectList';
		
		$result=parent::find($conditions, $fields, $order, $recursive);
		
		$jakarta=60*60*6;
		
		if($result!==false)
			switch($conditions){
			    case 'first':
				$result[$modelName]['created']=date('d-m-Y @ H:i',$jakarta+strtotime($result[$modelName]['created']));
				$result[$modelName]['modified']=date('d-m-Y @ H:i',$jakarta+strtotime($result[$modelName]['modified']));                    
				break;
			    case 'all':
				for($i=0; $i<count($result); $i++){
				    $result[$i][$modelName]['created']=date('d-m-Y @ H:i',$jakarta+strtotime($result[$i][$modelName]['created']));
				    $result[$i][$modelName]['modified']=date('d-m-Y @ H:i',$jakarta+strtotime($result[$i][$modelName]['modified']));
				}
				break;
			}
		
		return $result;
	}
	
	//Update Media ID with newest Media ID on child or parent
	public function updateMediaId($id=null){
		if($id!=null){
			$data=$this->findById($id);

			//Check media have add media id on his id
			$cond=array('conditions'=>array('project_list_id'=>$id),
				    'order'=>array('created desc'));
			$row=$this->ProjectListMedia->find('first',$cond);
			if($row!==false){
				//If yes update with newest its media ID
				$data['ProjectList']['media_id']=$row['ProjectListMedia']['media_id'];
				$this->save($data);
			}else{
				//If no, update with newest on their child
				$this->showAllChild($id);
				
				$sql='Select ProjectListMedia.Project_list_id, ProjectListMedia.media_id
					From cms_child_project_lists ChildProjectList Inner Join
					  cms_project_list_media ProjectListMedia On ChildProjectList.id =
					    ProjectListMedia.Project_list_id
					Order By ProjectListMedia.modified Desc';
				$rows=$this->query($sql);
				
				//Check are its child have media id at least one or more
				if(count($rows)>0){
					//If yes just update with newest
					$data['ProjectList']['media_id']=$rows[0]['ProjectListMedia']['media_id'];
					$this->save($data);
				}else{
					//If no check its media id have set or not
					if($data['ProjectList']['media_id']!=0){
						//if yes(mean set) set it to 0(zero)
						$data['ProjectList']['media_id']=0;
						$this->save($data);
						
					}
					//if no don't change anything
				}
			}
		}
		
		return true;
	}
	
	public function showAllChild($parentId){
		$sql=array(
			'DROP TABLE IF EXISTS cms_child_project_lists',
			'CREATE TABLE IF NOT EXISTS cms_child_project_lists LIKE cms_project_lists');
		
		$this->query($sql[0]);
		$this->query($sql[1]);
		
		$this->__showAllChild($parentId);
	}
	
	private function __showAllChild($parentId){
		$this->unbindModel(
		    array('hasMany' => array('ProjectListDetail','ProjectListMedia'))
		);

		//Select all child
		$rows=$this->find('all',array('conditions'=>array('parent_id'=>$parentId)));
		
		$sql='INSERT IGNORE INTO cms_child_project_lists SELECT * FROM cms_project_lists WHERE id='.$parentId;
		$this->query($sql);
		
		foreach($rows as $row)
			$this->__showAllChild($row['ProjectList']['id']);		
	}
}
?>