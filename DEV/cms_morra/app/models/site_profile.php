<?php

class SiteProfile extends AppModel {
	var $name = 'SiteProfile';
	
	public function find( $conditions = NULL, $fields = array ( ), $order = NULL, $recursive = NULL ){
		$modelName='SiteProfile';
		
		$result=parent::find($conditions, $fields, $order, $recursive);
		
		$jakarta=60*60*6;
		if($conditions=='first'){
			$result[$modelName]['created']=date('d/m/y @ H:i',$jakarta+strtotime($result[$modelName]['created']));
			$result[$modelName]['modified']=date('d/m/y @ H:i',$jakarta+strtotime($result[$modelName]['modified']));
		}
		
		return $result;
	}
	
	public function getCss(){
        $cssLoc=WWW_ROOT.'css';
        //var_dump($templateLoc);
        //die();
        $list=scandir($cssLoc);
        
        $css=array();
        foreach($list as $file){
            if(preg_match('/.css$/',$file)>0)
                $css[$file]=$file;
        }

        return $css;
    }
	
	public function getJs(){
        $jsLoc=WWW_ROOT.'user_js';
        //var_dump($templateLoc);
        //die();
        $list=scandir($jsLoc);
        
        $js=array();
        foreach($list as $file){
            if(preg_match('/.js$/',$file)>0)
                $js[$file]=$file;
        }

        return $js;
    }
	
	// public $validate=array(
		// 'name'=>'notEmpty',
		// 'message' => 'name of attribute can not be empty'
	// );
	
		public $validate=array(
			'title'=>array(
				'rule'=>'notEmpty',
				'message'=>'Title tidak boleh kosong'
			)
		);
	
}
?>