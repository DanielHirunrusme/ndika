<tr class="page-info">
    <td>
        <span class="isAction"><a href="#status-page-<?php echo $page['Page']['id']; ?>">Disable</a> | <?php echo $html->link('Delete', array('action'=>'delete',$page['Page']['id']), null,'Are you sure want to delete this page?'); ?></span>
        <h5><?php echo $this->Html->link($page['Page']['title'],array('action'=>'edit',$page['Page']['id'])); ?></h5>
        <p><strong><?php echo ucfirst($page['Page']['title']); ?></strong> - <?php echo $page['Page']['description']; ?></p>
    </td>
    <td><?php echo $page['Page']['modified']; ?></td>
    <td>
        <span class="cms_Status <?php echo $page['Page']['status']!=0?'isGood':'isBad'; ?>">
            <?php echo $page['Page']['status']!=0?'Active':'Disabled'; ?>
        </span>
    </td>
</tr>