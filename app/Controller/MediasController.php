<?php

/**
 * Cette classe permet de gérer les images qui serons insérée dans les post
 *
 * @author Alain Fresco
 * @package Controller
 * @since 03.09.2013
 */
class MediasController extends AppController {

    /**
     * Permet d'ajouter une image a la bibliothèque d'image
     * 
     * On va ajouter une image a la liste des images possible a insérer une 
     * news
     * 
     * @since 20.08.2013
     */
    function admin_index() {
        // si c'est une requète POST
        if ($this->request->is('post')) {

            // On récupère les données transmise
            $data = $this->request->data;

            // On crée les répertoire pour acceuilir les images
            $dir = IMAGES . date('Y');
            if (!file_exists($dir))
                mkdir($dir, 0777);

            $dir .= DS . date('m');
            if (!file_exists($dir))
                mkdir($dir, 0777);

            $f = explode('.', $data['Media']['file']['name']);

            $ext = '.' . strtolower(end($f));
            $filename = Inflector::slug(implode('.', array_slice($f, 0, -1)), '-');

            //Save in db
            $sucess = $this->Media->save(array(
                'name' => $data['Media']['name'],
                'url' => date('Y') . '/' . date('m') . '/' . $filename . $ext,
            ));

            if ($sucess) {
                move_uploaded_file($data['Media']['file']['tmp_name'], $dir . DS . $filename . $ext);
            } else {
                $this->Session->setFlash("L'image n'est pas au bon format");
            }
        }
        $d['medias'] = $this->Media->find('all');
        $this->set($d);
    }

    /**
     * Permet de voir la liste des images disponible
     * 
     * @since 20.08.2013
     */
    function admin_show($id = 1) {
        if ($this->request->is('post')) {
            $this->set($this->request->data['Media']);
            $this->layout = false;
            $this->render('tinymce');
            return;
        }
        if ($id) {
            $this->Media->id = $id;
            $media = current($this->Media->read());
            $d['src'] = Router::url('/img/' . $media['url']);
            $d['alt'] = $media['name'];
        }
        $this->set($d);
    }

    /**
     * Permet de supprimer une image
     * 
     * @param int $id L'identifiant de l'image a supprimer
     * @since 20.08.2013
     */
    function admin_delete($id) {
        $this->Media->id = $id;
        $file = $this->Media->field('url');
        unlink(IMAGES . DS . $file);
        $this->Media->delete($id);
        $this->Session->setFlash('L\'image a bien été supprimée');
        $this->redirect($this->referer());
    }

}

?>
