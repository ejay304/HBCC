 
<table>
    <tr>
        <th>Jour</th>
        <th>Début</th>
        <th>Fin</th>
        <th>Salle</th>
    </tr>
    <?php foreach ($trainings as $k => $v): ?>
        <tr>
            <td><?php echo $v['Training']['day_id']; ?></td>
            <td><?php echo $v['Training']['begin']; ?></td>
            <td><?php echo $v['Training']['end'] ?></td>
            <td><?php echo $v['Gym']['name'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>
