<h3><?php echo "Ajout d'un utilisateur" ?></h3>
<?php
	echo $this->Form->create('User');
	echo $this->Form->input('username', array('label' => 'Nom d\'utilisateur'));
	echo $this->Form->input('password', array('label' => 'Mot de passe'));
     echo $this->Form->input('re_password', array('type'=>'password', 'label'=>'Comfirmer le mot de passe'));
	echo $this->Form->end("Envoyer");
?>