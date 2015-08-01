(function ($) {

    // définition du plugin jquery
    $.fn.saisiesMotsClesArbo = function (options) {

        var saisie = $(this),
            config = $.extend(true, {
                demarrer_plie: true,
                vitesse_animation: 200
            }, options);

        function groupeMot () {
            var fieldset = $(this) .children('fieldset'),
                legend   = fieldset.children('legend'),
                contenu  = fieldset.children('.contenu'),
                plier;

            function toggle () {
                contenu.toggle({
                    duration: config.vitesse_animation
                });
                legend.toggleClass('plie');
            }

            /* Un clic sur la légende plie/déplie le contenu */
            legend.click(toggle);

            /* Si on démarre plié, on replie le groupe, mais seulement
               si aucun mot n'est séléctionné */
            if (config.demarrer_plie) {
                plier = true;
                contenu.find('input').each(function () {
                    if ($(this).attr('checked') === 'checked') {
                        plier = false;
                        return false; /* on interrompt la boucle */
                    }
                });
                if (plier) {
                    contenu.hide();
                    legend.addClass('plie');
                }
            }

            /* Si un mot du groupe est coché, on déplie dans tous les cas */
            contenu.find('.choix_mot').change(function () {
                if (legend.hasClass('plie') &&
                    ($(this).children('input').attr('checked') === 'checked')) {

                    toggle();
                }
            });

            /* On prépare aussi les enfants récursivement */
            contenu.children('.choix_groupe_mots').map(groupeMot);
            contenu.children('.choix_mot').map(mot);
        }

        function mot () {
            var choix_mot = $(this),
                titre = choix_mot.children('label').html().trim(),
                groupe_parent = choix_mot.parents('.choix_groupe_mots').first(),
                valeur;

            /* s'il faut contrôler tout le groupe avec cette checkbox */
            if (titre.match(/^tou(s|tes?)/i)) {

                /* On coche tous les sous-mots si la case est cochée */
                choix_mot.change(function () {

                    valeur = $(this).children('input').attr('checked') ?
                        'checked' : null;

                    groupe_parent.find('input').each(function () {
                        /* La non-égalité faible est importante ! */
                        if ($(this).attr('checked') != valeur) {
                            $(this).attr('checked', valeur).change();
                        }
                    });
                });

                /* On décoche la case quand un sous-mot est décoché */
                groupe_parent.find('input').change(function () {
                    if ( ! $(this).attr('checked')) {
                        choix_mot.children('input').attr('checked', null);
                    }
                });

            }
        }

        saisie.children('.choix_groupe_mots').map(groupeMot);
        saisie.children('.choix_mot').map(mot);

        return saisie;
    };

    // On l'applique aux saisies mots_cles_arborescents
    $(function () {
        $('.saisie_checkbox_mots_arborescents').saisiesMotsClesArbo();
    });
})(jQuery);
