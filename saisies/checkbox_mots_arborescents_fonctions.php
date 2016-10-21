<?php

function requete_mots_arborescents($id_groupe) {

	$requete = sql_multiselect(array(
		"SELECT ('mot'), id_mot as id_objet, titre
           FROM spip_mots
           WHERE id_groupe=" . intval($id_groupe),
		"SELECT ('groupe_mots'), id_groupe as id_objet, titre
           FROM spip_groupes_mots
           WHERE id_parent=" . intval($id_groupe),
	), 'titre, mot DESC');

	return monoligne($requete);
}

/* force un string à être sur une seule ligne, et vire d'éventuelles
   indentations */
function monoligne($string) {

	$tab = explode("\n", $string);

	return trim(
		array_reduce(
			$tab,
			function ($carry, $item) {
						 return $carry . trim($item) . ' ';
		    },
			''
		)
	);
}

function sql_multiselect($selects, $orderby, $limit = null) {

	$requete = '';

	foreach ($selects as $i => $select) {
		if ($i > 0) {
			$requete .= "\nUNION ALL\n";
		}

		$requete .= $select;
	}

	$requete .= "\n" .
		'ORDER BY ' . $orderby . "\n" .
		($limit ? 'LIMIT '    . $limit : '');

	return $requete;
}
