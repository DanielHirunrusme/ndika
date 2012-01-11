<?php

class UsersController extends AppController {
    public $name='Users';
    public $layout='user_default';
    public $uses=array('Page','User','SiteProfile','ProjectList','PageDetail','Atribut');
    public $components = array('FrontEnd','Email');
	
    function delete ($id = null) {
        if (!$id)
		{
            $this->Session->setFlash('Invalid user ID');
            $this->redirect(array('action' => 'add'),null,true);
        }
		
        if ($this->User->delete($id))
		{
            $this->Session->setFlash('User account has been deleted','success');
            $this->redirect(array('action' => 'add'));
        }
    }
	
    function change($id=null) {
	if($id!=NULL){
	    $data=$this->User->findById($id);
	    $data['User']['roles']=$data['User']['roles']==0?1:0;
	    if($this->User->save($data)===false){
		echo '0'; //mean failed
	    }
	    $this->redirect (array('action' => 'add'));
	}
    }
    
    function add()
    {
        $jakarta=60*60*6;			
        $this->set('jakarta',$jakarta);
        $list_user = $this->User->find('all');
        $this->set('list_user',$list_user);
        $this->layout = 'cms_default';
        if (!empty($this->data)) {
            if(Security::hash($this->data['User']['confirm'],null,true)==$this->data['User']['password']) {
                $this->User->set($this->data);
                if ($this->User->validates()){
                    $this->User->save($this->data);
                    $this->Session->setFlash('New user has been created','success');
                    $this->redirect (array('action' => 'add'));
                }else{
                    $this->Session->setFlash('Please complete all required fields.','failed');
                    $this->redirect (array('action' => 'add'));
                }
            } else {
                $this->Session->setFlash('Add user failed. Confirmation password must match with password. Please try again','failed');
                $this->redirect (array('action' => 'add'));
            }
        }
    }
	
	
	
    function change_pass($id=null) {
	$this->layout = 'cms_default';
	if($id!=NULL)
	{
			$this->set('id',$id);
	
			$jakarta=60*60*6;			
            $this->set('jakarta',$jakarta);
            $list_user = $this->User->find('all');
            $this->set('list_user',$list_user);
            
            $this->User->id = $id;
                            
            $this->set('User', $id);
            $user_id = $this->User->findById($id);
            $this->set('user_id',$user_id);
            
            if(empty($this->data)) {
                $this->data = $this->User->find(array('id' => $id));
            }
            else {
                //UNTUK MENYIMPAN CHANGE PASSWORD
                //UNTUK MENYIMPAN CHANGE PASSWORD
                $this->User->id = $id;
                
                $user=$this->Auth->user();
                
                //Check old pass
                if($user['User']['roles']!=1)
                    //If roles not admin check with old password
                    $checkOldPass=Security::hash($this->data['User']['old'],null,true)==$this->data['User']['password'];
                else
                    //If roles is admin he/she no need to be check with old password
                    $checkOldPass=true;
                
                if(strlen($this->data['User']['new'])<5){
                    $this->Session->setFlash('Password must at least 5 charachter or more','failed');
                    $this->redirect (array('controller'=>'users','action' => 'change_pass',$id));
                }else if($checkOldPass && $this->data['User']['new']==$this->data['User']['confirm']){
                    $this->data['User']['password']=Security::hash($this->data['User']['new'],null,true);
                    //$this->data['User']['password']=$this->data['User']['new'];
                    //var_dump($this->data['User']['password']);
                    //die();
                    
                    //var_dump($this->data);
                    //var_dump($this->User->validates($this->data));
                    //die();
                    
                    if ($this->User->validates($this->data)){
                        $this->User->save($this->data);
                        $this->Session->setFlash('Password has been updated','success');
                        $this->redirect (array('controller'=>'users','action' => 'add'));
                    }
                    else{
                        $this->Session->setFlash('Change password failed. Please try again','failed');
                        $this->redirect (array('controller'=>'users','action' => 'change_pass',$id));
                    }
                } else {
                    if(!$checkOldPass)
                        $this->Session->setFlash('Change password failed. Old password wrong','failed');
                    else
                        $this->Session->setFlash('Change password failed. Confirmation password didn\'t match with password. Please try again','failed');
                        
                    $this->redirect (array('controller'=>'users','action' => 'change_pass',$id));
                }
            }
	}else{
            //var_dump($this->data);
            //die();
            $this->Session->setFlash('invalid id User');
            $this->redirect(array('action' => 'add'), null, true);
        }
    }
	
