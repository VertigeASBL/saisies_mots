(function ($) {
    // définition du plugin jquery
    $.fn.saisiesMotsCles = function (options) {

        var config, saisie = $(this);

        config = $.extend(true, {}, options);

        saisie.find('fieldset').each(function () {
            var fieldset = $(this),
                legend   = fieldset.children('legend'),
                contenu  = fieldset.children('.contenu');

            // contenu.hide();
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
