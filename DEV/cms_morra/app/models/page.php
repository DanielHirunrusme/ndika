<?php

class Page extends AppModel {
    public $name='Page';
    public $hasMany=array(
        'PageDetail'=>array(
            'className'=>'PageDetail',
            'foreignKey'=>'page_id'
        )
    );
    public $validate=array(
        'title'=>array(
            'rule'=>'notEmpty',
            'message'=>'Title tidak boleh kosong'
        )
    );
    
    public function find( $conditions = NULL, $fields = array ( ), $order = NULL, $recursive = NULL ){
            $modelName='Page';
            
            $result=parent::find($conditions, $fields, $order, $recursive);
            
            $jakarta=60*60*6;
            
            if($result!==false){
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
            }
            
            return $result;
    }
	
    public function getMaxId(){
        $max=$this->find('first', array('fields' => array('MAX(Page.id) as max_id')));
        $max=$max[0]['max_id'];
        
        return $max;
    }
    
    public function getPageMaxId(){
        $condition=array('order'=>array('Page.id DESC'));
        
        return $this->find('first',$condition);
    }
    
    public function getTemplate(){
        $templateLoc=VIEWS.'users'.DS.'template';
        //var_dump($templateLoc);
        //die();
        $list=scandir($templateLoc);
        
        $template=array();
        foreach($list as $file){
            if(preg_match('/.ctp$/',$file)>0 && $file!='default.ctp')
                $template[$file]=$file;
        }

        return $template;
    }
    
    public function save( $data = NULL, $validate = true, $fieldList = array ( ) ){
        if(!empty($data['Page']['title']))
            $data['Page']['title']=ucfirst($data['Page']['title']);
        return parent::save($data);
    }
}