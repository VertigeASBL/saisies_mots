(function ($) {
    // définition du plugin jquery
    $.fn.saisiesMotsCles = function (options) {

        var config, saisie = $(this), groupes;

        config = $.extend(true, {
            demarrer_plie: true
        }, options);

        saisie.find('fieldset').each(function () {
            var fieldset = $(this),
                legend   = fieldset.children('legend'),
                contenu  = fieldset.children('.contenu');

            if (config.demarrer_plie) {
                contenu.hide();
            }

            // un clic sur la légende plie ou déplie le fieldset
            legend.click(function () {
                contenu.toggle({
                    duration: 200
                });
            });
        });

        // On calcule une fois pour toutes une liste des groupes de
        // mots-clés
        groupes = saisie.find('.choix_groupe_mots');
        groupes = $.map(groupes, function (el) {
            return {
                'id': el.className.replace(/^.*choix_groupe_([^ ]+).*$/,'$1'),
                'titre': $(el).find('legend').html().trim()
            };
        });

        // les mot-clés qui ont le même titre qu'un groupe sont
        // spéciaux, quand on les active/désactive, on
        // active/désactive automatiquement les mots-clés du groupe
        // correspondant.
        saisie.find('.choix_mot').each(function () {
            var choix_mot = $(this),
                titre = choix_mot.find('label').html().trim();

            $.each(groupes, function (i,groupe) {

                if (titre === groupe.titre) {

                    choix_mot.change(function (e) {
                        if (e.target.checked) {
                            $('.choix_groupe_' + groupe.id + ' input')
                                .attr('checked','checked')
                                .trigger('change');
                        } else {
                            $('.choix_groupe_' + groupe.id + ' input')
                                .attr('checked', false)
                                .trigger('change');
                        }
                    });

                    return false;
                }
            });
        });

        return saisie;
    };

    // On l'applique aux saisies mots_cles_arborescents
    $(function () {
        $('.saisie_checkbox_mots_arborescents').saisiesMotsCles();
    });
})(jQuery);
