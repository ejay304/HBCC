<?php

//Indique quel librairie on va utiliser
App::uses('Xml', 'Utility');

/**
 * Définition de la classe qui va gérer toutes les interaction avec le modèle
 * Team (Equipe) 
 *
 * @author Alain Fresco
 * @package Controller
 * @since 14.08.2013
 */
class TeamsController extends AppController {

    /**
     * Affiche les informations d'une équipe en particulier
     * 
     * @since 15.08.2013
     * @param int $id l'identifiant de l'équipe
     */
    function show($id) {
        $d['team'] = $this->Team->find('first', array('conditions' => array('id' => $id)));
        $d['id'] = $id;
        $this->set($d);
    }

    /**
     * Affiche la liste de matchs d'une équipe en particulier
     * 
     * @since 15.08.2013
     * @param int $id l'identifiant de l'équipe
     */
    function getXmlData($id, $file, $node) {
        $this->layout = false;

        $file = 'files/matchs.xml';

        $xml = Xml::build($file);
        $xpath = "//" . $node . "[@teamId='" . $id . "']";
        // Envoie à la vue la liste des matchs sous forme XML
        $d['xml'] = $xml->xpath($xpath);
        $this->set($d);
    }

    /**
     * Stock les matchs pour toutes les équipe dans un XML
     * 
     * Va aller lire les données concernant toutes les équipes sur le site de 
     * la FSH puis va en extraire le contenu et finalement va les stocker dans un
     * ficher xml
     * 
     * @since 14.08.2013
     */
    function getMatchs() {
        App::uses('HttpSocket', 'Network/Http');

        // Définit que l'on n'utilise pas de layout pour l'affichage
        $this->render("get_datas", false);

        // Déclaration des variables
        $teams = $this->Team->find('list', array(
            'fields' => array('Team.id')));
        $allMatchs = array('matchs' => array('match' => array()));
        $url = 'http://vvs.handball.ch/vvs/spielplan.asp';
        $debut = "/Halle";
        $fin = "/";
        $exp = $debut . ".*" . $fin . "s";
        $exp2 = "/[\d]{2}.[\d]{2}.[\d]{4}\s+[\d]{2}[:][\d]{2}\s+[\w\s&\/\-',\]+[^\d© ]{2}/";
        $expDate = "/<td><span class=\"normal\">[\d]{2}.[\d]{2}.[\d]{4}<\/span><\/td>/";
        $expTime = "/<td><span class=\"normal\">[\d]{2}[:][\d]{2}<\/td>/";
        $expTeams = "/<td><span class=\"normal\">[\w\s&\/\- \*]+<\/span><\/td>/";
        $expSalle = "/class=\"normal\">[\w\s&\/\-',]+<\/a><\/span><\/td>/";
        $HttpSocket = new HttpSocket();
        $html = new HttpSocket();

        // On va traiter toutes les équipes
        foreach ($teams as $k => $id) {

            $team = $this->Team->find('first', array('conditions' => array('id' => $id)));

            // On prépare les paramètre de notre requête
            $params = 'Saison=' . date("Y") . '
                           &Gruppe=' . $team['Team']['group'] . '
                           &Team=' . $team['Team']['arhid'] . '
                           &DatumVon=' . date("d.m.Y") . '
                           &DatumBis=
                           &Submit=Anzeige+gem%E4ss+Auswahl+einschr%E4nken
                           &Herkunft=Spielplan';

            // On execute le requete
            $results = $HttpSocket->get($url, $params);

            preg_match($exp, $results->body, $html);
            $html = current($html);

            //Récupération des date pour tous les match
            preg_match_all($expDate, $html, $matchs['Date']);
            //Récupération des heures pour tous les matchs
            preg_match_all($expTime, $html, $matchs['Time']);
            //Récupération des équipes pour tous les matchs
            preg_match_all(htmlentities($expTeams), htmlentities($html), $matchs['Teams']);
            //récupération des salles pour tous les matchs
            preg_match_all(htmlentities($expSalle), htmlentities($html), $matchs['Salle']);


            $matchs["Date"] = current($matchs['Date']);
            $matchs["Time"] = current($matchs['Time']);
            $matchs["Salle"] = current($matchs['Salle']);
            $matchs["Teams"] = current($matchs['Teams']);

            /* supprésion du code HTML non désiré */
            for ($i = 0; $i < count($matchs['Date']); $i++) {
                $matchs["Date"][$i] = substr(substr($matchs['Date'][$i], 25), 0, -12);
                $matchs["Time"][$i] = substr(substr($matchs['Time'][$i], 25), 0, 5);
                $matchs["Salle"][$i] = substr(substr(addslashes($matchs['Salle'][$i]), 28), 0, -34);
                $matchs["Team1"][$i] = substr(substr(addslashes($matchs['Teams'][(($i + 1) * 2) - 2]), 47), 0, -24);
                $matchs["Team2"][$i] = substr(substr(addslashes($matchs['Teams'][(($i + 1) * 2) - 1]), 47), 0, -24);

                $dateXml = explode(".", $matchs["Date"][$i], 3);
                $matchs["DateXml"][$i] = $dateXml[2] . $dateXml[1] . $dateXml[0];
                unset($dateXml);
            }
            unset($matchs["Teams"]);
            $allMatchs = $this->reorder($allMatchs, $matchs, $k, 'matchs', 'match');
            unset($matchs["Team1"]);
            unset($matchs["Team2"]);
            unset($matchs["DateXml"]);
        }
        $xml = Xml::fromArray($allMatchs);
        $this->writeXml($xml, FILE_MATCH);
    }

