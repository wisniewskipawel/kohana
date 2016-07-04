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

    $("#company_gallery .gallery_images_list").on('click', 'a', function(e) {
        e.preventDefault();

        var $anchor = $(this);
        var $image = $anchor.find('img');

        if ($image.hasClass("active")) { return; }

        var url = $image.data('showbig');
        var $wrap = $("#company_gallery .big_image");

        var img = new Image();
        img.onload = function() {
            $wrap.find("img").attr("src", url);
        };

        img.src = url;

        var $a;
        $a = $wrap.find("a");
        $a.attr("href", this.href);
        
        $("#company_gallery .gallery_images_list li").removeClass("active");
        $image.parents('li').addClass("active");
    });
    
    $("#company_gallery .gallery_images_list li:first-child").addClass("active");

    $("#company_gallery .big_image").on('click', 'a', function(e) {
        e.preventDefault();

        var images_list = [];

        $("#company_gallery .gallery_images_list a").each(function() {
            images_list.push(this.href);
        });

        var photo_index = $("#company_gallery .gallery_images_list li")
                .index($("#company_gallery .gallery_images_list li.active"));

        $.fancybox(images_list, {
            'padding'		: 0,
            'transitionIn'	: 'none',
            'transitionOut'	: 'none',
            'type'              : 'image',
            'changeFade'        : 0,
            'index'             : photo_index
        });

        return false;
    });
    
});

