<?php

	class PagesDetailsController extends AppController 
	{
		public $name = 'PagesDetails';
		
		public function add()
		{
			$this->PagesDetail->save($this->data);
			$this->redirect(array('controller'=>'pages','action'=>'index'));
		}
		
		public function edit()
		{
			$this->layout='ajax';
			//var_dump($this->data);
			
			if(!empty($this->data))
			{
				//Check validate
				if($this->data['PagesDetail']['value']!='')
				{
					if($this->PagesDetail->save($this->data)===false)
					{
						echo '0'; //Berarti gagal
					}
				}
				else
				{
					echo '0'; //Berarti gagal
				}
			}
			
			//die();
		}
		
		public function test()
		{
			$this->set('page',$this->PagesDetail->find('all'));
		}
	}

?>