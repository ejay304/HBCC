<h3>Liste des équipes </h3>
<table class="table">
    <tr>
        <th>Nom</th>
        <th>Groupe_id</th>
        <th>ARH</th>
        <th></th>
    </tr>
    <?php foreach ($teams as $vk => $v):$v = current($v) ?>
        <tr>
            <td>
            <?php echo $v['name'] ?>
        </td>
        <td>
            <?php echo $v['group'] ?>
        </td>
        <td>
            <?php echo $v['arhid'] ?>
        </td>
        <td>
            <?php echo $this->Html->link('Supprimer', array('action' => 'delete', null, $v['id']), null, 'Etes vous sur de vouloir supprimer cet utilisateur ? '); ?>
            - <?php echo $this->Html->link('Modifier', array('action' => 'edit', null, $v['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php echo $this->Html->link('Ajouter une équipe', array('action' => 'edit'), array('class' => 'btn primary')); ?>
<?php echo $this->Paginator->numbers(); ?>