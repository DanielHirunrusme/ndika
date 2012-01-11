<?php
class FrontEndComponent extends Object{
    public $pageId=1;
    
    public function __construct(){
        parent::__construct();
        
        $this->PagesDetail=ClassRegistry::init('PagesDetail');
        $this->Media=ClassRegistry::init('Media');
        $this->Atribut=ClassRegistry::init('Atribut');
        $this->Simpledb=ClassRegistry::init('Simpledb');
        $this->ProjectList=ClassRegistry::init('ProjectList');
        $this->imageUrl='/cms_morra/'.IMAGES_URL.'upload/';
    }
    
    public function getAtribut(){
        $sql=sprintf('Select Atribut.id, Atribut.name, PagesDetail.value
From cms_pages_details PagesDetail Inner Join
  cms_atributs Atribut On Atribut.id = PagesDetail.atribut_id
WHERE PagesDetail.page_id=%s',$this->pageId);
        $this->PagesDetail->recursive=0;
        
        //Get all atribut
        $atribut=array();
        //Get all filled atribut(have inserted)
        foreach($this->PagesDetail->query($sql) as $x)
            $atribut[$x['Atribut']['name']]=$x['PagesDetail']['value'];
        
        //var_dump($atribut);
        //Get all unfilled atribut(haven't inserted)
        $sql=sprintf('SELECT * FROM cms_atributs Atribut
WHERE id NOT IN (SELECT atribut_id FROM cms_pages_details WHERE page_id=%s)',$this->pageId);

        //var_dump($this->PagesDetail->query($sql));
        //die();

        foreach($this->PagesDetail->query($sql) as $x)
            $atribut[$x['Atribut']['name']]='';
            
        return $atribut;
    }
    
    public function getMedia(){
        //var_dump(get_defined_constants(true));
        //die();
        $tempMedia=$this->Media->find('all');
        
        $media=array();
        foreach($tempMedia as $x){
            $media[]=array(
                'id'=>$x['Media']['id'],
                'name'=>$x['Media']['id'],
                //'url'=>sprintf('%simage%supload%s.%s',WWW_ROOT,DS,$x['Media']['id'],$x['Media']['type']),
                'url'=>$this->imageUrl.$x['Media']['id'].'.'.$x['Media']['type']
            );
        }
        
        return $media;
    }
    
    public function getProject(){
        $projects=array();
        
        //$simpledb
        $this->ProjectList->recursive=0;
        foreach($this->Simpledb->find('all') as $simpledb){
            $conditions=array('conditions'=>array('ProjectList.simpledb_id'=>$simpledb['Simpledb']['id'],
                                                  'ProjectList.status'=>'1'));
            
            $rows=array();
            foreach($this->ProjectList->find('all',$conditions) as $row){
                $rows[$row['ProjectList']['title']]=$row['ProjectList'];
            }
            
            $projects[$simpledb['Simpledb']['title']]=$rows;
        }
        
        return $projects;
    }
    
    private $PagesDetail;
    private $Media;
    private $imageUrl;
    private $Atribut;
    private $Simpledb;
    private $ProjectList;
}

?>