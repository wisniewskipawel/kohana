/**
 * akoCarousel.js
 * 
 * @author	AkoSoft Team <biuro@akosoft.pl>
 * @link		http://www.akosoft.pl
 * @copyright	Copyright (c) 2014, AkoSoft
*/

$.akoCarousel = function(element, options) {

    var defaults = {
          interval: 3000,
          visible_elements: false,
          is_vertical: false
    };

    var plugin = this;

    plugin.settings = {};

    plugin.timer;

    var $slider;
    var item_shift = 0;
    var $items;
    var slider_elements_counter;
    var initialized = false;

    var $element = $(element),
         element = element;

    plugin.init = function() {
        plugin.settings = $.extend({}, defaults, $element.data(), options);

        //start slide
        if($element.is(':visible')) {
            plugin.start();
        }
    }
    
    plugin._initialize = function() {
        
        initialized = true;

        $slider = $element.find('ul');
        $items = $slider.find('li');
        slider_elements_counter = $items.length;

        if(plugin.settings.is_vertical) {
            item_shift = $items.outerHeight(true);
            $element.height(item_shift * plugin.settings.visible_elements);
        } else {
            plugin._recalc_horizontal();
        }

        if(slider_elements_counter <= plugin.settings.visible_elements) {
            if(plugin.settings.is_vertical) {
                $element.height('auto');
                $element.find('.slider-track').height('auto');
                $slider.css('position', 'relative');
            }
        } else {
            if(plugin.settings.is_vertical) {
                $element.css('position', 'relative');
                $slider.css('position', 'absolute');
            }
        }

        $element.find('.slider_nav_next').bind('click', function(e) {
            e.preventDefault();

            plugin.stop();
            plugin.next();
        });

        $element.find('.slider_nav_prev').bind('click', function(e) {
            e.preventDefault();
            
            plugin.stop();
            plugin.prev();
        });
        
        $(window).on('resize', function() {
            plugin.stop();
            plugin._recalc_horizontal();
            plugin.start();
        });
    }
    
    plugin._recalc_horizontal = function() {
        plugin.reset();
        
        var item_width = $items.outerWidth();
        
        $items.css({
            'margin-left': 0,
            'margin-right': 0
        });
        
        var track_width = $element.find('.slider-track').width();
        if(track_width > 0) {
            plugin.settings.visible_elements = Math.floor(track_width/item_width);
            
            if(plugin.settings.visible_elements <= 0) 
                plugin.settings.visible_elements = 1;
        }
        
        var margin_size = (track_width - (plugin.settings.visible_elements * item_width)) / plugin.settings.visible_elements / 2;
        
        if(margin_size > 0) {
            $items.css({
                'margin-left': margin_size,
                'margin-right': margin_size
            });
        }
        
        item_shift = $items.outerWidth(true);
        $slider.width(item_shift * slider_elements_counter);
    }
    
    plugin.start = function(recalc) {
        if(initialized === false) {
            plugin._initialize();
        } else {
            if(recalc) {
                plugin._recalc_horizontal();
            }
        }
        
        plugin.stop();
        
        if(plugin.can_slide_next() && $element.is(':visible'))
        {
            plugin.timer = setTimeout(function() {
                plugin.next();
            }, plugin.settings.interval);
        }
    }

    plugin.stop = function() {
        clearTimeout(plugin.timer);
    }
    
    plugin.can_slide_next = function() {
        if(slider_elements_counter > plugin.settings.visible_elements)
        {
            $element.find('.slider_nav_next, .slider_nav_prev').show();
            return true;
        }
        else
        {
            $element.find('.slider_nav_next, .slider_nav_prev').hide();
            return false;
        }
    }

    plugin.next = function() {
        if(!plugin.can_slide_next())
            return;

        if(plugin.settings.is_vertical) {
            _next_vertical();
        } else {
            _next_horizontal();
        }
    }

    plugin.prev = function() {
        if(slider_elements_counter <= plugin.settings.visible_elements)
            return;

        if(plugin.settings.is_vertical) {
            _prev_vertical();
        } else {
            _prev_horizontal();
        }
    }
    
    plugin.reset = function() {
        if(plugin.settings.is_vertical) {
            $slider.stop(true);
            $slider.css('top', 0);
        } else {
            $slider.stop(true);
            $slider.css('left', 0);
        }
    }

    var _next_horizontal = function () {
        
        $slider.animate({
            left: "-="+item_shift
        }, 500, function() {
            plugin.stop();
            plugin.start();

            $slider.css('left', "+="+item_shift).find('li:first').appendTo($slider);
        });
    }

    var _prev_horizontal = function() {
        $slider.find('li:last').prependTo($slider);
        $slider.css('left', -item_shift+"px");

        $slider.animate({
            left: "0"
        }, 500, function() {
            plugin.stop();
            plugin.start();
        });
    }

    var _prev_vertical = function() {
        $slider.animate({
            top: "-="+item_shift
        }, 500, function() {
            plugin.stop();
            plugin.start();

            $slider.css('top', "+="+item_shift).find('li:first').appendTo($slider);
        });
    }

    var _next_vertical = function() {
        $slider.find('li:last').prependTo($slider);
        $slider.css('top', -item_shift+"px");

        $slider.animate({
            top: "0"
        }, 500, function() {
            plugin.stop();
            plugin.start();
        });
    }

    plugin.init();

}

$.fn.akoCarousel = function(options) {

    return this.each(function() {
        if (undefined == $(this).data('akoCarousel')) {
            var plugin = new $.akoCarousel(this, options);
            $(this).data('akoCarousel', plugin);
        }
    });

}