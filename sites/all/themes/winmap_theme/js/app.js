/**
 * Created by VDP on 05/05/2017.
 */

(function($) {
    $(document).ready(function() {



        $('.toggle-menu').on('click', function() {
            var _this = $(this);
            _this.toggleClass('active');
            $('.header-navigator').toggleClass('active');
            $('body').toggleClass('no-scroll');
        });



    });
})(jQuery);
