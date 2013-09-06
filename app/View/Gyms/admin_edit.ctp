<h3>Edition des salles</h3>

	<?php echo $this->Form->create('Gym'); ?>
     <?php echo $this->Form->input('id'); ?>
    <fieldset>
        <div class="clearfix"><?php echo $this->Form->input('name',array('label'=>'Nom')); ?></div>
        <div class="clearfix"><?php echo $this->Form->input('lat',array('label'=>'Latitude')); ?></div>
        <div class="clearfix"><?php echo $this->Form->input('long',array('label'=>'Longitude')); ?></div>
     </fieldset>   
	<?php echo $this->Form->end(array('label' => 'Envoyer',
                                        'class' => 'btn')); ?>