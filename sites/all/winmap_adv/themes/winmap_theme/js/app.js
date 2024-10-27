/**
 * Created by VDP on 05/05/2017.
 */

(function($) {
    $(document).ready(function() {
        $('.input-group-option ul li.expanded>div:first-child').on('click', function() {
            $(this).parents('li.expanded').toggleClass('active').siblings().removeClass('active');
        });
        var homeProduct = new Swiper('.home-product .swiper-container', {
            slidesPerView: 4,
            spaceBetween: 30,
            speed: 1200,
            autoplay: {
                delay: 3000,
            },
            loop: true,
            navigation: {
                nextEl: '.home-product .swiper-button-next',
                prevEl: '.home-product .swiper-button-prev',
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 7,
                },
                680: {
                    slidesPerView: 2,
                    spaceBetween: 7,
                },
                769: {
                    slidesPerView: 3,
                },
                991: {
                    slidesPerView: 4,
                }
            }
        });
        var newsOther = new Swiper(".news-other .swiper-container", {
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: '.news-other .swiper-button-next',
                prevEl: '.news-other .swiper-button-prev',
            },
        });
        var otherProduct = new Swiper(".block-other-product .swiper-container", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            grabCursor: true,
            pagination: {
                el: ".block-other-product .swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 7,
                },
                680: {
                    slidesPerView: 2,
                    spaceBetween: 7,
                },
                769: {
                    slidesPerView: 3,
                }
            }
        });


        $('form#addproduct select#material').change(function() {
            var _this_ = $(this);
            var material = _this_.val();
            var sex = $('form#addproduct input[name="gender"]:checked').val();
            var prices = Drupal.settings.prices;
            var price = null;
            for (var i = 0; i < prices.length; i++) {
                if (prices[i].material == material && prices[i].sex == sex) {
                    price = prices[i].price;
                    break;
                }
            }
            if (price != null) {
                $('#pricetext').html(price + 'đ');
            } else {
                $('#pricetext').html(Drupal.t('Contact'));
            }

        });

        $('form#addproduct input[name="gender"]').change(function() {
            var material = $('form#addproduct select#material').val();
            var sex = $('form#addproduct input[name="gender"]:checked').val();
            var prices = Drupal.settings.prices;
            var price = null;
            for (var i = 0; i < prices.length; i++) {
                if (prices[i].material == material && prices[i].sex == sex) {
                    price = prices[i].price;
                    break;
                }
            }
            if (price != null) {
                $('#pricetext').html(price + 'đ');
            } else {
                $('#pricetext').html(Drupal.t('Comments') + 'đ');
            }
        });

        $('form#addproduct  a.btn-add-cart').click(function(e) {
            var product_id = jQuery(this).attr('data-id');
            var material = $('form#addproduct select#material').val();
            var sex = $('form#addproduct input[name="gender"]:checked').val();
            var inscribed = $('form#addproduct input[name="inscribed"]').val();
            var post = {
                'cmd': 'add',
                'data': {
                    'product': {
                        'quantity': 1,
                        'product_id': product_id,
                        'material': material,
                        'sex': sex,
                        'inscribed': inscribed
                    },
                }
            };
            jQuery.ajax({
                type: "POST",
                url: "/cart/progress",
                dataType: "json",
                data: post,
                success: function(data) {
                    if (data.hasOwnProperty('success') && data.success) {
                        window.location.replace(window.location.origin + '/' + Drupal.settings.pathPrefix + 'cart');
                    } else if (data.hasOwnProperty('message')) {
                        add_cart_dialog = jQuery.dialog({
                            title: '',
                            type: 'cart-add-success-message',
                            content: data.message,
                            // columnClass: 'small',
                            useBootstrap: false,
                            animation: 'top',
                            closeAnimation: 'scale',
                            animateFromElement: false,
                        });
                    }
                },
            });
            return false;
        });

        $('.shop-cart-main form#cart .box-order .minus').click(function(e) {

        })

        $('.shop-cart-main form#cart .box-order .minus').click(function(e) {
            var _this_ = $(this);
            var _count = parseInt(_this_.closest('div.box-order').find('input.quantity').val());
            if (_count > 1) {
                _count -= 1;
                _this_.closest('div.box-order').find('input.quantity').val(_count);
                _this_.closest('div.box-order').find('input.quantity').trigger("change");
            }
        })

        $('.shop-cart-main form#cart .box-order .plus').click(function(e) {
            var _this_ = $(this);
            var _count = parseInt(_this_.closest('div.box-order').find('input.quantity').val());
            _count++;
            _this_.closest('div.box-order').find('input.quantity').val(_count);
            _this_.closest('div.box-order').find('input.quantity').trigger("change");
        })

        $('.shop-cart-main form#cart .box-order input.quantity').change(function(e) {
            var _this_ = $(this);
            var post = {
                'cmd': 'update',
                'data': {}
            };
            post['data'] = {
                'products': []
            };
            post['data']['products'].push({
                'product_id': _this_.attr('data-product-id'),
                'sex': _this_.attr('data-product-sex'),
                'material': _this_.attr('data-product-material'),
                'quantity': _this_.val()
            });


            jQuery.ajax({
                type: "POST",
                url: "/cart/progress",
                dataType: "json",
                data: post,
                success: function(data) {
                    location.reload();
                },
            });
        })


        $('.shop-cart-main form#cart .box-order a.deleteCartItem').click(function(e) {
            var _this_ = $(this);
            var post = {
                'cmd': 'delete',
                'data': {}
            };
            post['data'] = {
                'products': [],
            };
            post['data']['products'].push({
                'product_id': _this_.attr('data-product-id'),
                'sex': _this_.attr('data-product-sex'),
                'material': _this_.attr('data-product-material'),
                'quantity': _this_.val()
            });

            console.log(post);

            jQuery.ajax({
                type: "POST",
                url: "/cart/progress",
                dataType: "json",
                data: post,
                success: function(data) {
                    location.reload();
                },
            });

            return false;
        });


        $('.toggle-menu').on('click', function() {
            var _this = $(this);
            _this.toggleClass('active');
            $('.header-navigator').toggleClass('active');
            $('body').toggleClass('no-scroll');
        });



    });
})(jQuery);