<?php
/**
 * Formulaire pour tester le plugin jQuery javascripts/SaisiesMotsCles.js
 *
 * @plugin     Saisies de Mots-Clés
 * @copyright  2015
 * @author     Michel @ Vertige ASBL
 * @licence    GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Retourne les définitions des objets dont on a besoin pour faire les
 * tests
 *
 * @return array : La définitions de objets de test
 */
function formulaires_tester_saisies_mots_definitions () {

    return array(
        array(
            'objet' => 'groupe_mots',
            'options' => array(
                'nom' => 'groupe_test',
                'titre' => 'Groupe de mots-clés de test',
                'id_parent' => 0,
            ),
            'enfants' => array(
                array(
                    'objet' => 'mot',
                    'options' => array(
                        'titre' => '10. Un premier mot clé',
                    ),
                ),
                array(
                    'objet' => 'groupe_mot',
                    'options' => array(
                        'titre' => '10. Un sous-groupe',
                    ),
                    'enfants' => array(
                        array(
                            'objet' => 'mot',
                            'options' => array(
                                'titre' => 'Sumo 1',
                            ),
                        ),
                        array(
                            'objet' => 'mot',
                            'options' => array(
                                'titre' => 'Sumo 2',
                            ),
                        ),
                        array(
                            'objet' => 'mot',
                            'options' => array(
                                'titre' => 'Sumo 3',
                            ),
                        ),
                    ),
                ),
                array(
                    'objet' => 'groupe_mot',
                    'options' => array(
                        'titre' => '20. Un autre sous-groupe',
                    ),
                    'enfants' => array(
                        array(
                            'objet' => 'mot',
                            'options' => array(
                                'titre' => '00. Tous',
                            ),
                        ),
                        array(
                            'objet' => 'mot',
                            'options' => array(
                                'titre' => '05. Sumo 1',
                            ),
                        ),
                        array(
                            'objet' => 'mot',
                            'options' => array(
                                'titre' => '05. Sumo 2',
                            ),
                        ),
                        array(
                            'objet' => 'mot',
                            'options' => array(
                                'titre' => '05. Sumo 3',
                            ),
                        ),
                        array(
                            'objet' => 'groupe_mot',
                            'options' => array(
                                'titre' => '10. Sousou groupe 1',
                            ),
                            'enfants' => array(
                                array(
                                    'objet' => 'mot',
                                    'options' => array(
                                        'titre' => 'Samoraï 1',
                                    ),
                                ),
                                array(
                                    'objet' => 'mot',
                                    'options' => array(
                                        'titre' => 'Samoraï 2',
                                    ),
                                ),
                                array(
                                    'objet' => 'mot',
                                    'options' => array(
                                        'titre' => 'Samoraï 3',
                                    ),
                                ),
                            ),
                        ),
                        array(
                            'objet' => 'groupe_mot',
                            'options' => array(
                                'titre' => '20. Sousou groupe 2',
                            ),
                            'enfants' => array(
                                array(
                                    'objet' => 'mot',
                                    'options' => array(
                                        'titre' => '00. Tous',
                                    ),
                                ),
                                array(
                                    'objet' => 'mot',
                                    'options' => array(
                                        'titre' => 'Samoraï 1',
                                    ),
                                ),
                                array(
                                    'objet' => 'mot',
                                    'options' => array(
                                        'titre' => 'Samoraï 2',
                                    ),
                                ),
                                array(
                                    'objet' => 'mot',
                                    'options' => array(
                                        'titre' => 'Samoraï 3',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    );
}

/**
 * Saisies du formulaire de test du plugin Saisies de Mots-Clés
 *
 * @return array
 *     Tableau des saisies du formulaire
 */
function formulaires_tester_saisies_mots_saisies_dist () {

    $saisies = array();

    /* Si le plugin gma n'est pas activé, ça ne sert à rien de tester
       la saisie checkbox_mots_arborescents */
    if (test_plugin_actif('gma') AND test_plugin_actif('objecteur')) {

        /* On crée un groupe de mot-clés pour les tests s'il n'existe
           pas déjà */
        $objecteur = charger_fonction('objecteur', 'inc');
        $definitions = charger_fonction('definitions', 'formulaires/tester_saisies_mots');

        $ids = $objecteur($definitions());

        /* Si c'est un string, c'est une erreur */
        if (is_string($ids)) {
            var_dump($ids);
        }

        $saisies[] = array(
            'saisie' => 'checkbox_mots_arborescents',
            'options' => array(
                'nom' => 'mots_arbo',
                'label' => "Test checkbox_mots_arborescents",
                'id_groupe' => $ids['groupe_test'],
            ),
        );
    }

    return $saisies;
}

/**
 * Chargement du formulaire de test du plugin Saisies de Mots-Clés
 *
 * Déclarer les champs postés et y intégrer les valeurs par défaut
 *
 * @return array
 *     Environnement du formulaire
 */
function formulaires_tester_saisies_mots_charger_dist () {

    $valeurs = array();

    return $valeurs;
}