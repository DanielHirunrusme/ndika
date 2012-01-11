<?php

class Atribut extends AppModel {
    public $name='Atribut';
    public $hasMany='PagesDetail';
    
    //public $validate=array(
    //    'name'=>'notEmpty'                    
    //);
	
	public $validate=array(
        'title'=>array(
            'rule'=>'notEmpty',
            'message'=>'Title tidak boleh kosong'
        )
    );
}