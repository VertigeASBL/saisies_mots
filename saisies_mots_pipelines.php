<?php
/**
 * Utilisations de pipelines par Saisies pour Mots-Clés
 *
 * @plugin     Saisies pour Mots-Clés
 * @copyright  2015
 * @author     Michel @ Vertige ASBL
 * @licence    GNU/GPL
 * @package    SPIP\Saisies_mots\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Insérer du css pour les saisies mots-clés
 *
 * @pipeline header_prive
 * @param  array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function saisies_mots_header_prive ($flux) {

    $flux .= '<link rel="stylesheet" type="text/css" media="all" href="' .
        find_in_path('saisies_mots.css') . '" />';

    return $flux;
}