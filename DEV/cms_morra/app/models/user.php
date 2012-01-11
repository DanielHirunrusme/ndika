<?php 
class User extends AppModel
{
	var $name = 'User';
	var $validate = array(
		'username' => array(
			'username_harus_diisi'=>array(
				'rule' => 'notEmpty',
				'message' => 'Username field harus diisi'),
			'username_harus_unik'=>array(
				'rule' => 'isUnique',
				'message' => 'Username field harus unik')),
		'email' => array(
			'rule' => array('email',true),
			'message' => 'Email field harus valid'),
		'password' => array(
			'rule' => 'notEmpty',
			'message' => 'Password field harus diisi')
	);
	
	public $hasMany=array(
	    'ProjectList'=>array(
		'className'=>'ProjectList',
		'foreignKey'=>'simpledb_id'
	    )
	);

	function validateLogin($data)
	{
		$user = $this->find(array
		('username' => $data['username'], 
		'password' => $data['password']), 
		array('id', 'username'));
		
		//pr($data['password']);
		//die();
			
			
		if(!empty($user))
		    return $user['User'];
		return false;
	}  
    
}