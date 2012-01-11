<?php
class AppController extends Controller{
	//var $helpers = array('Js' => array('prototype', 'scriptaculous.js?load=effects'), 'Ajax', 'Form', 'Html');

    public $layout='cms_default';    
    //customize
    public $active='index';
    public $uses=array('Media','SiteProfile','Simpledb','SiteProfileDetail','Atribut','PageDetail');
    public $components = array('Auth','Session');
    
    public function __construct( )
	{
        parent::__construct();
        
        $this->set('needThumbBrowser',false);
    }
    
    public function setTitle($title=null)
	{
        if($title!=null)
            $this->set('title_for_layout', $title);
        
        return false;
    }
    
    
    public function pr($anArray=array())
	{
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
        $this->set('site','CMS Morra');
        $this->set('user',$this->Auth->user());
        $this->set('simpledbs',$this->Simpledb->find('all'));
        parent::beforeRender();
    }
    
    function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->userModel = 'User';
        $this->Auth->fields = array(
            'username' => 'email',
            'password' => 'password'
        );
        $this->Auth->allow('login');
        $this->Auth->authError='Please login to view that page';
        $this->Auth->loginError='Incorrect username/password combination';
        $this->Auth->loginRedirect=array('controller'=>'pages','action'=>'index');
        $this->Auth->logoutRedirect=array('controller'=>'users','action'=>'login');
		
		//////////////// FOR MEDIA IMAGES ///////////////////
		
		$pic = array();
		$medias = $this->Media->find('all');
		
		foreach ($medias as $media):
			$pic[$media['Media']['id']] = 'upload/'.$media['Media']['id'].'.'.$media['Media']['type'];
		endforeach;
		
		$this->set(compact('pic'));
		
		//////////////////////////////////////////////////////
		
		$atributName=array();
		$atributs = $this->Atribut->find('all');
		
		foreach ($atributs as $atribut):
			$atributName[$atribut['Atribut']['id']] = $atribut['Atribut']['name'];
		endforeach;
		
		//////////////// FOR SITE PROFILE DETAIL ATTRIBUTE ///////////////////
		
		$atributSite = array();
		$siteProfileDetails = $this->SiteProfileDetail->find('all');
		
		foreach ($siteProfileDetails as $siteProfileDetail):
			$atributSite[$atributName[$siteProfileDetail['SiteProfileDetail']['atribut_id']]] = $siteProfileDetail['SiteProfileDetail']['value'];
		endforeach;
		
		//////////////////////////////////////////////////////
		
		//////////////// FOR FAV ICON ///////////////////
		
		$siteProfiles = $this->SiteProfile->find('first');
		
		$iconMedias = $this->Media->find('all',array('conditions'=>array('Media.id'=>$siteProfiles['SiteProfile']['fav_icon'])));
		
		foreach ($iconMedias as $media):
			$favicon = '/app/webroot/img/upload/'.$media['Media']['id'].'.'.$media['Media']['type'];
		endforeach;
		
		//////////////////////////////////////////////////////
        
		$this->set(compact('atributSite','atributName','favicon','iconMedias'));
    }

    public function showThumbBrowser()
	{
        $this->set('needThumbBrowser',true);
    }
}