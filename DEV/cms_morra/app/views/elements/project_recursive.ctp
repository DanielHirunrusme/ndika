<?php
//var_dump($ProjectList);
//var_dump($padding);
//var_dump(isset($ProjectList[1]));
//die();

$i=0;
while(isset($ProjectList[$i])):
    $newsub=array('ProjectList'=>$ProjectList[$i]);
?>
<tr>
    <td class='isSubEntry' style="padding-left: <?php echo $padding; ?>px;">
        <span class='isAction'>
            <? echo $form->Html->link('Delete',array('action'=>'delete',$newsub['ProjectList']['id']),null,
                                      sprintf('If you delete %s. All child of %s will be deleted too. Are you sure want to delete %s ?',
                                              $newsub['ProjectList']['title'],
                                              $newsub['ProjectList']['title'],
                                              $newsub['ProjectList']['title']));?>
        </span>
        <h6>
            <? echo $form->Html->link($newsub['ProjectList']['title'],array('action'=>'edit',$newsub['ProjectList']['id'])); ?>
        </h6>
    </td>
    <td>
            <? echo date('d-m-Y @ H:i',$jakarta+strtotime($newsub['ProjectList']['modified'])); ?>
    </td>
</tr>
<?php
    $output=array();
    $output = array_slice($ProjectList[$i], 9);
    $output = array('ProjectList'=>$output,'padding'=>$padding+36);
    //var_dump($output);
    //die();
    echo $this->element('project_recursive',$output);
    $i++;
endwhile;
?>