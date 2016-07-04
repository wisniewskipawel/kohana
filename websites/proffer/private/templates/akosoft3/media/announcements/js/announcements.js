 var announcements = {

        init            : function() {

            announcements.forms();
            announcements.gallery();

            if (window.location.hash == '#print') {
                window.print();
            }

            //comments

            $('.comments_list.list_thread .subcomments').each(function() {
                var $subcomments = $(this);
                var $li = $subcomments.parent();

                $li.append('<a hreh="#" class="expand_comment">[+]</a>');

                $subcomments.hide();
            });

            $('.comments > .comments_list.list_thread').on('click', '.expand_comment', function(e) {
                e.preventDefault();

                var $a = $(this);

                if($a.hasClass('expanded')) {
                    $a.text('[+]').removeClass('expanded');
                } else {
                    $a.text('[-]').addClass('expanded');
                }

                $a.parent().children('.subcomments').fadeToggle();
            });

            $('.comments > .comments_list').on('click', '.add_reply', function(e) {
                e.preventDefault();

                var $a = $(this);
                var $comment = $a.parents('.comment');
                var $form = $comment.find('.add_reply_form');

                if($form.length) {

                    toggle_text($a);
                    $form.fadeToggle();

                } else {

                    $.ajax({
                        url: this.href,
                        success: function(data) {
                            $comment.append(data);
                            toggle_text($a);
                        }
                    });

                }
            });

            $('.comments .add_comment_cbox:not(:has(.errors))').hide();

            $('.comments .add_comment_btn').bind('click', function(e) {
                e.preventDefault();

                var $a = $(this);
                var $add_comment = $('.comments .add_comment_cbox');

                $('.comments .add_comment_btn').show();

                $a.after($add_comment).hide();
                $add_comment.fadeIn();
            });

             $('.comments .hide_add_comment_btn').bind('click', function(e) {
                e.preventDefault();

                $('.comments .add_comment_cbox').fadeToggle();
                $(this).parents('.add_comment_container').find('.add_comment_btn').show();
             });
             
             if($('.add_comment_cbox:has(.errors)').length) {
                  $('.comments .add_comment_btn').trigger('click');
                  $(window).scrollTop($('.add_comment_cbox:has(.errors)').offset().top);
             }

            function toggle_text($a) {
                var text = $a.text();
                $a.text($a.data('toggle-text')).data('toggle-text', text);
            }
        },

        gallery         : function() {
            $("#slider-gallery .slider-track").on('click', 'a', function() {
                var current = $(this);
                
                var images_list = [];

                $("#slider-gallery .slider-track a").each(function() {
                    images_list.push(this.href);
                });

                var photo_index = $("#slider-gallery .slider-track a").index(current);

                $.fancybox(images_list, {
                    'padding'			: 0,
                    'transitionIn'		: 'none',
                    'transitionOut'		: 'none',
                    'type'              : 'image',
                    'changeFade'        : 0,
                    'index'             : photo_index
                });

                return false;
            });
        },

        forms           : function() {

            // announcements/add

            jQuery("select#annoucement-person-type").change(function() {
                var $select;
                $select = jQuery(this);

                if ($select.val() === "person") {
                    $select.parent().next().find("label").html("Osoba <span>*</span>");
                } else if ($select.val() === "company") {
                    $select.parent().next().find("label").html("Firma <span>*</span>");
                }
            });

            // announcements/add

            jQuery('#announcement-categories').on('change', 'select', function() {
                var $select = jQuery(this);
                var $container = $select.parents('#announcement-categories');
                var parent_category_id = $select.val();
                var $form = $container.parents('form');
                var $attributes = $form.find('#attributes_fields').hide();
                var $product_state_placeholder = $form.find('.collection_product_state').empty();
                var $price_placeholder = $form.find('.collection_price').empty();
                
                if(!parent_category_id) {
                    return;
                }

                jQuery.ajax({
                    url: base_url + 'ajax/announcements/on_category_change',
                    data: {
                        category_id: parent_category_id,
                        form_id: $form.find('[name=form_id]').val()
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.categories) {
                            $container.html(data.categories);
                        }

                        if(data.attributes) {
                            $attributes.html(data.attributes).show();
                        }
                        
                        if(data.product_state) {
                            $product_state_placeholder.replaceWith(data.product_state).show();
                        }
                        
                        if(data.price) {
                            $price_placeholder.replaceWith(data.price).show();
                        }
                    }
                });
            });

        }

};

jQuery(document).ready(function() {
    announcements.init();
});