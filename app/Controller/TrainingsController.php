<?php

/**
 * Définition de la classe qui va gérer toutes les interaction avec le modèle
 * Training (Entrainenement) 
 *
 * @author Alain Fresco
 * @package Controller
 * @since 06.09.2013
 */
class TrainingsController extends AppController {

    var $paginate = array(
        'limit' => 10,
        'order' => array(
            'Training.name' => 'asc'
        )
    );

    /**
     * Permet d'afficher tout les entrainements d'une équipe données
     * 
     * @since 06.09.08.2013
     * @param int $idTeam l'identifiant de l'équipe
     */
    function show($idTeam) {
        $this->layout = false;
        $this->set("trainings", $this->Training->find('all', array('conditions' => array('team_id' => $idTeam))));
    }

    /**
     * Permet d'afficher tout les entrainements
     * 
     * @since 06.09.2013
     */
    function admin_index() {
        $d['trainings'] = $this->Paginate('Training');
        $this->set($d);
    }

    /**
     * Permet de supprimer un entrainement donnée
     * 
     * @param int $id L'identifiant de l'entrainement donné
     * @since 06.09.2013
     */
    function admin_delete($id) {
        $del = $this->Training->delete($id);
        if ($del) {
            $this->Session->setFlash('L\'entrainement a bien été supprimée');
        } else {
            $this->Session->setFlash('Une erreur est survenu veulliez contacter l\'adiministrateur');
        }
        $this->redirect($this->referer());
    }

    /**
     * Permet d'ajouter ou de modifier un entrainement
     * 
     * Si un id est passé en paramètre il s'agit d'une modification, sinon
     * il s'agit d'un ajout
     * 
     * @param int $id L'identifiant de l'entrainement donné
     * @since 06.09.2013
     */
    function admin_edit($id = null) {
        $d['gyms'] = ClassRegistry::init('Gym')->find('list');
        $d['teams'] = ClassRegistry::init('Team')->find('list');

        if ($this->request->is('put') || $this->request->is('post')) {
            if ($this->Training->save($this->request->data)) {
                $id ? $this->Session->setFlash("Votre entrainement a été mise à jour", 'notif', array('type' => "success")) : $this->Session->setFlash("Votre entrainement a été ajoutée", 'notif', array('type' => "success"));
                $this->redirect(array('action' => 'index'));
            }
        } else {
            if ($id) {
                $this->Training->id = $id;
                $this->request->data = $this->Training->read();
            }
            $this->set($d);
        }
    }

}