(function ()
{
	// create zillaShortcodes plugin
	tinymce.create("tinymce.plugins.zillaShortcodes",
	{
		init: function ( ed, url )
		{
			ed.addCommand("zillaPopup", function ( a, params )
			{
				var popup = params.identifier;
				
				// load thickbox
				tb_show("Insert Zilla Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
			});
		},
		createControl: function ( btn, e )
		{
			if ( btn == "zilla_button" )
			{	
				var a = this;
				
				var btn = e.createSplitButton('zilla_button', {
					title: "Insert Zilla Shortcode",
					image: ZillaShortcodes.plugin_folder +"/tinymce/images/icon.png",
					icons: false
            });

               btn.onRenderMenu.add(function (c, b)
				{	
					a.addWithPopup( b, "Animation", "animate" );
					a.addWithPopup( b, "Columns", "columns" );
					a.addWithPopup( b, "Columns Inner", "columns_inner" );
					a.addWithPopup( b, "Buttons", "button" );
					a.addWithPopup( b, "Table", "table" );
					a.addWithPopup( b, "Dropcaps", "dropcap" );
					a.addWithPopup( b, "Pullquote", "pullquote" );
					a.addWithPopup( b, "Horizontal Rule", "hr" );
					a.addWithPopup( b, "Spacer", "spacer" );
					a.addWithPopup( b, "Alerts", "alert" );
					a.addWithPopup( b, "List", "list" );
					a.addWithPopup( b, "Icon FontAwesom", "icon" );
					a.addWithPopup( b, "Icon Entypo", "entypo_icon" );
					a.addWithPopup( b, "Image Raw", "img_raw" );
					a.addWithPopup( b, "Image Box", "img_box" );
					a.addWithPopup( b, "Icobox", "icobox" );
					a.addWithPopup( b, "Box", "box" );
					a.addWithPopup( b, "Section", "section" );
					a.addWithPopup( b, "Call to Action", "cta" );
					a.addWithPopup( b, "Tabs", "tabs" );
					a.addWithPopup( b, "Partners", "partners" );
					a.addWithPopup( b, "Pricing Tables", "pricing_table" );
					a.addWithPopup( b, "Accordion", "accordion" );
					a.addWithPopup( b, "Progress Bar", "progress" );
					a.addWithPopup( b, "Testimonial", "testimonial" );
					a.addWithPopup( b, "Team Member", "member" );
					a.addWithPopup( b, "Blog Posts", "posts" );
					a.addWithPopup( b, "Portfolio Items", "portfolio" );
					a.addWithPopup( b, "Jobs", "jobs" );
					a.addWithPopup( b, "Job", "job" );
					a.addWithPopup( b, "Job Summary", "job_summary" );
					a.addWithPopup( b, "Job Submit Form", "submit_job_form" );
					a.addWithPopup( b, "Job Dashboard", "job_dashboard" );
					a.addWithPopup( b, "Resumes", "resumes" );
					a.addWithPopup( b, "Resume Summary", "resume_summary" );
					a.addWithPopup( b, "Resume Submit Form", "submit_resume_form" );
					a.addWithPopup( b, "Candidate Dashboard", "candidate_dashboard" );
				});
                
        return btn;
			}
			
			return null;
		},
		addWithPopup: function ( ed, title, id ) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand("zillaPopup", false, {
						title: title,
						identifier: id
					})
				}
			})
		},
		addImmediate: function ( ed, title, sc) {
			ed.add({
				title: title,
				onclick: function () {
					tinyMCE.activeEditor.execCommand( "mceInsertContent", false, sc )
				}
			})
		},
		getInfo: function () {
			return {
				longname: 'Zilla Shortcodes',
				author: 'Orman Clark',
				authorurl: 'http://themeforest.net/user/ormanclark/',
				infourl: 'http://wiki.moxiecode.com/',
				version: "1.0"
			}
		}
	});
	
	// add zillaShortcodes plugin
	tinymce.PluginManager.add("zillaShortcodes", tinymce.plugins.zillaShortcodes);
})();