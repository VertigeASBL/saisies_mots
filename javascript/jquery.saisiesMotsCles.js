(function ($) {
    // définition du plugin jquery
    $.fn.saisiesMotsCles = function (options) {

        var config;

        config = $.extend(true, {}, options);

        console.log(this);

        return this;
    };

    // On l'applique aux saisies mots_cles_arborescents
    $(function () {
        $('.saisie_checkbox_mots_arborescents').saisiesMotsCles();
    });
})(jQuery);
