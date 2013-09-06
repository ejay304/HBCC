<h3>Entrainements </h3>
<table class="table">
    <tr>
        <th>Equipe</th>
        <th>Jour</th>
        <th>Début</th>
        <th>Fin</th>
        <th>Salle</th>
        <th></th>

    </tr>
    <?php foreach ($trainings as $k => $v):/*$v = current($v) */?>
    <tr>
        <td>
            <?php echo $v['Team']['name'];?>
        </td>
        <td>
            <?php echo $v['Training']['day_id']; ?>
        </td>
        <td>
            <?php echo $v['Training']['begin']; ?>
        </td>
        <td>
            <?php echo $v['Training']['end']; ?>
        </td>
        <td>
            <?php echo $v['Gym']['name']; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Supprimer', array('action' => 'delete', null, $v['Training']['id']), null, 'Etes vous sur de vouloir supprimer ce membre ? '); ?>
            - <?php echo $this->Html->link('Modifier', array('action' => 'edit', null, $v['Training']['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
        </table>
<?php echo $this->Html->link('Ajouter un entrainement', array('action' => 'edit'), array('class' => 'btn primary')); ?>
<?php echo $this->Paginator->numbers(); ?>