    /**
     * Stock les classement pour toutes les équipe dans un XML
     * 
     * Va aller lire les données concernant le classement de toutes les équipes sur le site de 
     * la FSH puis va en extraire le contenu et finalement va les stocker dans un
     * ficher xml
     * 
     * @since 14.08.2013
     */
    function getRanking() {
        /* Déclaration des variables */
        App::uses('HttpSocket', 'Network/Http');
        App::uses('HttpResponseCake', 'Network/Http');
        
        // Définit que l'on n'utilise pas de layout pour l'affichage
        $this->render("get_datas", false);

        $teams = $this->Team->find('list', array(
            'fields' => array('Team.id')));
        $finalRanking = array('ranking' => array('rank' => array()));
        $debut = "/Rangliste";
        $fin = "/";
        $exp = $debut . ".*" . $fin . "s";
        $exp2 = "/<td align=Left width=\"160\"><span class=\"normal\">[\w\s&\/\-]+<\/td>\s+<td width=\"40\"><span class=\"normal\">\d+<\/td>\s+<td width=\"40\"><span class=\"normal\">\d+<\/td>\s+<td width=\"40\"><span class=\"normal\">0<\/td>\s+<td width=\"40\"><span class=\"normal\">\d+<\/td>\s+<td width=\"40\"><span class=\"normal\">[\-\d]+<\/td>\s+<td width=\"40\"><span class=\"normal\">[\-\d]+<\/td>\s+<td width=\"60\"><span class=\"normal\">[\-\d]+<\/td>\s+<td width=\"50\"><span class=\"normal\">\d+<\/td>/s";
        $expRank = "/<tr align=center valign=top> <td align=Left width=\"30\"><span class=\"normal\">\d+[.]<\/td>/";
        $expTeam = "/<td align=Left width=\"160\"><span class=\"normal\">[\w\s&\/\-\ \*;]+<\/td>/";
        $expNbMatchs = "/<td width=\"40\"><span class=\"normal\">[\-]?\d+<\/td>/";
        $expGoalDif = "/<td width=\"60\"><span class=\"normal\">[\-]?\d+<\/td>/";
        $expPoints = "/<td width=\"50\"><span class=\"normal\">\d+<\/td>/";
        $url = 'http://vvs.handball.ch/vvs/resultate.asp';
        $fileName = "xml/ranking.xml";
        $HttpSocket = new HttpSocket();
        $results = new HttpSocket();
        foreach ($teams as $k => $id) {

            $team = $this->Team->find('first', array('conditions' => array('id' => $id)));

            $params = 'Saison=' . date("Y") . '
                           &Gruppe=' . $team['Team']['group'] . '
                           &Team=' . $team['Team']['arhid'];

            // string query
            $results = $HttpSocket->get($url, $params);
            preg_match($exp, $results->body, $html);
            $html = current($html);

            //Récupération des nom des équipes depuis le code HTML
            preg_match_all(htmlentities($expTeam), htmlentities($html), $rank['Team']);
            //Récupération des équipes pour tous les matchs
            preg_match_all($expNbMatchs, $html, $rank['InfoMatchs']);
            //récupération des salles pour tous les matchs
            preg_match_all($expGoalDif, $html, $rank['GoalDiff']);
            //récupération des salles pour tous les matchs
            preg_match_all($expPoints, $html, $rank['Points']);

            $rank['Team'] = current($rank['Team']);
            $rank['InfoMatchs'] = current($rank['InfoMatchs']);
            $rank['GoalDiff'] = current($rank['GoalDiff']);
            $rank['Points'] = current($rank['Points']);

            /* supprésion du code HTML non désiré */
            for ($i = 0; $i < count($rank['Team']); $i++) {
                $rank['Team'][$i] = addslashes(substr(substr($rank['Team'][$i], 80), 0, -12));
                $rank['NbMatchs'][$i] = substr(substr($rank['InfoMatchs'][(($i + 1) * 6) - 6], 36), 0, -5);
                $rank["Won"][$i] = substr(substr($rank['InfoMatchs'][(($i + 1) * 6) - 5], 36), 0, -5);
                $rank["Tie"][$i] = substr(substr($rank['InfoMatchs'][(($i + 1) * 6) - 4], 36), 0, -5);
                $rank["Lost"][$i] = substr(substr($rank['InfoMatchs'][(($i + 1) * 6) - 3], 36), 0, -5);
                $rank["GoalsIn"][$i] = substr(substr($rank['InfoMatchs'][(($i + 1) * 6) - 2], 36), 0, -5);
                $rank["GoalsOut"][$i] = substr(substr($rank['InfoMatchs'][(($i + 1) * 6) - 1], 36), 0, -5);
                $rank["GoalDiff"][$i] = substr(substr($rank['GoalDiff'][$i], 36), 0, -5);
                $rank["Points"][$i] = substr(substr($rank['Points'][$i], 36), 0, -5);
            }
            unset($rank['InfoMatchs']);
            $finalRanking = $this->reorder($finalRanking, $rank, $k, 'ranking', 'rank');
            unset($rank['NbMatchs']);
            unset($rank["Won"]);
            unset($rank["Tie"]);
            unset($rank["Lost"]);
            unset($rank["GoalsIn"]);
            unset($rank["GoalsOut"]);
            unset($rank["GoalDiff"]);
            unset($rank["Points"]);
        }
        $xml = Xml::fromArray($finalRanking);
        $this->writeXml($xml, FILE_RANKING);
    }

