equalheight = function(container){

var currentTallest = 0,
    currentRowStart = 0,
    rowDivs = new Array(),
    $el,
    topPosition = 0;
    
    $(container).each(function() {
        $el = $(this);
        $($el).height('auto')
        topPostion = $el.position().top;

        if (currentRowStart != topPostion) {
          for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            rowDivs[currentDiv].height(currentTallest);
          }
          rowDivs.length = 0; // empty the array
          currentRowStart = topPostion;
          currentTallest = $el.height();
          rowDivs.push($el);
        } else {
          rowDivs.push($el);
          currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
        }

        for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
          rowDivs[currentDiv].height(currentTallest);
        }
    });
}

$(window).on('load resize', function() {
    equalheight('.categories_grid .category');
});

$(function() {
    
    $(".categories_grid .show_more_btn").on('click', function(e) {
        e.preventDefault();

        var $ul, $a;
        $a = $(this);
        $ul = $a.parents('.category').find(".subcategories");

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

        equalheight('.categories_grid .category');
    });

});