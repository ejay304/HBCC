<?php
/**
 * Définition du modèle Post, qui représente les publications relative au club
 * dans le style d'un blog
 *
 * @author Alain Fresco
 * @package Modele
 * @since 28.08.2013
 */
class Post extends AppModel {
    
    var $belongsTo = 'Team';
    
}

?>
