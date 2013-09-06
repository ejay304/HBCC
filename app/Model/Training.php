<?php
/**
 * Définition du modèle Training, qui représente un entrainement avec une équipe
 * dans une salle
 *
 * @author Alain Fresco
 * @package Modele
 * @since 06.09.2013
 */
class Training extends AppModel {

    var $belongsTo = array('Team', 'Gym');

}

?>