$(document).ready(function() {
    
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
    
});

