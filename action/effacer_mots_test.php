<?php
/**
 * Effacer les objets crées uniquement pour les tests
 *
 * @plugin     Saisies de Mots-Clés
 * @copyright  2015
 * @author     Michel @ Vertige ASBL
 * @licence    GNU/GPL
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_effacer_mots_test_dist($arg=null) {

    if (is_null($arg)){
        $securiser_action = charger_fonction('securiser_action', 'inc');
        $arg = $securiser_action();
    }

    $objecteur_effacer = charger_fonction('effacer', 'inc/objecteur');
    $definitions = charger_fonction('definitions', 'formulaires/tester_saisies_mots');

    $objecteur_effacer($definitions());

    include_spip('inc/meta');
    effacer_meta('saisie_mots_dernier_samourai');
}