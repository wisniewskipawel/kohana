var catalog = {
        
        init    : function() {
            
            catalog.forms.init();
            catalog.gallery();
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

        show_map_list : function($entry) {
            var $map = $entry.find('.map');
            
            if($map.data('lat') && $map.data('lng')) {
                 show_map($map, new google.maps.LatLng($map.data('lat'), $map.data('lng')));
            } else {
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({address: $entry.find('.company_street').text().trim()+', '+$entry.find('.company_city').text().trim()}, function(results, status) {
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
                
                $('.ajax_orm_categories').on('change', 'select', function() {

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