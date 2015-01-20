<?php
/**
 * Fonctions utiles au plugin Saisies pour Mots-Clés
 *
 * @plugin     Saisies pour Mots-Clés
 * @copyright  2015
 * @author     Michel @ Vertige ASBL
 * @licence    GNU/GPL
 * @package    SPIP\Saisies_mots\Fonctions
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Trouve les mots-clés associés à un objet
 *
 * @param String  $objet :     Le type d'objet
 * @param int     $id_objet :  L'id de l'objet
 * @param int     $id_groupe : Un éventuel groupe de mots-clés auquel se
 *                             restreindre.
 *
 * @return array : Une liste des id_mot des mots-clés liés à l'objet
 */
function trouver_mots ($objet, $id_objet, $id_groupe='*') {

    include_spip('action/editer_liens');

    $mots_lies = objet_trouver_liens(array('mot' => mots_groupe($id_groupe)),
                                     array($objet => $id_objet));

    return array_map(function ($el) {
        return $el['id_mot'];
    }, $mots_lies);
}

/**
 * Lie des mots-clés à un objet éditorial
 *
 * Supprime les mots-clés déjà liés à l'objet en question avant de
 * faire la liaison. De cette façon on est certain qu'après avoir
 * exécuté la fonction, les mots liés à l'objet sont exactement ceux
 * passés dans $mots.
 *
 * @param String $objet :     le type d'objet éditorial
 * @param String $id_objet :  l'id de l'objet éditorial
 * @param array $mots :       une liste d'identifiant de mots-clés à
 *                            associer à l'objet
 * @param int    $id_groupe : un éventuel id_groupe auquel se restreindre.
 *
 * @return String  Un message d'erreur si une erreur a eu lieu, rien sinon.
 */
function lier_mots ($objet, $id_objet, $mots, $id_groupe='*') {

    include_spip('action/editer_liens');

    // On vire d'éventuels identifiants non valides
    $mots = array_filter($mots, function ($el) {
        return (intval($el) > 0);
    });

    objet_dissocier(array('mot' => mots_groupe($id_groupe)), array($objet => $id_objet));
    objet_associer(array('mot' => $mots), array($objet => $id_objet));
}

/**
 * Retourne les mots-clé appartenant à un groupe de mots-clés
 *
 * @param int $id_groupe : l'identifiant d'un groupe de mots-clé
 *
 * @return array : Une liste des identifiants des mots-clés du groupe
 */
function mots_groupe ($id_groupe='*') {

    if ($id_groupe === '*') {
        $mots_groupe = sql_allfetsel('id_mot', 'spip_mots');
    } else {
        $mots_groupe = sql_allfetsel('id_mot', 'spip_mots',
                                     'id_groupe='.intval($id_groupe));
    }

    $mots_groupe = array_map(function ($el) {
        return $el['id_mot'];
    }, $mots_groupe);

    return $mots_groupe;
}
