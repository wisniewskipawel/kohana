var catalog = {
        
        init    : function() {
            
            catalog.forms.init();
            catalog.gallery();
        },

        gallery         : function() {

            jQuery("div#announcement-photos div.slider").scrollable();

            jQuery("div.slider-gallery div.items a").click(function(e) {
                e.preventDefault();

                var $anchor = jQuery(this);
                var $image = $anchor.find('img');

                if ($image.hasClass("active")) { return; }

                var url = $anchor.data('big_thumb');
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

        show_map_list : function($entry) {
            var $map = $entry.find('.map');
            
            if($map.data('lat') && $map.data('lng')) {
                 show_map($map, new google.maps.LatLng($map.data('lat'), $map.data('lng')));
            } else {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({address: $map.data('geocoder')}, function(results, status) {
                    if(status == google.maps.GeocoderStatus.OK) {
                        show_map($map, results[0].geometry.location);
                    } else {
                        alert('Brak mapy dla tego wpisu.')
                    }
                });
            }
            
            function show_map($map, point) {
                    $map.show();

                    var map_options = {
                    zoom: 14,
                    center: point,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    var mapa = new google.maps.Map($map.get(0), map_options); 

                    var marker_options =
                    {
                        position: point,
                        map: mapa,
                        title: $entry.find('.company_name').text().trim()
                    }
                    var marker = new google.maps.Marker(marker_options);
                    
                    var $a = $entry.find('.show_map_btn');
                    var toggle_label = $a.text();
                    $a.text($a.data('toggle-label')).data('toggle-label', toggle_label);
            }
        },

        hide_map : function($entry)
        {
            var $a = $entry.find('.show_map_btn');
            var toggle_label = $a.text();
            $a.text($a.data('toggle-label')).data('toggle-label', toggle_label);
            
            $entry.find('.map').hide();
        },
        
        forms   : {
            
             load_catalog_categories : function(category_id, select_nb) {
                if ( ! category_id) {
                    category_id = -1;
                }
                jQuery.ajax({
                    url: base_url + 'ajax/catalog/get_selects/' + category_id + '/' + select_nb,
                    success: function(data) {
                        var $row = jQuery('select[name="category\['+ select_nb +'\]"]').parent();
                        if (data.length) {
                            $row.html(data);
                        }
                    }
                });
            },
            
            init : function() {
                
                jQuery('.ajax_orm_categories').on('change', 'select',function() {

                    var $select = jQuery(this);
                    var category_id = $select.val();

                    if ( ! category_id) {
                        category_id = -1;
                    }

                    var name = $select.parent().find('select[name^="category"]').attr('name');
                    
                    $select.attr('name', name);
                    
                    $select.nextAll().remove();
                    
                    jQuery.ajax({
                        url: base_url + 'ajax/catalog/get_subcategories_many',
                        data: {
                            'category_id': category_id
                        },
                        success: function(data) {
                            if (data.length) {
                                $select
                                    .after($(data).find('select').attr('name', name))
                                    .removeAttr('name');
                            }
                        }
                    });

                });
                
                jQuery("a#category-select-all").click(function() {

                    var values = [];
                    var $select = jQuery("select#bform-data-users-data-notification-category-id-");

                    $select.find("option").each(function() {

                        if (jQuery(this).val()) {
                            values.push(jQuery(this).val());
                        }

                    });

                    $select.val(values);

                    return false;
                });

            }
        }
};

jQuery(document).ready(function() {
    catalog.init();
});