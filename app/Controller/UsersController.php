<?php

//Indique quel librairie on va utiliser
App::uses('Xml', 'Utility');

/**
 * Définition de la classe qui va gérer toutes les interaction avec le modèle
 * User. Ce Modèle représente les utilisateur qui peuvent se connecter à 
 * l'înterface administrateur 
 *
 * @author Alain Fresco
 * @package Controller
 * @since 20.08.2013
 */
class UsersController extends AppController {

    /**
     * Permet d'ajouter un utlisateur qui peut se connecter à la partie 
     * d'administration
     * 
     * On va récupérer les données envoyée par le formulaire et on va les 
     * ajouter à la base de données
     * 
     * @since 20.08.2013
     */
    function admin_add() {
        if ($this->request->is('put') || $this->request->is('post')) {
            $d = $this->request->data['User'];
            if ($d['password'] != $d['re_password'])
                $this->Session->setFlash("Les mots de passes ne correspondent pas.");
            else {
                if ($this->User->save($this->request->data)) {
                    $this->Session->setFlash("Votre utilisateur a été ajoutée");
                }
            }
        }
    }
     /**
     * Permet de modifier le mot de passe d'un utilisateur
     * 
     * @since 20.08.2013
     * @param int $id L'id de l'utilisateur a qui on doit changer le mot de passe
     */
    function admin_edit($id) {
        // Si il s'agit d'une resquete en post ou put
        if ($this->request->is('put') || $this->request->is('post')) {
            $this->User->id = $id;
            $data = $this->User->read();
            $data['User']['passwd_old'] = $this->data['User']['passwd_old'];
            $data['User']['passwd'] = $this->data['User']['passwd'];
            $data['User']['passwd_confirm'] = $this->data['User']['passwd_confirm'];
            debug($data);
            if ($data['User']['password'] == Security::hash($this->data['User']['passwd_old'], null, true)) {
                if ($this->User->saveField('password', Security::hash($data['User']['passwd'], null, true))) {
                    if ($data['User']['passwd_confirm'] == $data['User']['passwd']) {
                        $this->Session->setFlash("Votre mot de passe a été mis à jour");
                    } else {
                        $this->Session->setFlash("Vos deux mots de passe ne sont pas les mêmes");
                    }
                }
            }
            else
                $this->Session->setFlash("Votre ancien mot de passe est incorrect");
        }
    }


    /**
     * Permet au utilisateur de s'authentifier
     * 
     * Va tester si l'utilisateur existe dans la base de données et si le 
     * mot de passe correspond, si c'est le cas l'utilisateur aura accès à 
     * l'interface d'administration, sinon un message d'erreur est afficher
     * 
     * @since 20.08.2013
     */
    function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login())
                return $this->redirect($this->Auth->redirect());
            else
                $this->Session->setFlash('Votre login ou votre mot de pass ne correspond pas');
        }
    }

    /**
     * Permet à l'utilisateur de se deconnecter
     * 
     * Va fermer la session de l'utilisateur sur le serveur et le déconnecter
     *  de l'interface d'administration 
     * @since 23.08.2013
     */
    function logout() {
        $this->Auth->logout();
        $this->Session->setFlash('Vous êtes maintenant déconnecté');
        $this->redirect('/');
    }

}

?>
