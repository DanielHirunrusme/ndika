<?php

	class SiteProfileDetailsController extends AppController {
		var $name = 'SiteProfileDetails';
		public $helpers = array('Form', 'Html', 'Js', 'Time');    
		public $components = array('RequestHandler');
		public $title='Site Profile';
		public $uses= array('SiteProfileDetail','SiteProfile','Atribut');
			
	}

?>