    function edit_user($id=null){
        $jakarta=60*60*6;			
        $this->set('jakarta',$jakarta);
        $list_user = $this->User->find('all');
        $this->set('list_user',$list_user);
		$this->set('id',$id);
        
        
        //Mencari roles yang belum di isi/kosong
        $roles=array();
        $roles[0]='Non Admin';
        $roles[1]='Admin';
        /* $sql3='SELECT User.id, User.roles 
        FROM cms_users User';
        
        foreach($this->User->query($sql3) as $q){
        $roles[$q['User']['id']]=$q['User']['roles'];
        } */
        $this->set('roles', $roles);
                
        //var_dump($roles);
        //die();	
	
        $this->layout = 'cms_default';
		if ($id!=null) {
            $this->User->id = $id;
                            
            $this->set('User', $id);
            $user_id = $this->User->findById($id);
            $this->set('user_id',$user_id);
		
            if (!$id) {
                $this->Session->setFlash('invalid id User');
                $this->redirect(array('action' => 'add'), null, true);
            }
            
            if (empty($this->data)) {
                $this->data = $this->User->find(array('id' => $id));
            }
            //UNTUK MENYIMPAN DATA
            else {
                $id=$this->data['User']['id'];
                
                //var_dump($this->data);
                //die();
                
                if ($this->User->validates($this->data)){
                        
                        $this->User->save($this->data);
                        
                        $this->Session->setFlash('User has been updated','success');
                        $this->redirect(array('controller'=>'Users','action' => 'add'));
                }
                else {
                        $this->Session->setFlash('The User could not be saved. Please try again','failed');
                }
            }
        }
    }
    
    function login() 
	{  
		$this->layout = 'login_default';
        $this->setTitle('Login');
        
        if($this->Auth->isAuthorized())
		{
            $this->redirect(array('controller'=>'pages','action'=>'index'));
		}
    }
	
	
    function logout()
    {
		$this->redirect($this->Auth->logout());
    }
    
    function __validateLoginStatus()
    {
        if($this->action != 'login' && $this->action != 'logout')
        {
            if($this->Session->check('User') == false)
            {
                $this->redirect('login');
                $this->Session->setFlash('The URL you\'ve followed requires you login.');
            }
        }
    }
	
    function index_login()
    {
        $this->layout = 'login_default';
    }
	
