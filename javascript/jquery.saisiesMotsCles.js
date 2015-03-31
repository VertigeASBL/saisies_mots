(function ($) {
    // définition du plugin jquery
    $.fn.saisiesMotsCles = function (options) {

        var config, saisie = $(this);

        config = $.extend(true, {
            demarrer_plie: true
        }, options);

        saisie.find('fieldset').each(function () {
            var fieldset = $(this),
                legend   = fieldset.children('legend'),
                contenu  = fieldset.children('.contenu');

            if (config.demarrer_plie) {
                if (contenu.find('input[checked="checked"]').length === 0) {
                    contenu.hide();
                    legend.addClass('plie');
                }
            }

            // un clic sur la légende plie ou déplie le fieldset
            legend.click(function () {
                contenu.toggle({
                    duration: 200
                });
                legend.toggleClass('plie');
            });
        });

        // les mot-clés qui ont le même titre qu'un groupe sont
        // spéciaux, quand on les active/désactive, on
        // active/désactive automatiquement les mots-clés du groupe
        // correspondant.
        saisie.find('.choix_mot').each(function () {
            var choix_mot = $(this),
                titre = choix_mot.find('label').html().trim(),
                groupe_parent = $(e.target).parents('.choix_groupe_mots').first();
                groupes_fratrie = groupe_parent.find('.choix_groupe_mots');

            // les mots-clés dont le titre commence par "tous" ou
            // "toutes" modifient leur groupe en entier
            if (titre.match(/^tou(s|tes?)/i)) {
                choix_mot.change(function (e) {
                    if (e.target.checked) {
                        groupe_parent.find('input').not(choix_mot.find('input'))
                            .attr('checked','checked')
                            .trigger('change');
                        groupe_parent.find('.contenu')
                            .show(200);
                    } else {
                        groupe_parent.find('input').not(choix_mot.find('input'))
                            .attr('checked', false)
                            .trigger('change');
                    }
                });
            }

            // On calcule les groupes de mots-clés du même niveau et en dessous
            groupes_fratrie = $.map(groupes_fratrie, function (el) {
                return {
                    'id': el.className.replace(/^.*choix_groupe_([^ ]+).*$/,'$1'),
                    'titre': $(el).find('legend').html().trim()
                };
            });

            $.each(groupes_fratrie, function (i,groupe) {

                if (titre === groupe.titre) {

                    choix_mot.change(function (e) {
                        if (e.target.checked) {
                            $('.choix_groupe_' + groupe.id + ' input')
                                .attr('checked','checked')
                                .trigger('change');
                            $('.choix_groupe_' + groupe.id + ' .contenu')
                                .show(200);
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
