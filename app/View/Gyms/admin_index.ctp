<h3>Liste des salles</h3>
<table class="table">
    <tr>
        <th>Nom</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th> </th>
    </tr>
    <?php foreach ($gyms as $k => $v): $v = current($v) ?>
        <tr>
            <td>
            <?php echo $v['name'] ?>
        </td>
        <td>
            <?php echo $v['lat']; ?>
        </td>
        <td>
            <?php echo $v['long']; ?>
        </td>
        <td>
            <?php echo $this->Html->link('Supprimer', array('action' => 'delete', null, $v['id']), null, 'Etes vous sur de vouloir supprimer cette salle ? '); ?>
            - <?php echo $this->Html->link('Modifier', array('action' => 'edit', null, $v['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
        </table>
<?php echo $this->Html->link('Ajouter une salle', array('action' => 'edit'),array('class'=>'btn primary')); ?>
<?php echo $this->Paginator->numbers(); ?>