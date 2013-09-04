<?php echo $this->Html->script('tiny_mce/tiny_mce_popup.js'); ?> <?php debug($this->request->data); ?>
<script type="text/javascript">
    var win = window.dialogArguments || opener||parent||top;
    win.send_to_editor('<img src="<?php echo $src ?>" alt="<?php echo $alt ?>" class="<?php echo $class ?>" />');
    tinyMCEPopup.close();

</script>