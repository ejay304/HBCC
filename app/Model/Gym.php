<?php
/**
 * Définition du modèle Gym, qui représente une sale de gym avec un nom, lat & long 
 * 
 *
 * @author Alain Fresco
 * @package Modele
 * @since 06.09.2013
 */
class Gym extends AppModel {

    var $hasMany = 'Training';

}

?>