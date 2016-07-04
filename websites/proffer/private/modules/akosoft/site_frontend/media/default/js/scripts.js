var main = {

    init            : function() {

        main.layout();
        main.forms();
        
        $(document).on('click', '.ajax_curtain', function(e) {
            e.preventDefault();
            var $anchor = $(this);
            
            $.ajax({
                url: this.href,
                success: function(data) {
                    $anchor.replaceWith(data);
                }
            });
        });
        
        $(document).on('click', 'a.confirm', function(e) {
            if(!confirm($(this).attr('title')))
            {
                e.preventDefault();
            }
        });
        
        $('.toggle_visability_box .toggle_visability_btn').bind('click', function(e) {
            e.preventDefault();
            
            var $anchor = $(this).fadeOut();
            var $container = $anchor.parents('.toggle_visability_box');
            var $target = $container.find('.toggle_visability_target');
            
            if($target.is(':visible')) {
                $target.slideUp(500,  function() {
                    toggle_text_btn();
                    toggle_container_cls();
                });
                setCookie('filters_bar', 0, 1);
            } else {
                $target.slideDown(500, function() {
                    toggle_text_btn();
                    toggle_container_cls();
                });
                setCookie('filters_bar', 1, 1);
            }
            
            function toggle_container_cls() {
                if($container.is('.expanded')) {
                    $container.removeClass('expanded').addClass('collapsed');
                } else {
                    $container.removeClass('collapsed').addClass('expanded');
                }
            }
            
            function toggle_text_btn() {
                var toggle_text = $anchor.data('toggle-text');
                $anchor.data('toggle-text', $anchor.text()).text(toggle_text).fadeIn();
            }
            
            function setCookie(c_name,value,exdays) {
                var exdate=new Date();
                exdate.setDate(exdate.getDate() + exdays);
                var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
                document.cookie=c_name + "=" + c_value;
            }
            
        }).show();
        
        $(".lightbox_photo").on('click', function(e) {
            e.preventDefault();

            $.fancybox(this.href, {
                'padding'			: 0,
                'transitionIn'		: 'none',
                'transitionOut'		: 'none',
                'type'              : 'image',
                'changeFade'        : 0,
            });
        });
        
        $('.show_dialog_btn').on('click', function(e) {
            e.preventDefault();
            
            var $dialog_btn = $(this);
            var $target = $dialog_btn.data('target-contents');
            var target_selector = $dialog_btn.data('dialog-target');
            
            if(!$target && target_selector) {
                $target = $(target_selector);
            }
            
            if($target) {
                
                var $dialog = $target.remove().wrap('<div>').parent();
                $target.removeClass('hidden').show();
                
                $.fancybox(
                    $dialog.html(),
                    {
                        'autoDimensions': true,
                        'transitionIn'	: 'none',
                        'transitionOut' : 'none',
                        'padding'	: 0,
                        'onComplete'    : function() {
                            $target = $(target_selector);
                            
                            $target.trigger('dialog.showed', [$dialog_btn, $dialog, $target]);
                            $dialog_btn.data('target-contents', $target);
                        },
                        'onCleanup'     : function() {
                            $target = $(target_selector);
                            
                            $target.trigger('dialog.closing', [$dialog_btn, $dialog, $target]);
                            $dialog_btn.data('target-contents', $target);
                        }
                    }
                );
            }
        });

    },

    payment: {
        get_info: function (success_callback, provider, module, place, type, text_type, discount) {
            $.ajax({
                url     : base_url + 'ajax/payment/get_payment_info',
                data    : {
                    provider: provider,
                    payment_module: module,
                    place: place,
                    type: type,
                    text_type: text_type,
                    discount: discount
                },
                success : success_callback
            });
        }
    },

    forms           : function() {

        /*
         * Clear a input on focus
         */

        $('.clear-on-focus').each(function() {
           var $input = $(this);
           if($input.val() == '') {
               if($input.attr('type') == 'password'){
                   $input.after($('<input type="text" value="'+$input.attr('title')+'" class="input_placeholder" />').focus(function(){
                       $(this).hide();
                       $input.show().focus();
                   }));
                   $input.hide();
               } else {
                   $input.val($input.attr('title'));
               }
           }
        })
        .focus(function() {
           if($(this).val() == $(this).attr('title')) {
               $(this).val('');
           }
        })
        .blur(function() {
           var $input = $(this);
           if($input.val() == '') {
               if($input.attr('type') == 'password'){
                   $input.hide().next('.input_placeholder').show();
               } else {
                   $input.val($input.attr('title'));
               }
           }
        })
        .parents('form').bind('submit', function() {    //clear all input placeholders before submit
           var $form = $(this);

           $form.find('.clear-on-focus').each(function() {
               var $input = $(this);
               if($input.val() == $input.attr('title')) {
                   $input.val('');
               }
           });
        });

        jQuery("select.custom").customSelect();

        $('select.provinces').bind('change', function() {
            var $province = $(this);

            var $counties = $province.parents('form, .bform').find('select.counties');

            if($counties.hasClass('required')) {
                $counties.empty();
            } else {
                $counties.find('option:not([value=""])').remove();
            }

            if(!$province.val()) {
                return;
            }

            $.ajax({
                'url': base_url + 'ajax/regions/counties',
                'data': {
                    'province_id': $province.val()
                },
                'dataType': 'json',
                'success': function(json) {
                    if(json) {
                        for(var i in json) {
                            $counties.append('<option value="'+json[i]['id']+'">'+json[i]['name']+'</option>');
                        }
                    }
                }
            });
        });
        
        $('.auto_submit_form').on('change', 'select, input[type="checkbox"], input[type="radio"]', function() {
            $(this).parents('form').submit();
        });
        
        $(document).on('keydown, keyup', '.chars_counter_input', chars_limiter);
        $('.chars_counter_input').each(chars_limiter);
        
        function chars_limiter(){
            var $input = $(this);
            var $chars_counter = $input.parents('form').find('.chars_counter[data-target="'+$input.attr('id')+'"]').show();

            if($chars_counter.length) {
                var limitNum = $chars_counter.data('max-chars');

                if (this.value.length > limitNum) {
                    this.value = this.value.substring(0, limitNum);
                } else {
                    $chars_counter.find('.counter').text(limitNum - this.value.length);
                }
            }
        }
        
        $('form').on('submit', function(e) {
            var $this = $(this);
            if($this.data('submited')) {
                e.preventDefault();
            } else {
                $this.data('submited', true);
            }
        });
    },

    layout          : function() {

        if(jQuery().cssMap) {
            jQuery('#map-pl').cssMap({
                'size'      :'240',
                'cities'    : false
            });

            jQuery("#map-sidebar-pl").cssMap({
                'size'      : '170',
                'cities'    : false
            });
        }
        
        if(jQuery().akoCarousel) {
            jQuery(".slider").akoCarousel();
        }

        jQuery(".entry_tabs .entry_tabs_headers").on('click', 'a', function() {
            var $anchor = $(this);
            var $entry_tabs = $anchor.parents(".entry_tabs");
            
            $entry_tabs.find(".entry_tabs_headers").find("li.active").removeClass("active");
            $entry_tabs.find('.container, .entry_tabs_contents').find("div.active").removeClass("active");

            $anchor.parent().addClass("active");
            $entry_tabs.find('.container, .entry_tabs_contents').find($anchor.attr("href")).addClass("active");

            return false;
        }).each(function() {
            var $tab_headers = $(this);
            if(!$tab_headers.find('.active').length) {
                $tab_headers.find('a').first().trigger('click');
            }
        });

        //box header tabs

        jQuery(".box-header .box-actions a").click(function() {
            var $a = jQuery(this);
            var $box = $a.parents(".box");
            $a.parent().find("h2").text($a.text());

            $a.parents('.box-actions').find('a.active').removeClass('active');
            $a.addClass('active');
            
            $box.find("div.tabs-wrapper:visible").fadeOut('slow').promise().done(function() {
                $box.find($a.attr('href')).fadeIn(function() {
                    if($(this).data('akoCarousel')) {
                        $(this).data('akoCarousel').start();
                    }
                });
            });

            $box.find('.more_btn').attr("href", $a.attr("title"));

            return false;
        });

        jQuery(".box-header .box-actions li:first-child a").trigger('click');
        
        main.categories();

    },

    categories      : function() {

        // index categories expander

        jQuery("div.box.categories div.row div.category a.more").click(function() {
            var $ul, $a;
            $a = jQuery(this);
            $ul = jQuery(this).parent().find("ul");

            if(!$a.hasClass('active')) {
                $ul.find("li").removeClass("last").show();
                $ul.find("li:last").addClass("last");

                $a.addClass('active');
            } else {
                $ul.find("li:gt(4)").hide().last().addClass("last");
                $(window).scrollTop($ul.prev().offset().top);

                $a.removeClass('active');
            }

            var toggle_text = $a.text();
            $a.text($a.data('toggle-text'));
            $a.data('toggle-text', toggle_text);

            main.recalculate_row_heights();
            return false;
        });
    },

    recalculate_row_heights     : function() {

        // index categories boxes height fixer

        var i = 0;
        var heights = [];
        var max = 0;
        var $current_category_box = null;
        jQuery("div.box.categories div.row div.category").each(function() {
            if (i % 3 == 0) {
                heights = [];
            }
            $current_category_box = jQuery(this);
            $current_category_box.height("auto");
            heights.push($current_category_box.height());
            if (i % 3 == 2) {
                max = Math.max.apply(null, heights);
                $current_category_box.height(max);
                $current_category_box.prev().height(max);
                $current_category_box.prev().prev().height(max);
            }
            i++;
        });
    },

    generate_password   : function()
    {
        jQuery.ajax({
            url: base_url + '/ajax/auth/generate_password',
            success: function(data) {
                jQuery('.password').val(data);
                jQuery('.generated-password').show().find("span").html(data);
            }
        });
    }

}

jQuery(document).ready(function() {
    main.init();
});
