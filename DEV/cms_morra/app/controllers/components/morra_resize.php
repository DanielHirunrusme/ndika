<?php
App::import('Component', 'JqImgcrop');
class MorraResizeComponent extends JqImgcropComponent {
    public function resize($src, $dest){
        $w=parent::getWidth($src);
        $h=parent::getHeight($src);
        
        $x1=0;
        $y1=0;
        $x2=$w;
        $y2=$h;
        $crop_widht=$x2-$x1;
        $crop_height=$y2-$y1;
        //var_dump($x2,$y2);
        
        if($w>$h){
            $margin=($w-$h)/2;
            $x1=$margin;
            $x2=$x1+$h;
            $crop_widht=$x2-$x1;
        }elseif($w<$h){
            $margin=($w-$h)/2;
            $y1=$margin;
            $y2=$y1+$w;            
            $crop_height=$y2-$y1;
        }
        
        parent::cropImage(200,$x1,$y1,$x2,$y2,$crop_widht,$crop_height,$dest,$src);
    }
}
?>