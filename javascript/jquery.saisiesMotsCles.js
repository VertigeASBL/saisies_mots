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
                contenu.hide();
            }

            // un clic sur la légende plie ou déplie le fieldset
            legend.click(function () {
                contenu.toggle({
                    duration: 200
                });
            });
        });

        return saisie;
    };

    // On l'applique aux saisies mots_cles_arborescents
    $(function () {
        $('.saisie_checkbox_mots_arborescents').saisiesMotsCles();
    });
})(jQuery);
