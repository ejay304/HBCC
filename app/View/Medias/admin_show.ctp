<h3>Insérer l'image</h3>

<img src="<?php echo $src; ?>" alt="<?php echo $alt; ?>" style="max-width: 200px;">

<?php echo $this->Form->create('Media'); ?>
    <?php echo $this->Form->input('alt', array('label' => 'Description de l\'image', 'value' => $alt)); ?>
    <?php echo $this->Form->input('src', array('label' => 'Chemin de l\'image', 'value' => $src)); ?>
    <?php
    echo $this->Form->input('class', array('legend' => 'Allignement', 'options' =>  array(
            "alignLeft"   => "Aligner à gauche",
            "alignCenter" => "Aligner au centre",
            "alignRight"  => "Aligner à droite"
        ), 'type' => 'radio')
    ); ?>
<?php echo $this->Form->end('Insérer l\'image'); ?>