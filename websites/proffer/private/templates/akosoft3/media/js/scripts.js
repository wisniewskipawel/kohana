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
        
        $('.chars_counter').each(function() {
            var $chars_counter = $(this);
            
            $('#'+$chars_counter.data('target'))
                    .bind('keydown', chars_limiter)
                    .bind('keyup', chars_limiter)
                    .each(chars_limiter);
        
            function chars_limiter(){
                var limitNum = $chars_counter.data('max-chars');
                
                if (this.value.length > limitNum) {
                    this.value = this.value.substring(0, limitNum);
                } else {
                    $chars_counter.find('.counter').text(limitNum - this.value.length);
                }
            }
        });
        
        $('form').on('submit', function(e) {
            var $this = $(this);
            if($this.data('submited')) {
                e.preventDefault();
            } else {
                $this.data('submited', true);
            }
        });

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
    },

    layout          : function() {

        if(jQuery().cssMap) {
            jQuery('#map-poland').cssMap({
                'size'      :'270',
                'cities'    : false
            });

            jQuery("#map-sidebar-pl").cssMap({
                'size'      : '170',
                'cities'    : false
            });
        }
        
        $('.slider').akoCarousel();

        jQuery(".entry_tabs .entry_tabs_headers a").click(function() {
            var $anchor = $(this);
            var $entry_tabs = $anchor.parents(".entry_tabs");
            
            $entry_tabs.find(".entry_tabs_headers").find("li.active").removeClass("active");
            $entry_tabs.find('.container, .entry_tabs_contents').find("div.active").removeClass("active");

            $anchor.parent().addClass("active");
            $entry_tabs.find('.container, .entry_tabs_contents').find($anchor.attr("href")).addClass("active");

            return false;

        });

        //box header tabs

        $(".tabs .tabs-headers a").click(function() {
            var $a = $(this);
            var $tabs_container = $a.parents(".tabs");

            $a.parents('.tabs-headers').find('a.active').removeClass('active');
            $a.addClass('active');
            
            $tabs_container.find(".tabs-wrapper:visible").hide().promise().done(function() {
                $tabs_container.find($a.attr('href')).fadeIn(function() {
                    if($(this).data('akoCarousel')) {
                        $(this).data('akoCarousel').start(true);
                    }
                });
            });

            return false;
        });

        $(".tabs .tabs-headers li:first-child a").trigger('click');

    }

}

jQuery(document).ready(function() {
    main.init();
});
