<?php echo $this->Form->create('User'); ?>
<fieldset>
   <?php echo $this->Form->input('username', array('label' => 'Nom d\'utilisateur')); ?>
   <?php echo $this->Form->input('password', array('label' => 'Mot de passe')); ?>
</fieldset>
<?php echo $this->Form->end(array('label' => 'Se connecter')); ?>