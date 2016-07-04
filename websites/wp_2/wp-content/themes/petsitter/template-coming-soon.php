<?php /* Template Name: Coming Soon */ ?>

<?php get_header(); ?>

<?php global $petsitter_data; 
$color_primary = $petsitter_data['theme-color1']; ?>

<?php
// Fetch and explode our date variable
$date_var = $petsitter_data['petsitter__coming-soon-date'];
list($month, $day, $year) = explode("/", $date_var);

if ( $month == '01') {
	$month = 'January';
} elseif ($month == '02') {
	$month = 'February';
} elseif ($month == '03') {
	$month = 'March';
} elseif ($month == '04') {
	$month = 'April';
} elseif ($month == '05') {
	$month = 'May';
} elseif ($month == '06') {
	$month = 'June';
} elseif ($month == '07') {
	$month = 'July';
} elseif ($month == '08') {
	$month = 'August';
} elseif ($month == '09') {
	$month = 'September';
} elseif ($month == '10') {
	$month = 'October';
} elseif ($month == '11') {
	$month = 'November';
} elseif ($month == '12') {
	$month = 'December';
}
?>

<div class="page-content">
	<div class="container">

		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center">
				<h1><?php echo $petsitter_data['petsitter__coming-soon-page-title']; ?></h1>
				<?php echo $petsitter_data['petsitter__coming-soon-description']; ?>
			</div>
		</div>

		<div id="countdown" class="countdown text-center">
			<div class="row">
				<div class="col-sm-3 col-md-3 col-lg-offset-2 col-lg-2 text-center">
					<input class="knob" id="days" data-readonly=true data-min="0" data-max="99" data-skin="tron" data-width="165" data-height="165" data-thickness="0.2" data-fgcolor="<?php echo $color_primary; ?>">
					<span class="count-label"><?php _e('days', 'petsitter'); ?></span>
				</div>
				
				<div class="col-sm-3 col-md-3 col-lg-2">
					<input class="knob" id="hours" data-readonly=true data-min="0" data-max="24" data-skin="tron" data-width="165" data-height="165" data-thickness="0.2" data-fgcolor="<?php echo $color_primary; ?>">
					<span class="count-label"><?php _e('hours', 'petsitter'); ?></span>
				</div>
				
				<div class="col-sm-3 col-md-3 col-lg-2">
					<input class="knob" id="mins" data-readonly=true data-min="0" data-max="60" data-skin="tron" data-width="165" data-height="165" data-thickness="0.2" data-fgcolor="<?php echo $color_primary; ?>">
					<span class="count-label"><?php _e('minutes', 'petsitter'); ?></span>
				</div>
				
				<div class="col-sm-3 col-md-3 col-lg-2">
					<input class="knob" id="secs" data-readonly=true data-min="0" data-max="60" data-skin="tron" data-width="165" data-height="165" data-thickness="0.2" data-fgcolor="<?php echo $color_primary; ?>">
					<span class="count-label"><?php _e('seconds', 'petsitter'); ?></span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<hr class="lg">
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<?php echo do_shortcode( $petsitter_data['petsitter__coming-soon-contact-form']); ?>
			</div>
		</div>

	</div>
</div>

<script>
 jQuery(function(){

  	// Put your date in the next format
  	jQuery('#countdown').countdown( { date: "<?php echo $day; ?> <?php echo $month; ?> <?php echo $year; ?> 00:00:00" } );

      jQuery(".knob").knob({
          change : function (value) {
              //console.log("change : " + value);
          },
          release : function (value) {
              //console.log(this.$.attr('value'));
              console.log("release : " + value);
          },
          cancel : function () {
              console.log("cancel : ", this);
          },
          draw : function () {

              // "tron" case
              if(this.$.data('skin') == 'tron') {

                  var a = this.angle(this.cv)  // Angle
                      , sa = this.startAngle   // Previous start angle
                      , sat = this.startAngle  // Start angle
                      , ea                     // Previous end angle
                      , eat = sat + a          // End angle
                      , r = 1;

                  this.g.lineWidth = this.lineWidth;

                  this.o.cursor
                      && (sat = eat - 0.3)
                      && (eat = eat + 0.3);

                  if (this.o.displayPrevious) {
                      ea = this.startAngle + this.angle(this.v);
                      this.o.cursor
                          && (sa = ea - 0.3)
                          && (ea = ea + 0.3);
                      this.g.beginPath();
                      this.g.strokeStyle = this.pColor;
                      this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                      this.g.stroke();
                  }

                  this.g.beginPath();
                  this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                  this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                  this.g.stroke();

                  this.g.lineWidth = 2;
                  this.g.beginPath();
                  this.g.strokeStyle = this.o.fgColor;
                  this.g.arc( this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                  this.g.stroke();

                  return false;
              }
          }
      });

      // Example of infinite knob, iPod click wheel
      var v, up=0,down=0,i=0
        ,$idir = jQuery("div.idir")
        ,$ival = jQuery("div.ival")
        ,incr = function() { i++; $idir.show().html("+").fadeOut(); $ival.html(i); }
        ,decr = function() { i--; $idir.show().html("-").fadeOut(); $ival.html(i); };
        jQuery("input.infinite").knob( {
          min : 0
          , max : 20
          , stopper : false
          , change : function () {
            if(v > this.cv){
              if(up){
                  decr();
                  up=0;
              }else{up=1;down=0;}
            } else {
              if(v < this.cv){
                if(down){
                    incr();
                    down=0;
                }else{down=1;up=0;}
              }
            }
            v = this.cv;
          }
    });
  });
</script>

<?php get_footer(); ?>