<h3><?php echo "Ajout d'un utilisateur" ?></h3>
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('passwd_old', array('label' => 'Ancien mot de passe'));
	echo $this->Form->input('passwd', array('label' => 'Nouveau mot de passe'));
     echo $this->Form->input('passwd_confirm', array('type'=>'password', 'label'=>'Comfirmer le mot de passe'));
	echo $this->Form->end("Envoyer");
?>