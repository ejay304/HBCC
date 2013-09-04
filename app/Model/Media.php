<?php

/**
 * Définition du modèle Post, qui représente les publications relative au club
 * dans le style d'un blog
 *
 * @author Alain Fresco
 * @package Modele
 * @since 03.09.2013
 */
class Media extends AppModel {

    var $useTable = 'medias';
    var $validate = array(
        'url' => array(
            'rule' => '/^.*\.(jpg|png|jpeg|JPG|PNG|JPEG)$/',
            'allowEmpty' => true,
            'message' => 'Le fichier n\'est pas une image valide'
    ));

}

?>
