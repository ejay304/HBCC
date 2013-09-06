<h3><?php echo !isset($id) ? "Ajout d'un entrainement" : "Modification d'un entrainement"; ?></h3>
<?php
	echo $this->Form->create('Training');
	echo $this->Form->input('id');
	echo $this->Form->input('team_id');
	echo $this->Form->input('day_id',array('label'=>'Jour','options'=>array('Lundi'=>'Lundi','Mardi'=>'Mardi','Mercredi'=>'Mercredi','Jeudi'=>'Jeudi','Vendredi'=>'Vendredi','Samedi'=>'Samedi','Dimanche'=>'Dimanche')));
	echo $this->Form->input('begin',array('label'=>'Début'));
	echo $this->Form->input('end',array('label'=>'Fin'));
	echo $this->Form->input('gym_id',array('label'=>'Salle'));
	echo $this->Form->end('Ajouter un entrainement');
?>