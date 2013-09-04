<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Définition du modèle User, qui représente les utilisateurs qui peuvents se 
 * connecter à l'interface d'administration
 *
 * @author Alain Fresco
 * @package Modele
 * @since 26.08.2013
 */
class User extends AppModel {

    /**
     * Action qui est appeler avant l'enregistrement de tout les objets de type 
     * User
     * 
     * Cette fonction va hasher le mot de passe avant de l'enregistrer dans la base de données
     * @since 26.08.2013
     */
    function beforeSave() {
        App::uses('Utitlity', 'Security');
        if (!empty($this->data['User']['password'])) {
            $this->data['User']['password'] = Security::hash($this->data['User']['password'],'' ,true);
        }
        return true;
    }

}

?>
