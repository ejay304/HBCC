<h3>Liste des Salles</h3>
<table>
    <?php foreach ($gyms as $k => $v): $v = current($v); ?>
        <tr>
            <td>
                <?php echo $v['name']; ?><br />

                <?php echo $this->Html->link('Créer un itinéraire', 'http://maps.google.com/maps?f=d&hl=fr&geocode=&saddr=&daddr='.  $v["lat"] . ','.  $v["long"]   .'&mra=mi&mrsp=0&sz=17&sll='.  $v["lat"] . ','.  $v["long"]   .'&sspn=0.005219,0.013647&ie=UTF8&ll='.  $v["lat"] . ','.  $v["long"]   .'&spn=0.005219,0.013647&t=h&source=embed'); ?>
            </td>
            <td>
                <div id="<?php echo $v['id']; ?>" style="width: 500px; height: 300px"></div>
                <?php $this->Html->scriptStart(array('inline' => false)); ?>
                function initialize() {
                    var mapOptions = {
                    scaleControl: true,
                    center: new google.maps.LatLng(<?php echo $v['lat'] ?>,<?php echo $v['long'] ?>),
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    var map = new google.maps.Map(document.getElementById('<?php echo $v['id']; ?>'),
                        mapOptions);
                        
                    var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(<?php echo $v['lat'] ?>,<?php echo $v['long'] ?>),
                    map: map,
                    title: 'Hello World!'
                     });

                }
                google.maps.event.addDomListener(window, 'load', initialize);
                <?php $this->Html->scriptEnd(array('inline' => false)); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBDAt2wbY7X0tfdhMxd0lzbBm47TLXQFGU&sensor=true" type="text/javascript"></script>