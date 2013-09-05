<?php

/**
 * Définition du modèle Team, qui représente une équipe avec des matchs et des 
 * résultats liés
 *
 * @author Alain Fresco
 * @package Modele
 * @since 14.08.2013
 */
class Team extends AppModel {

    var $hasMany = array('Post');
    var $validate = array(
        'photo' => array(
            'rule' => '/^.*\.(jpg|png|jpeg|JPG|PNG|JPEG)$/',
            'allowEmpty' => true,
            'message' => 'Le fichier n\'est pas une image valide'),
        'name' => array(
            'rule' => "notEmpty")
        );

}

?>
