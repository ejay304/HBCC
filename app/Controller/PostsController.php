<?php

/**
 * Définition de la classe qui va gérer toutes les interaction avec le modèle
 * Posts. Ce Modèle représente les articles qui seront publié sur le site
 *
 * @author Alain Fresco
 * @package Controller
 * @since 28.08.2013
 */
class PostsController extends AppController {

    /**
     * Permet d'afficher toutes les news 
     * 
     * On affiche uniquement les news publiée
     * 
     * @since 05.09.2013
     */
    function index() {
        $this->set('title_for_layout', 'News - HBCC');

        $d['posts'] = $this->Paginate('Post', array('online' => '1'));
        $this->set($d);
    }

    /**
     * Permet d'administrer la liste des news
     * 
     * Cette action permet de modifier, de supprimer et de mettre en ligne 
     * n'importe quelle news enregistré dans la base de données
     *
     * @param int $id Si il exisite il s'agit de l'id du post a modifier
     * @since 05.09.2013
     */
    function admin_index() {
        $this->set('title_for_layout', 'Admin - News - HBCC');
        
        $d['posts'] = $this->Paginate('Post');
        $this->set($d);
    }

    /**
     * Permet d'ajouter ou modifier des news
     * 
     * On fournis un editeur de texte aussi complet que possible a l'aide
     * de la librairie tinymce
     * @param int $id Si il exisite il s'agit de l'id du post a modifier
     * @since 05.09.2013
     */
    function admin_edit($id = null) {
         $this->set('title_for_layout', 'Admin - Edition News - HBCC');
       
        
        if ($this->request->is('put') || $this->request->is('post')) {
            if ($this->Post->save($this->request->data)) {
                $id ? $this->Session->setFlash("Votre news a été mise à jour") : $this->Session->setFlash("Votre news a été ajoutée");
                $this->redirect(array('action' => 'index'));
            }
        } else {
            if ($id) {
                $this->Post->id = $id;
                $this->request->data = $this->Post->read();
            }
            $this->set('teams', $this->Post->Team->find('list'));
        }
    }

}
