<?php

class AppController extends Controller{
    public $layout='cms_default';
    
    //customize
    public $active='index';
    public $uses=array('Media');
    
    public function __construct( ){
        parent::__construct();
        
        $this->set('needThumbBrowser',false);
    }
    
    public function pr($anArray=array()){
        echo '<pre>';
        print_r($anArray);
        echo '</pre>';
    }
    
    public function set( $one, $two = NULL ){
        if($one=='title_for_layout'){
            $two='Morra - '.$two;
        }
        
        parent::set($one,$two);
    }
    
    public function beforeRender($activePage='Index'){
        $this->set('activePage',$activePage);
        parent::beforeRender();
    }
    
    public function showThumbBrowser(){
        $this->set('needThumbBrowser',true);
    }
}