    /**
     * Stock les résultats des matchs pour toutes les équipe dans un XML
     * 
     * Va aller lire les résultats des matchs concernant toutes les équipes sur le site de 
     * la FSH puis va en extraire le contenu et finalement va les stocker dans un
     * ficher xml
     * 
     * @since 14.08.2013
     */
    function getResults() {

        /* Déclaration des librairie */
        App::uses('HttpSocket', 'Network/Http');
        App::uses('HttpResponseCake', 'Network/Http');

        // Définit que l'on n'utilise pas de layout pour l'affichage
        $this->render("get_datas", false);

        //Récupère la liste des équipe a traiter
        $teams = $this->Team->find('list', array(
            'fields' => array('Team.id')));

        /* Déclaration des variables */
        $expDate = "/<td width=80><span class=\"normal\">[\d]{2}.[\d]{2}.[\d]{4}<\/td>/";
        $expTeams = "/<td width=160><span class=\"normal\">.*<\/td>/";
        $expPsts = "/<td align=center width=20><span class=\"normal\">[\d]{1,2}<\/td>/";


        $url = 'http://vvs.handball.ch/vvs/resultatanzeige.asp';;
        $HttpSocket = new HttpSocket();
        $htmlSource = new HttpSocket();
        $results = array();

        foreach ($teams as $k => $id) {

            $team = $this->Team->find('first', array('conditions' => array('id' => $id)));

            $params = 'Saison=2012
                           &Gruppe=' . $team['Team']['group'] . '
                           &Team=' . $team['Team']['arhid'];

            // string query
            $htmlSource = $HttpSocket->get($url, $params);
            $html = $htmlSource->body;


            //Récupération des date pour tous les match
            preg_match_all($expDate, $html, $result['Date']);
            //Récupération des heures pour tous les matchs
            preg_match_all($expPsts, $html, $result['Points']);
            //Récupération des équipes pour tous les matchs
            preg_match_all(htmlentities($expTeams), htmlentities($html), $result['Teams']);


            $result['Teams'] = current($result['Teams']);
            $result['Points'] = current($result['Points']);
            $result['Date'] = current($result['Date']);

            if (count($result['Date']) != 0) {
                for ($i = 0; $i < count($result['Date']); $i++) {
                    $result["Date"][$i] = substr(substr($result['Date'][$i], 34), 0, -5);
                    $result["Team1"][$i] = substr(substr(addslashes($result['Teams'][(($i + 1) * 2) - 2]), 57), 0, -11);
                    $result["Team2"][$i] = substr(substr(addslashes($result['Teams'][(($i + 1) * 2) - 1]), 57), 0, -11);
                    $result["Pts1"][$i] = substr(substr($result['Points'][(($i + 1) * 2) - 2], 47), 0, -5);
                    $result["Pts2"][$i] = substr(substr($result['Points'][(($i + 1) * 2) - 1], 47), 0, -5);

                    $dateXml = explode(".", $result["Date"][$i], 3);
                    $result["DateXml"][$i] = $dateXml[2] . $dateXml[1] . $dateXml[0];
                    unset($dateXml);
                }
                unset($result["Teams"]);
                unset($result["Points"]);
                $results = $this->reorder($results, $result, $k, 'results', 'result');
                unset($result["Team1"]);
                unset($result["Team2"]);
                unset($result["Pts1"]);
                unset($result["Pts2"]);
                unset($result["DateXml"]);
            }
        }


        if (sizeof($result['Teams']) != 0) {
            $xml = Xml::fromArray($results);
            $this->writeXml($xml, FILE_RESULT);
        }
    }

