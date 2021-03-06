 var products = {

        init            : function() {

            products.forms();
            products.gallery();

            if (window.location.hash == '#print') {
                window.print();
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

            // products/add

            jQuery("select#product-person-type").change(function() {
                var $select;
                $select = jQuery(this);

                if ($select.val() === "person") {
                    $select.parent().next().find("label").html("Osoba <span>*</span>");
                } else if ($select.val() === "company") {
                    $select.parent().next().find("label").html("Firma <span>*</span>");
                }
            });

            // products/add

            jQuery('#product-categories').on('change', 'select', function() {
                var $select = jQuery(this);
                var $container = $select.parents('#product-categories');
                var parent_category_id = $select.val();
                var $form = $container.parents('form');
                var $attributes = $form.find('#attributes_fields').hide();
                var $product_state = $form.find('.product_state_placeholder').hide();
                
                if(!parent_category_id) {
                    return;
                }

                jQuery.ajax({
                    url: base_url + 'ajax/products/on_category_change',
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
                            $product_state.html(data.product_state).show();
                        }
                    }
                });
            });

        }

};

jQuery(document).ready(function() {
    products.init();
});