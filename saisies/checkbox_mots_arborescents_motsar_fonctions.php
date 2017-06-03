<?php
/**
 * Fonctions utiles au squelette checkbox_mots_arborescents_motsar
 *
 * @plugin     saisies_mots
 * @copyright  2017
 * @author     Michel @ Vertige ASBL
 * @licence    GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}


/**
 * Calcule si un mot-clé donné est le parent d'un autre
 *
 * @param integrer $id_mot : l'identifiant du mot-clé
 *
 * @return boolean : true si le mot est le parent d'un autre, false sinon
 */
function est_parent($id_mot) {

	include_spip('base/abstract_sql');

	return (boolean) sql_getfetsel('id_mot', 'spip_mots', 'id_parent='. intval($id_mot));
}