    /**
     * Va ecrire le contenu d'une variable XML dans un fichier
     * 
     * @since 14.08.2013
     * @param xml $xml Le contenu XML à écrire dans une fichier
     * @param string $fileName Le nom du ficher dans lequel on va ecrire
     */
    private function writeXml($xml, $fileName) {
        debug($xml);
        $fp = fopen($fileName, 'w');
        if (!fwrite($fp, $xml->asXml()))
            echo 'Problem occurred: Maybe access problem';
        else
            echo 'Everything under control ';
        fclose($fp);
    }

    /**
     * Va ecrire le contenu d'une variable XML dans un fichier XML
     * 
     * @since 14.08.2013
     * @param xml $xml Le contenu XML à écrire dans une fichier
     * @param string $fileName Le nom du ficher dans lequel on va ecrire
     */
    private function reorder($allMatchs, $arrayMatch, $id, $firstChild, $secondChild) {
        debug($allMatchs);
        $arrayMin = count($allMatchs[$firstChild][$secondChild]);
        foreach ($arrayMatch as $key => $data) {
            foreach ($data as $k => $v) {
                $allMatchs[$firstChild][$secondChild][$k + $arrayMin][$key] = utf8_encode(html_entity_decode($v));
                $allMatchs[$firstChild][$secondChild][$k + $arrayMin]['@teamId'] = $id;
            }
        }
        /**
         * @todo Test if group or id are note valid 
         */
        if ($allMatchs)
            return $allMatchs;
        else
            return NULL;
    }

}

?>
