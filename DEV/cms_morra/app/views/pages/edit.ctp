<?php
	//var_dump($this->data);

	//var_dump($atribut_drop_box);
	echo $this->Html->script('tiny_mce/tiny_mce.js',false);
	//echo $this->Html->script('pages_tiny_mce.js',false);
	echo $this->Html->script(array('pages','pageatribut'),false);
	$input=array('size'=>43,
				 'div'=>false,
				 'label'=>false);
?>
<div class="cms_PageButton">
	<input type="submit" value="Save" onclick="editPage()">
	<input type="button" value="Cancel" class="isOff" onclick="javascript: window.location=site+'pages/index/'">
</div>

<h2>Edit <?php echo $this->data['Page']['title']; ?></h2>

<div class="splitLeft">
        <!-- EDIT PAGE -->
        
		<?php 
			//echo $this->Form->create('Page', array('action'=>'edit','class'=>'notif-change'));
			echo $form->create('Page', array('action'=>'edit','class'=>'notif-change','inputDefaults' => array('label' =>false , 'div' => false)));
		?>
		
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
                                <th class="isTop"><label>Page Description</label></th>
                                <td>
                                        <?php
                                                $textarea=$input;
                                                unset($textarea['size']);
                                                $textarea['cols']='48';
                                                $textarea['rows']='4';
                                                echo $this->Form->textarea('description',$textarea);
                                        ?>
                                </td>
                        </tr>
                        <tr>
                                <th><label>Template</label></th>
                                <td>
                                    <?php echo $this->Form->select('template',$template,$page['Page']['template'],array('empty'=>false)); ?>
                                </td>
                        </tr>
                        <tr>
                                <th class="isTop"><label>Child of</label></th>
                                <td>
                                    <?php echo $this->Form->select('parent_id',$parent_drop_box); ?>
                                </td>
                        </tr>
                </tbody>
        </table>
        
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
								</div>
							</td>
                        </tr>
						
						<?php
							//echo $this->Form->end();
							echo $form->end();
						?>
                        
						<!-------------------------------------->
						
						<tr class="isHeader">
                            <th colspan="2">Attributes</th>
                        </tr>
						
						<?php
							$atribs=array();
							foreach ($tests as $atribut):
								$atribs[$atribut['Atribut']['id']]=$atribut['Atribut']['name'];
							endforeach;
						?>
						
						<tr class="page-info isHidden">
							<th>
								<label></label>
							</th>
							<td>
							</td>
						</tr>
						
						<?php foreach($pageAttributes as $pageAttribute): ?>
							<tr class="page-info">
								<th>
									<label><?php echo $atribs[$pageAttribute['PageDetail']['atribut_id']]; ?></label>
								</th>
								<td>
									<input name="<?php echo 'data[Page][coba'.$pageAttribute['PageDetail']['id'].']'; ?>" value="<?php echo $pageAttribute['PageDetail']['value']; ?>" size="43" type="text">
								</td>
							</tr>
						<?php endforeach; ?>
						
						<!-------------------------------------->
						
						<tr id="tr_add_atrib">
							<td></td>
							<!-- <td colspan="1"><a id="add_new_atrib" href="#">Add New Attribute</a></td> -->
							<td colspan="1"><input id="add_new_atrib" type="button" value="Add New Attribute"></td>
						</tr>
						
						<tr class="form_atribut" id="add-new-atribut-form">
							<th><label>New Attribute Label</label></th>
							<td>
								<?php echo $form->create('Page',array('action'=>'add')); ?>
									<?php echo $form->input('pageId',array('type'=>'hidden','value'=>$id)); ?>
									<?php echo $form->input('atribValue',array('type'=>'hidden','value'=>'')); ?>
									<input type="text" size="30" class="space10" name="data[Atribut][name]" id="content"/>
									<?php echo $this->Js->submit('Submit',array('id'=>'bSubmit','confirm'=>'Are you sure?','div'=>false)); ?>
									<input id = "add-new-atrib-form-cancel" type="Button" value="Cancel" class="isOff">
								<?php echo $form->end(); ?>
							</td>
						</tr>
						
						
						<!-------------------------------------->
						
                </tbody>
        </table>
        <?php //echo $this->Form->end(); ?>
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
								<h5><?php echo $user['User']['username']; ?></h5>
								<p><?php echo $this->data['Page']['created']; ?></p>
						</td>
					</tr>
					<tr>
						<th><label>Edited:</label></th>
						<td>
								<h5><?php echo $user['User']['username']; ?></h5>
								<p><?php echo $this->data['Page']['modified']; ?></p>
						</td>
					</tr>
				</tbody>
			</table>
        </div>
        
</div>
<div class="clearFix"></div>