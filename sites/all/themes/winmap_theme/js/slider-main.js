/**
 * Created by VDP on 05/05/2017.
 */

(function ($) {
  $(document).ready(function () {
    var smain_slider = [];
    $('#main-slider .swiper-container').each(function(index, element){
      $(this).addClass('s'+index);
      var slider = new Swiper('#main-slider .swiper-container.s'+index, {
        // direction: 'vertical',
        loop: true,
        paginationClickable: false,
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        effect: 'fade',
        lazyLoading: true,
        autoplay:2000,
        fade: {
          crossFade: true
        },
        autoHeight:true,
      });
      smain_slider.push(slider);
      var _nextButton = $(this).find('.swiper-button-next');
      var _prevButton = $(this).find('.swiper-button-prev');

      _nextButton.click(function () {
        console.log(smain_slider);
        for (var i=0; i<smain_slider.length; i++) {
          if (smain_slider[i] !== slider) {
            smain_slider[i].slideTo(slider.activeIndex);
          }
        }
      });
      _prevButton.click(function () {
        for (var i=0; i<smain_slider.length; i++) {
          if (smain_slider[i] !== slider) {
            smain_slider[i].slideTo(slider.activeIndex);
          }
        }
      });

    });




  });
})(jQuery);