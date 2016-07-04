(function($) {
"use strict";
			
	//Shortcodes
   tinymce.PluginManager.add( 'zillaShortcodes', function( editor, url ) {
	
	editor.addCommand("zillaPopup", function ( a, params )
	{
		var popup = params.identifier;
		tb_show("Insert DF Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
	});

		editor.addButton( 'zilla_button', {
			type: 'splitbutton',
			icon: false,
			title:  'DF Shortcodes',
			onclick : function(e) {},
			menu: [
				{text: 'Animation',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Animation',identifier: 'animate'})
				}},
				{text: 'Alerts',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Alerts',identifier: 'alert'})
				}},
				{text: 'Columns',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Columns',identifier: 'columns'})
				}},
				{text: 'Columns Inner',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Columns Inner',identifier: 'columns_inner'})
				}},
				{
					text: 'Elements',
					menu: [
						{text: 'Accordion',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Accordion',identifier: 'accordion'})
						}},
						{text: 'Buttons',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Buttons',identifier: 'button'})
						}},
						{text: 'Call to Action',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Call to Action',identifier: 'cta'})
						}},
						{text: 'Circular Bar',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Circular Bar',identifier: 'circular_bar'})
						}},
						{text: 'Counter',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Counter',identifier: 'counter'})
						}},
						{text: 'Tabs',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Tabs',identifier: 'tabs'})
						}},
						{text: 'Partners',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Partners',identifier: 'partners'})
						}},
						{text: 'Pricing Table',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Pricing Table',identifier: 'pricing_table'})
						}},
						{text: 'Progress Bar',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Progress Bar',identifier: 'progress'})
						}},
						{text: 'Section',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Section',identifier: 'section'})
						}},
						{text: 'Table',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Table',identifier: 'table'})
						}},
						{text: 'Team Member',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Team Member',identifier: 'member'})
						}},
						{text: 'Testimonial',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Testimonial',identifier: 'testimonial'})
						}},
					]
				},
				{text: 'Icobox',onclick:function(){
					editor.execCommand("zillaPopup", false, {title: 'Icobox',identifier: 'icobox'})
				}},
				{
					text: 'Typography',
					menu: [
						{text: 'Box',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Box',identifier: 'box'})
						}},
						{text: 'Dropcaps',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Dropcaps',identifier: 'dropcap'})
						}},
						{text: 'Horizontal Rules',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Horizontal Rules',identifier: 'hr'})
						}},
						{text: 'Icon (FontAwesome)',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Icon (FontAwesome)',identifier: 'icon'})
						}},
						{text: 'Icon (Entypo)',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Icon (Entypo)',identifier: 'entypo_icon'})
						}},
						{text: 'Image Raw',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Image Raw',identifier: 'img_raw'})
						}},
						{text: 'Image Box',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Image Box',identifier: 'img_box'})
						}},
						{text: 'Lists',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Lists',identifier: 'list'})
						}},
						{text: 'Pullquote',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Pullquote',identifier: 'pullquote'})
						}},
						{text: 'Spacers',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Spacers',identifier: 'spacer'})
						}},
						{text: 'Title',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Title',identifier: 'title'})
						}},
					]
				},
				{
					text: 'Posts',
					menu: [
						{text: 'Blog Posts',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Blog Posts',identifier: 'posts'})
						}},
						{text: 'Portfolio',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Portfolio Items',identifier: 'portfolio'})
						}},
					]
				},
				{
					text: 'WP Job Manager',
					menu: [
						{text: 'Jobs',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Jobs',identifier: 'jobs'})
						}},
						{text: 'Job Single',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Job',identifier: 'job'})
						}},
						{text: 'Job Summary',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Job Summary',identifier: 'job_summary'})
						}},
						{text: 'Job Submit Form',onclick:function(){
							editor.execCommand("mceInsertContent", false, '[submit_job_form]')
						}},
						{text: 'Job Dashboard',onclick:function(){
							editor.execCommand("mceInsertContent", false, '[job_dashboard]')
						}},
						{text: 'Jobs Slider',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Jobs Slider',identifier: 'jobs_slider'})
						}},
						{text: 'Jobs Feed',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Jobs Feed',identifier: 'jobs_feed'})
						}},
						{text: 'Jobs Carousel',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Jobs Carousel',identifier: 'jobs_carousel'})
						}},
						{text: 'Counter Stats',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Counter Stats',identifier: 'counter_stats'})
						}},
						{text: 'Resumes',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Resumes',identifier: 'resumes'})
						}},
						{text: 'Resume Summary',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Resume Summary',identifier: 'resume_summary'})
						}},
						{text: 'Resume Submit Form',onclick:function(){
							editor.execCommand("mceInsertContent", false, '[submit_resume_form]')
						}},
						{text: 'Resumes Slider',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Resumes Slider',identifier: 'resumes_slider'})
						}},
						{text: 'Resumes Feed',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Resumes Feed',identifier: 'resumes_feed'})
						}},
						{text: 'Resumes Carousel',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Resumes Carousel',identifier: 'resumes_carousel'})
						}},
						{text: 'Candidate Dashboard',onclick:function(){
							editor.execCommand("mceInsertContent", false, '[candidate_dashboard]')
						}},
						{text: 'Summaries Slider',onclick:function(){
							editor.execCommand("zillaPopup", false, {title: 'Summaries Slider',identifier: 'summaries'})
						}},
					]
				},
			]
	});

 });
         

 
})(jQuery);
