$(document).ready(function() {

    $('.ticker').each(function() {
        var $this = $(this);
        var end = $this.data('end')*1000;

        var $days = $this.find('.days span');
        var $hours = $this.find('.hours span');
        var $minutes = $this.find('.minutes span');
        var $seconds = $this.find('.seconds span');

        setInterval(function() {
            var now = new Date().getTime();

            var span = end-now;

            if(span <= 0)
                return;

            var days = Math.floor(span/86400000);
            span = span-days*86400000;

            var hours = Math.floor(span/3600000);
            span = span-hours*3600000;

            var minutes = Math.floor(span/60000);
            span = span-minutes*60000;

            var seconds = Math.floor(span/1000);

            $days.text(days);
            $hours.text(hours);
            $minutes.text(minutes);
            $seconds.text(seconds);
        }, 1000);
    });
    
});