$(window).scroll(function() {
    if($(this).scrollTop() > 300){ 
        $('.botonSubir').slideDown(300);
    }else{
        $('.botonSubir').slideUp(300);
    }
});

var principal = (function (window, undefined) {
    var init = function() {
        $('#openMenu').on('click', function(e) {
            e.preventDefault();
            $('#inicio').addClass('slideout-open');
            $('.bloqueMenu').addClass('visible');
        });

        $('#closeMenu').on('click', function(e) {
            e.preventDefault();
            $('.bloqueMenu').removeClass('visible');
            $('#inicio').removeClass('slideout-open');
        });

        $('.dropDown').each(function() {
            $(this).find('a.opcmenu').on('click', function(e) {
                e.preventDefault();
            });

            $(this).on('mouseover', function() {
                $(this).find('ul.submenu').addClass('submenuVisible');
            }).on('mouseout', function() {
                $(this).find('ul.submenu').removeClass('submenuVisible');
            });
        });

        $('[href="dropDown"]').each(function() {
            $(this).on('click', function(e) {
                e.preventDefault();
                $('.enlaceActivo').removeClass('enlaceActivo');
                $('.subMenuLateralVisible').removeClass('subMenuLateralVisible');
                $(this).addClass('enlaceActivo');
                $(this).parent().find('.subMenuLateral').addClass('subMenuLateralVisible');
            });
        });
    };

    return {
        init : function() {
            init();
        }
    };

})(window, undefined);

(function($) {
    principal.init();
})(jQuery);