
<?php
class GymsController extends AppController {

    var $paginate = array(
        'limit' => 10,
        'order' => array(
            'Gym.name' => 'desc'
        ),
        'fields' => array('DISTINCT name','id','lat','long')
    );
    
    function admin_index() {
        $d['gyms'] = $this->Paginate('Gym');
        $this->set($d);
    }

    function admin_delete($id) {
        $del = $this->Gym->delete($id);
        if ($del) {
            $this->Session->setFlash('La salle a bien été supprimée');
        } else {
            $this->Session->setFlash('Une erreur est survenu veulliez contacter l\'adiministrateur');
        }
        $this->redirect($this->referer());
    }

    function admin_edit($id = null) {
        if ($this->request->is('put') || $this->request->is('post')) {
            if ($this->Gym->save($this->request->data)) {
                $id ? $this->Session->setFlash("Votre salle a été mise à jour") : $this->Session->setFlash("Votre salle a été ajoutée");
                $this->redirect(array('action' => 'index'));
            }
        } elseif ($id) {
            $this->Gym->id = $id;
            $this->request->data = $this->Gym->read();
        }
    }

    function index() {
        $d['gyms'] = $this->Paginate("Gym");
        $this->set($d);
    }

}