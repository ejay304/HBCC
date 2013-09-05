<h3>Liste des Posts</h3>

    <?php echo $this->Html->link('Ajouter une news', array('action' => 'edit'),array('class'=>'btn  btn-primary')); ?>
<table>
    <tr>
        <th>Date</th>
        <th>Titre</th>
        <th>Texte</th>  
        <th>En Ligne</th>
        <th> </th>
    </tr>
    <?php foreach ($posts as $k => $v): $v = current($v);?>
    <tr>
        <td>
            <?php echo $v['date'];?>
        </td>
        <td>
            <?php echo $v['title']; ?>
        </td>
        <td>
            <?php echo $v['text'] ?>
        </td>
        <td>
            <?php echo $v['online'] == false ? '<span class="error-message">Hors Ligne</span>':'<span class="success">En Ligne</span>'; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Supprimer', array('action' => 'delete', null, $v['id']), null, 'Etes vous sur de vouloir supprimer cette news ? '); ?>
            - <?php echo $this->Html->link('Modifier', array('action' => 'edit', null, $v['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<p style="text-align: right">
    <?php echo $this->Html->link('Ajouter une news', array('action' => 'edit'),array('class'=>'btn  btn-primary')); ?>
</p>
<?php echo $this->Paginator->numbers(); ?>