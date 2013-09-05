
<h1><?php echo!isset($id) ? "Ajout d'une News" : "Modification d'une News"; ?></h1>

<?php echo $this->Form->create('Post'); ?>
<?php echo $this->Form->input('id'); ?>
<?php
echo $this->Form->input('date', array('label' => 'Date', 'dateFormat' => 'DMY'));
?>
<?php echo $this->Form->input('team_id', array('label' => 'Type')); ?>
<?php echo $this->Form->input('title', array('label' => 'Titre de la news')); ?>
<?php echo $this->Form->input('text', array('label' => 'Contenu')); ?>
<?php echo $this->Form->input('online'); ?>
<?php echo $this->Form->end("Envoyer"); ?>

<?php $this->Html->script('tiny_mce/tiny_mce.js', array('inline' => false)); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>

tinyMCE.init({
mode : 'textareas',
theme : 'advanced',
plugins : 'inlinepopups,paste,image',
width : "740",
height : "400",

theme_advanced_buttons1 : 'bold,italic,underline,|,bullist,numlist,|,justifyleft,justifycenter,justifyright,justifyfull,|,link,unlink,|,image,formatselect,code',
theme_advanced_buttons2 : '',
theme_advanced_buttons3 : '',
theme_advanced_buttons4 : '',

relative_urls : false,
theme_advanced_toolbar_location : 'top',
theme_advanced_resizing : true,
paste_remove_styles : true,
paste_remove_spans : true,
paste_stripe_class_Attributes : 'all',
image_explorer : '<?php echo $this->Html->url(array('controller' => 'medias', 'action' => 'index')); ?>'
});

function send_to_editor(content){
var ed = tinyMCE.activeEditor;
ed.execCommand('mceInsertContent',false,content);
}
<?php $this->Html->scriptEnd(array('inline' => false)); ?>