    function forget()
    {
		$this->layout = 'login_default';
        //var_dump(get_defined_constants(true));
        //die();
        
        //mail("surya_yohanes@yahoo.com","Success","Thanks, that works");
        if(!empty($this->data)){
            //Find user email
            $row=$this->User->findByEmail($this->data['User']['email']);
            //var_dump($row);
            //var_dump($this->data);
            //die();
            //Update password and don't forget to hash the password
            
            
            $this->Email->delivery='debug';
            
            $this->Email->from = 'admin@morrastudio.com';
            $this->Email->to = 'surya_yohanes@yahoo.com';
            $this->Email->subject = 'Test';
            $body=sprintf('
                email: %s <br />
                your new password: %s <br />
            ');
            $this->Email->send('Hello message body!');
            
            //die();
        }
    }

    public function index(){

    }
	
    public function about_us(){
        $this->layout='ajax';
    }
    
    public function services(){
        $this->layout='ajax';
        
    }
    
    public function partners(){
        $this->layout='ajax';
        
    }
    
    public function careers(){
        $this->layout='ajax';
    }
    
    public function contact_us(){
        $this->layout='ajax';
    }
    
    public function index_ajax(){
        //$this->layout='ajax';
        
        $this->render('index','ajax');
    }
    
    /**
    * Mendapatkan page template berdasarkan id atau title page tersebut
    * @param string $type diisi dengan sebuah string'id'
    * @param string $value diisi dengan value yang dimaksud dapat berupa id ataupun title page. Bergantung dari type yang diisi. Jika type yang diisi 'id' maka value yang diisi adalah id page. Begitu juga sebaliknya.
    * @access public
    */
    public function getpage($type='id',$value=null){
        $this->layout='ajax';
        $this->FrontEnd->pageId=$value;
		
		$media=$this->FrontEnd->getMedia();
        $atribut=$this->FrontEnd->getAtribut();
        $project=$this->FrontEnd->getProject();
        //die;
		
		//////////////// FOR PAGE DETAIL ATTRIBUTE ///////////////////
		
		$atributName=array();
		$atributs = $this->Atribut->find('all');
		
		foreach ($atributs as $atribut):
			$atributName[$atribut['Atribut']['id']] = $atribut['Atribut']['name'];
		endforeach;
		
		$atributPage = array();
		$pageDetails = $this->PageDetail->find('all',array('conditions'=>array('PageDetail.page_id'=>$value)));
		
		foreach ($pageDetails as $pageDetail):
			$atributPage[$atributName[$pageDetail['PageDetail']['atribut_id']]] = $pageDetail['PageDetail']['value'];
		endforeach;
		
		$this->set(compact('atributPage'));
		
		///////////////////////////////////////////////////////////////
        
        $row=$this->Page->findById($value);
        if($row!==false){
            //will get one record of that type and value
            if($value!=null){
                $condition=array('conditions'=>array($type=>$value));
                $row=$this->Page->find('first',$condition);
                
                if(count($row)>=1){
                    
                }
                
                $this->set('id',$row['Page']['id']);
                $this->set('title',$row['Page']['title']);
                $this->set('description',$row['Page']['description']);
                $this->set('content',$row['Page']['content']);
                $this->set('parent_id',$row['Page']['parent_id']);
                $this->set('template',$row['Page']['template']);
                $this->set('created',$row['Page']['created']);
                $this->set('modified',$row['Page']['modified']);
                $this->set('status',$row['Page']['status']);
                $this->set('atribut',$atribut);
                $this->set('project',$project);
                
                //var_dump($atribut);
                //die();
                
                $template=explode('.',$row['Page']['template']);
                $this->render('template/'.$template[0]);
				
            }
        }else exit;
    }
    
    public function beforeRender($activePage='User'){
        //$this->set('activePage',$activePage);
        $sql='SELECT * FROM cms_pages Page WHERE status=1 AND parent_id=0 ORDER BY id';
        
        //$pages=$this->Page->find('all',array('conditions' => array('parent_id' => NULL)));
        
        $pages=$this->Page->query($sql);
        $this->set('pages',$pages);
        $this->set('siteProfile',$this->SiteProfile->find('first'));
        parent::beforeRender($activePage);
    }
    
    public function beforeFilter(){
        parent::beforeFilter();
        $this->Auth->allow('index','forget','getpage','getpagetitle','sendmail');
    }
    
    public function getpagetitle($id=null){
        if($id!=null){
            $row=$this->Page->findById($id);
            
            if($row!==false)
                echo $row['Page']['title'];
			
            exit;
			
        }
    }
	
    function sendmail(){
		//echo '0';
		//die();
		//$this->layout="ajax";
        if(!empty($this->data)){
            //Find user email
            //$row=$this->User->findByEmail($this->data['User']['email']);
            //var_dump($row);
            //var_dump($this->data);
            //die();
            //Update password and don't forget to hash the password
            
            //$this->Email->delivery='debug';
            
            $success = $this->Email->from = $this->data['contact']['email'];
            $success = $this->Email->to = $this->admin;
            $success = $this->Email->subject = $this->data['contact']['subject'];
            $success = $this->Email->send($this->data['contact']['body']);
			
			if($success)
			{
				echo "0";
			}
			else
			{
				echo "1";
			}
        }
		
		die();
		
		// if(array_key_exists('page_id',$this->data['contact']))
			// $this->redirect('/users/index#'.$this->data['contact']['page_id']);
		// else
			// $this->redirect('/users/index');
    }
	
	//private $admin='hello@morrastudio.com';
	private $admin='ndika.bahari@gmail.com';
}