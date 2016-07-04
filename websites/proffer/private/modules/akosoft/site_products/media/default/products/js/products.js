 var products = {

        init            : function() {

            products.forms();
            products.gallery();

            if (window.location.hash == '#print') {
                window.print();
            }
        },

        gallery         : function() {

            jQuery("div#product-photos div.slider").scrollable();

            jQuery("div.slider-gallery div.items a").click(function(e) {
                e.preventDefault();

                var $anchor = jQuery(this);
                var $image = $anchor.find('img');

                if ($image.hasClass("active")) { return; }

                var url = $image.data('showbig');
                var $wrap = jQuery("div.slider-gallery div.big-photo");//.fadeTo("medium", 0.5);

                var img = new Image();
                img.onload = function() {
                    //$wrap.fadeTo("fast", 1);
                    $wrap.find("img").attr("src", url);
                };

                img.src = url;

                var $a;
                $a = $wrap.find("a");
                $a.attr("href", this.href);

                // activate item
                jQuery("div.slider-gallery div.items img").removeClass("active");
                $image.addClass("active");

            // when page loads simulate a "click" on the first image
            }).filter(":first").click();

            $(".slider-gallery").on('click', 'a.photo_big', function(e) {
                e.preventDefault();
                
                var images_list = [];

                jQuery("div.slider-gallery div.items a.slide_photo").each(function() {
                    images_list.push(this.href);
                });

                var photo_index = jQuery("div.slider-gallery div.items img.active").parent().prevAll().length;

                jQuery.fancybox(images_list, {
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