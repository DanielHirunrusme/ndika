<tr class="atribut">
    <th>
        <label>
            <input type="hidden" value="<?php echo $projectId; ?>" name="data[ProjectListDetail][<?php echo $arrayIndex; ?>][Project_list_id]">
            <input type="hidden" value="<?php echo $projectAtribut['id']; ?>" name="data[ProjectListDetail][<?php echo $arrayIndex; ?>][Project_list_atribut_id]">
            <?php echo $projectAtribut['name']; ?>
        </label>
    </th>
    <td>
        <input type="text" value="" name="data[ProjectListDetail][<?php echo $arrayIndex; ?>][value]" size="50">
    </td>
</tr>