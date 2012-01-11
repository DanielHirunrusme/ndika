<?php
//var_dump($this->data);

//var_dump($atribut_drop_box);
//echo $this->Html->script('tiny_mce/tiny_mce.js');
//echo $this->Html->script('pages_tiny_mce.js');

$input=array('size'=>43,
             'div'=>false,
             'label'=>false);
?>
<div style="text-align:right">
        <input class="edit-page-back-button" type="button" value="Back" />
</div>
<h2>Edit <?php echo $this->data['Page']['title']; ?></h2>
<p class="isMeta"></p>
<div class="splitLeft">
        <!-- EDIT PAGE -->
        <?php echo $this->Form->create('Page', array('action'=>'edit')); ?>
        <table>
                <colgroup>
                        <col class="isLabel"/>
                        <col/>
                </colgroup>
                <tbody>
                        <tr class="isHeader">
                                <th colspan="2">Page Title & Template</th>
                        </tr>
                        <tr>
                                <th><label>Page Title</label></th>
                                <td>
                                        <?php
                                                echo $this->Form->input('id',array('type'=>'hidden'));
                                                echo $this->Form->input('title',$input,null,array('size'=>43));
                                        ?>
                                </td>
                        </tr>
                        <tr>
                                <th><label>Page Description</label></th>
                                <td><?php echo $this->Form->input('description',$input,null,array('size'=>43)); ?></td>
                        </tr>
                        <tr>
                                <th><label>Template</label></th>
                                <td>
                                    <?php echo $this->Form->select('template',$template,$page['Page']['template']); ?>
                                </td>
                        </tr>
                        <tr>
                                <th class="isTop"><label>Child of</label></th>
                                <td>
                                    <?php echo $this->Form->select('parent_id',$parent_drop_box); ?>
                                </td>
                        </tr>
                        <tr>
                                <td colspan="2" style="text-align:right" >
                                    <?php
                                        $input['class']='space10';    
                                        $input['size']='23';
                                        echo $this->Form->submit('Change', $input);
                                    ?>
                                </td>
                        </tr>
                </tbody>
        </table>
        <?php echo $this->Form->end(); ?>
        
        <!-- EDIT Page Content -->
        <table>
                <colgroup>
                        <col class="isLabel"/>
                        <col/>
                </colgroup>
                <tbody>
                        <tr class="isHeader">
                                <th colspan="2">Page Content</th>
                        </tr>
                        <tr>
                                <td colspan="2">
                                        <div>
                                                <?php
                                                //echo $this->Form->create('Page',array('action'=>'edit','id'=>'content-mce'));
                                                echo $this->Form->input('Page.id');
                                                echo $this->Form->textarea('Page.content',
                                                        array('id'=>'page_content','escape'=>'Click Here','style'=>'width:100%; height:300px;')
                                                );
                                                //echo $this->Form->submit('Save',array('id'=>'save-submit'));
                                                //echo $this->Form->end();
                                                ?>
                                                TinyMCE Editor goes Here
                                        </div>
                                </td>
                        </tr>
                        <tr class="isHeader">
                                <th colspan="2">Attributes</th>
                        </tr>
                        <?php foreach($atributs as $atribut): ?>
                                <tr class="attribut-detail" >
                                        <th>
                                                <label><?php echo $atribut['Atribut']['name']; ?></label>
                                        </th>
                                        <td>
                                                <?php
                                                        echo $this->Form->create('PagesDetail',array('controller'=>'PagesDetail', 'action'=>'edit'));
                                                        $input['size']=50;
                                                        $input['value']=$atribut['PagesDetail']['value'];
                                                        $pagesDetailValue=$input;
                                                        $pagesDetailValue['class']='Pages-Detail-textbox';

                                                        echo $this->Form->input(
                                                                'PagesDetail.value',
                                                                $pagesDetailValue,null,array('size'=>50)
                                                        );

                                                        echo $this->Form->input(
                                                                'PagesDetail.id',
                                                                array('type'=>'hidden','value'=>$atribut['PagesDetail']['id'])
                                                        );

                                                        echo $this->Form->input(
                                                                'PagesDetail.page_id',
                                                                array('type'=>'hidden','value'=>$atribut['PagesDetail']['page_id'])
                                                        );
                                                        
                                                        echo $this->Form->input(
                                                                'PagesDetail.atribut_id',
                                                                array('type'=>'hidden','value'=>$atribut['PagesDetail']['atribut_id'])
                                                        );

                                                        echo $this->Form->end();
                                                ?>
                                        </td>
                                </tr>
                        <?php //echo $this->Form->end(); ?>                                
                        <?php endforeach; ?>
                        <?php if(count($atribut_drop_box)>0): ?>
                        <tr>
                                <th><label>Add Attribute To This Page</label></th>
                                <td>
                                        <?php echo $this->Form->create('PagesDetail',array('controller'=>'PagesDetails','action'=>'add')); ?>
                                        <input type="hidden" name="data[PagesDetail][page_id]" value="<?php echo $page['Page']['id']; ?>" />
                                        <?php echo $this->Form->select('atribut_id',$atribut_drop_box); ?>
                                        <input type="text" size="30" class="space10" name="data[PagesDetail][value]" />
                                        <?php echo $this->Form->submit("Add To Page",$input); ?>
                                        <?php echo $this->Form->end(); ?>
                                </td>
                        </tr>
                        <?php endif; ?>
                        <tr id="add-new-attribut">
                                <td></td>
                                <td colspan="1"><a id="link_atrib" href="#add-new-attribut">Add New Attribut</a></td>
                        </tr>
                        <tr id="add-new-attribut-form" style="display:none">
                                <th><label>New Attribute Label</label></th>
                                <td>
                                        <?php
                                        echo $this->Form->create('Atribut',array('controller'=>'Atribut','action'=>'add'));
                                        ?>
                                        <input type="text" size="30" class="space10" name="data[Atribut][name]" />
                                        <input type="Submit" value="Add" class="space3">
                                        <input id="add-new-attribut-cancel" type="Button" value="Cancel" class="isOff">
                                        <?php echo $this->Form->end(); ?>
                                </td>
                        </tr>
                </tbody>
        </table>
</div>

<div class="splitRight">
        <!--STATUS & SAVE BUTTON-->
        <div class="cms_Module">
                <h5 class="cms_SidebarTitle">Page Status</h5>
                <table>
                        <colgroup>
                                <col class="isMetaLabel"/>
                                <col/>
                        </colgroup>
                        <tbody>
                                <tr>
                                        <th><label>Created:</label></th>
                                        <td>
                                                <h5>Username</h5>
                                                <p><?php echo $this->data['Page']['created']; ?></p>
                                        </td>
                                </tr>
                                <tr>
                                        <th><label>Edited:</label></th>
                                        <td>
                                                <h5>Username</h5>
                                                <p><?php echo $this->data['Page']['modified']; ?></p>
                                        </td>
                                </tr>
                        </tbody>
                </table>
        </div>
        
</div>
<div class="clearFix"></div>
<div style="text-align:right">
        <input class="edit-page-back-button" type="button" value="Back" />
</div>
