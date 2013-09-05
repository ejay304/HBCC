<h3><?php echo!isset($id) ? "Ajout d'une équipe" : "Modification d'une équipe"; ?></h3>

<?php echo $this->Form->create('Team', array('type' => 'file')); ?>
<?php echo $this->Form->input('id'); ?>

<?php echo $this->Form->input('name'); ?>
<?php echo $this->Form->input('group'); ?>
<?php echo $this->Form->input('arhid'); ?>
<?php echo $this->Form->input('photo',array('type' => 'file')); ?>
<?php echo $this->Form->end(array('label' => 'Ajouter une équipe'));
?>