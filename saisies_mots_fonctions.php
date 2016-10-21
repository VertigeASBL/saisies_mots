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

/**
 * Trouve les mots-clés associés à un objet
 *
 * @param String  $objet :     Le type d'objet
 * @param int     $id_objet :  L'id de l'objet
 * @param int     $id_groupe : Un éventuel groupe de mots-clés auquel se
 *                             restreindre.
 * @param bool    $chercher_enfants : Si TRUE, inclure les éventuels
 *                            sous-groupes de mots-clés (ça n'a de
 *                            sens que si l'on utilise le plugin gma)
 *
 * @return array : Une liste des id_mot des mots-clés liés à l'objet
 */
function trouver_mots($objet, $id_objet, $id_groupe = '*', $chercher_enfants = false) {

	include_spip('action/editer_liens');

	$mots_lies = objet_trouver_liens(
		array('mot' => mots_groupe($id_groupe, $chercher_enfants)),
		array($objet => $id_objet)
	);

	if ($mots_lies) {
		return array_map(function ($el) {
			return $el['id_mot'];
		}, $mots_lies);
	} else {
		return array();
	}
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
 *                            associer à l'objet. Peut aussi être un identifiant.
 * @param int    $id_groupe : un éventuel id_groupe auquel se restreindre.
 * @param bool $chercher_enfants : Si TRUE, inclure les éventuels sous-groupes
 *                            de mots-clés (ça n'a de sens que si l'on
 *                            utilise le plugin gma)
 *
 * @return String  Un message d'erreur si une erreur a eu lieu, rien sinon.
 */
function lier_mots($objet, $id_objet, $mots, $id_groupe = '*', $chercher_enfants = false) {

	include_spip('action/editer_liens');

	if (! $mots) {
		$mots = array();
	} elseif (! is_array($mots)) {
		$mots = array($mots);
	}

	// On vire d'éventuels identifiants non valides
	$mots = array_filter($mots, function ($el) {
		return (intval($el) > 0);
	});

	objet_dissocier(
		array('mot' => mots_groupe($id_groupe, $chercher_enfants)),
		array($objet => $id_objet)
	);

	objet_associer(array('mot' => $mots), array($objet => $id_objet));
}

/**
 * Retourne les mots-clé appartenant à un groupe de mots-clés
 *
 * @param int $id_groupe : l'identifiant d'un groupe de mots-clé
 * @param bool $chercher_enfants : Si TRUE, inclure les éventuels
 *                         sous-groupes de mots-clés (ça n'a de sens
 *                         que si l'on utilise le plugin gma)
 *
 * @return array : Une liste des identifiants des mots-clés du groupe
 */
function mots_groupe($id_groupe = '*', $chercher_enfants = false) {

	if ($id_groupe === '*') {
		$mots_groupe = sql_allfetsel('id_mot', 'spip_mots');
	} else {
		$mots_groupe = sql_allfetsel(
			'id_mot',
			'spip_mots',
			'id_groupe='.intval($id_groupe)
		);
	}

	$mots_groupe = array_map(function ($el) {
		return $el['id_mot'];
	}, $mots_groupe);

	if ($chercher_enfants) {
		$sous_groupes = sql_allfetsel(
			'id_groupe',
			'spip_groupes_mots',
			'id_parent=' . intval($id_groupe)
		);

		foreach ($sous_groupes as $sous_groupe) {
			$mots_groupe = array_merge($mots_groupe, mots_groupe($sous_groupe['id_groupe'], true));
		}
	}

	return $mots_groupe;
}

/**
 * Critère de boucle pour filtrer par mot-clés
 *
 * On passe soit un tableau d'id_mot en paramètre, mais contrairement
 * à ce qui se passe en faisant {id_mot IN #GET{mes_id_mots}}, passer
 * un tableau vide ne filtre rien.
 */
function critere_mots_in_ou_tout($idb, &$boucles, $crit) {

	$boucle = $boucles[$idb];
	$id_mots = calculer_liste(array($crit->param[0][0]), array(), $boucles, $boucle->id_parent);

	$trouver_table = charger_fonction('trouver_table', 'base');

	$depart = array($boucle->id_table,
					$trouver_table($boucle->id_table, $boucle->sql_serveur));

	$arrivee = array('mots',
					 $trouver_table('mots', $boucle->sql_serveur));

	$alias_jointure = calculer_jointure($boucle, $depart, $arrivee);

	$boucle->where[] = "((count($id_mots) > 0) ? sql_in('$alias_jointure.id_mot', $id_mots) : '')";
}
