jQuery.noConflict();
(function($){
    $(function(){

        //SLIDER MAIN
        let $slider = $('#indexSlider');
        if ($slider.length) {
            let sl_slider = $slider.slick({
                infinite: true,
                autoplay: true,
                autoplaySpeed: 5000,
                // prevArrow: ".left-arrow",
                // nextArrow: ".right-arrow",
                arrows: false,
                slide: ".slide",
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                fade: true,
            });
        }

        let $sc_slider = $('.sectionSlider');
        if ($sc_slider.length) {
            $sc_slider.each(function () {
                let sl_slider = $(this).slick({
                    infinite: true,
                    autoplay: true,
                    // prevArrow: ".left-arrow",
                    // nextArrow: ".right-arrow",
                    arrows: false,
                    slide: ".slide",
                    variableWidth: true,
                    // slidesToShow: 1,
                    // slidesToScroll: 1,
                    dots: true,
                });
            })
        }

        $('#loader').addClass('loader-out');

        $('#toggleMode').click(function () {
            let $url = $(this).data('href');
            $.post($url);
            $('body').toggleClass('body-dark');
        });

        $('.hidden-ml').each(function () {
            let $href = $(this).data('ml');
            let $str = [];
            for ($i=0; $i<$href.length; $i++) {
                $str[$i] = String.fromCharCode(255 - $href[$i]);
            }
            $(this).attr('href', 'mailto: '+$str.join(''));
            $(this).html($str.join(''));
        });

        $('#menu_button').click(function () {
            $('#menu_button').toggleClass('active');
            $('#mainNavMenu').toggleClass('active');
            $('#mainNav').toggleClass('active');
            $('body').toggleClass('lock-scroll');
        });

        $('.popMenu li a').click(function () {
            $('.menu-btn').toggleClass('active');
            $('.submenu').toggleClass('active');
            $('.slideMenu__block').toggleClass('active');
            $('.topMenu__container').toggleClass('active');
            $('body').toggleClass('lock-scroll');
        });

        $('#close-popUp').click(function () {
            $('#pop-up').removeClass('active');
        });

        $('#mainCart').click(function (event) {
            event.preventDefault();
            let url = $(this).data("href");

            $.ajax({
                url: url,
                context: $('#popUpContent'),
                type:'GET',
                success: function(data){
                    $(this).html(data);
                },
                complete: function() {
                    $('#pop-up').addClass('active');
                }
            });
        });


        $('#rentProduct').on('click', function (event) {
            event.preventDefault();
            let url = $(this).data("href");
            $.ajax({
                url: url,
                context: $('#loginContent'),
                type:'GET',
                success: function(data){
                    $(this).html(data);
                },
                complete: function() {
                    $('#loginPopUp').addClass('active');
                }
            });
        });

        $('#buyProduct').on('click', function () {
            let url = $(this).data("href");
            $.ajax({
                url: url,
                context: $('#popUpContent'),
                type:'GET',
                success: function(data){
                    $(this).html(data);
                },
                complete: function() {
                    $('#pop-up').addClass('active');
                    $('#mainCount').html($('#cart-page').data('count'));
                    $('#mainCount').addClass('show');
                }
            });
        });

        $('#close-orderPopUp').click(function () {
            $('#orderPopUp').removeClass('active');
        });

        $('.history-link').click(function (event) {
            event.preventDefault();
            let url = $(this).attr("href");
            $.ajax({
                url: url,
                context: $('#orderPopUpContent'),
                type:'GET',
                success: function(data){
                    $(this).html(data);
                },
                complete: function() {
                    $('#orderPopUp').addClass('active');
                }
            });
        });

        $('#close-loginPopUp').click(function () {
            $('#loginPopUp').removeClass('active');
        });

        $('.mainUser').click(function (event) {
            event.preventDefault();
            let url = $(this).data("href");
            $.ajax({
                url: url,
                context: $('#loginContent'),
                type:'GET',
                success: function(data){
                    $(this).html(data);
                },
                complete: function() {
                    $('#loginPopUp').addClass('active');
                }
            });
        });

        let $dataCount = $('#dataCount').data('count-prv');
        let $dataCountBlocks = $('.dataCountBlock');
        if ($dataCountBlocks.length) {
            $dataCountBlocks.text($dataCount);
        }

        $('.scroll-btn').click(function () {
            let scroll_pos = $(window).height();

            $('html, body').animate({
                scrollTop: scroll_pos
            }, 1000);

        });

        let w_w = $(window).width();

        $('#mainPopMenu>li').click(function () {
            if (w_w <= 960) {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $(this).find('ul').slideUp();
                } else {
                    $('#mainPopMenu>li').removeClass('active');
                    $('#mainPopMenu').find('ul').slideUp();
                    $(this).addClass('active');
                    $(this).find('ul').slideDown();

                }
            }

        });

        $(window).resize(function () {
            w_w = $(window).width();
            if (w_w <= 960) {
                $('#mainPopMenu>li').removeClass('active');
                $('#mainPopMenu').find('ul').slideUp();
            } else {
                $('#mainPopMenu>li').addClass('active');
                $('#mainPopMenu').find('ul').slideDown();
            }
        });

        $('.currentLang').click(function () {
            let $list = $(this).parent().find('.langList').one();
            $list.toggleClass('active');
        });

        $('document').click(function (event) {
            $('#langList').slideUp();
        });

        if ($('#map').length) {
            initialize();
        }

        if ($('.grid').length) {

            // использование window.onload исправляет глюк с наезжанием плиток друг на друга при первом открытии каталога
            window.onload = function () {
                let $grid = $('.grid').isotope({
                    itemSelector: '.grid-item',
                    layoutMode: 'masonry',
                });
                $grid.isotope();

                // скрипт для ровного чередования прямых и реверсных плиток
                let $gridItem = $('.grid-item');
                if ($gridItem.length) {
                    $gridItem.each(function () {
                        if (!(($(this).width() < $(this).parent().width()/4)
                            && ($(this).position().left > window.innerWidth/2-100)
                            && ($(this).position().left < window.innerWidth/2+100)))
                        {
                            if (!($(this).position().left < 100)) {
                                $(this).addClass('reverse')
                            }
                        }
                    })
                }

            };
        }
        
        if ($('.ias-news-block').length) {
            let ias;
            if ($('#pressCenterContent').length) {
                iasNews();
            }


            function iasNews(){
                let ias = jQuery.ias({
                    container:  '#indexNews',
                    item:       '.newsItem',
                    pagination: '#pagination',
                    next:       '.next a'
                });

                let text = $('#indexNews').data('load-more');

                ias.extension(new IASTriggerExtension({
                    html: '<div class="load-more"><div class="load-more-btn"><div class="ico icon-arrow-redo"></div>' + text +'</div></div>' // optionally
                }));

                ias.on('rendered', function(items) {
                    let $items = $(items);
                    $items.addClass('jq_active');
                })
            }
        }

        var scrolled;
        let sp = $(window).height();
        scrolled = window.pageYOffset || document.documentElement.scrollTop;

        window.onscroll = function() {
            scrolled = window.pageYOffset || document.documentElement.scrollTop;
            sp = $(window).height();
            show_jq_hidden();

            if(scrolled > 10){

            }
            if(10 > scrolled){

            }

            w_p = $(window).scrollTop() - 10;
            if ($('.respons__block').length) {
                let b_h = $('.respons__block').outerHeight();
                if (b_h >= w_p) {
                    $('.respons__block').animate({
                        'background-position-x': '50%',
                        'background-position-y': $(window).scrollTop()/3
                    }, 0);
                }
            }
        };

        show_jq_hidden();
        function show_jq_hidden() {
            $('.jq_hidden').each(function(){
                let scroll_pos = window.pageYOffset;
                if ($(this).offset().top < scroll_pos + $(window).height() + 300) {
                    $(this).addClass('jq_active');
                }
                if ($(this).offset().top > scroll_pos + $(window).height() + 300) {
                    $(this).removeClass('jq_active');
                }
            });
        }


    });
})(jQuery);

