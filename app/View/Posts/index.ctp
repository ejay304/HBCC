<?php foreach ($posts as $k => $v): $v = current($v) ?>
        <h2><?php echo $v['title'] ?></h2> <h5><?php echo $v['date'] ?></h5>
        <p> <?php echo $v['text'] ?></p>
<?php endforeach; ?>