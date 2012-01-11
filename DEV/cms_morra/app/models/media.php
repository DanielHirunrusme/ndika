<?php
App::import('Component','Image');
App::import('Component','MorraResize');

class Media extends AppModel {
    public $name = 'Media';
    public $components = array('Image');
    private $Image=null;
    private $Resize=null;

    public function __construct( $id = false, $table = NULL, $ds = NULL ){
        parent::__construct($id, $table, $ds);

        $this->Image=new ImageComponent();
        $this->Resize=new MorraResizeComponent();        
    }

    public function add($file=array()){
        
    }
    
    public function save( $data = NULL, $validate = true, $fieldList = array ( ) ){
        //check data first
        if($data['Media']['name']['error']==4){
            return false;
        }
        
        //Prepare data
        $data['Media']=$data['Media']['name'];
        
        $tempData['Media']=array(
            'name'=>$data['Media']['name'],
            'type'=>$data['Media']['type'],
            'size'=>$data['Media']['size']
        );
        
        $split=explode('/',$tempData['Media']['type']);
        
        $ext=$split[1];
        
        if($ext=='pjpeg')
            $ext='jpeg';
        
        //Check MIME-Type is allowed
        if($this->_filterType($tempData['Media']['type'])){
            //Save data to database for future use
            //Change MIME-TYPE -> image/jpeg to jpg or jpeg
            
            $tempData['Media']['type']=$ext;
            
            parent::save($tempData, $validate, $fieldList);
            
            $row = $this->find('first', array('order' => array('Media.modified DESC')));
            
            //Upload image to server
            //Tells whether the file was uploaded via HTTP POST
            if(is_uploaded_file($data['Media']['tmp_name'])){
                $dest=sprintf('%simg'.DS.'upload'.DS.'%s.%s',WWW_ROOT,$row['Media']['id'],$row['Media']['type']);
                //Upload original file
                move_uploaded_file(
                    $data['Media']['tmp_name'],$dest
                );
                
                //Resize original file to thumb for view
                $src=sprintf('img'.DS.'upload'.DS.'%s.%s',$row['Media']['id'],$row['Media']['type']);;
                $dest=sprintf('img'.DS.'upload'.DS.'thumb'.DS.'%s.%s',$row['Media']['id'],$row['Media']['type']);
                $this->Resize->resize($src,$dest);
                //die();
                //$Image->resize($src, $dest, 200, 200, 75);
            }
            
            return true;
        }
        
        return false;
    }
    
    public function delete( $id = NULL, $cascade = true ) {
        //$this->ProjectListMedia=ClassRegistry::init('ProjectListMedia');
        if($id!=NULL){
            $row=$this->findById($id);
            
            $file=sprintf('%s.%s',$row['Media']['id'],$row['Media']['type']);
            
            // Delete File from directory first
            $dest=sprintf('%simg'.DS.'upload'.DS.'%s',WWW_ROOT,$file);
            $destThumb=sprintf('%simg'.DS.'upload'.DS.'thumb'.DS.'%s',WWW_ROOT,$file);
            // Delete file
            unlink($dest);
            unlink($destThumb);
            
            //Delete data in database media
            //Before delete media from database. Delete all used media in cms_project_list_media first
            $sql="DELETE FROM cms_project_list_media WHERE media_id = ".$id;
            $this->query($sql);
            
            //Update project_list media_id to 0(zero) mean no image
            $sql="UPDATE cms_project_lists SET media_id = 0 WHERE media_id =".$id;
            $this->query($sql);
            
            parent::delete($id);
            return true;
        }
        
        return false;
    }
    
    private function _getNewName($data=NULL){
        //var_dump($data);
        //die();
        
        //Get ext
        $ext='';
        $listExt=array('jpg','png','gif','jpg');
        
        if($data!=NULL){
            for($i=0; $i<count($this->allowType); $i++){
                if($this->allowType[$i]==$data['Media']['type']){
                    $ext=$listExt[$i];
                    break;
                }
            }
            
            return sprintf('%s.%s',$data['Media']['id'],$ext);
        }
        
        return false;
    }
    
    private function _filterType($typeTarget=NULL){
        if($typeTarget!=NULL){
            foreach($this->allowType as $type){
                if($type==$typeTarget){
                    return true;
                }
            }            
        }
        
        return false;
    }
    
    public function find( $conditions = NULL, $fields = array ( ), $order = NULL, $recursive = NULL ){
            $modelName='Media';
            
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
    
    public function getDimension($id=null){
        if($id!=null){
            $row=$this->find('first',array('conditions'=>array('id'=>$id)));
            $filename=sprintf('img'.DS.'upload'.DS.'%s.%s',$row['Media']['id'],$row['Media']['type']);
            return array('width'=>$this->Resize->getWidth($filename),
                           'height'=>$this->Resize->getHeight($filename));
        }
        
        return false;
    }

    private $allowType=array('image/jpeg','image/png','image/gif','image/pjpeg');
}