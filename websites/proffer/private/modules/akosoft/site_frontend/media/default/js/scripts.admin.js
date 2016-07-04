var main = {
    
    init : function()
    {
        if (typeof base_url === 'undefined')
        {
            alert('Set a base url first!');
        }
        
        main.layout();
        main.forms();
        main.dialogs.init();
        main.documents.init();
        main.announcements.init();
        
        $('.editor_placeholders a').bind('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            var $placeholders = $this.parents('.editor_placeholders');

            var editor = CKEDITOR.instances[$placeholders.data('editor-id')];

            if (editor.mode == 'wysiwyg') {
                editor.insertText($this.text());
            } else {
                alert('You must be in WYSIWYG mode!');
            }
        });
        
        $('.chars_counter').each(function() {
            var $chars_counter = $(this);
            
            $('#'+$chars_counter.data('target'))
                    .bind('keydown', chars_limiter)
                    .bind('keyup', chars_limiter)
                    .each(chars_limiter);
        
            function chars_limiter(){
                var limitNum = $chars_counter.data('max-chars');
                
                if (this.value.length > limitNum) {
                    this.value = this.value.substring(0, limitNum);
                } else {
                    $chars_counter.find('.counter').text(limitNum - this.value.length);
                }
            }
        });
        
    },
    
    announcements :{ 
    
        init : function()
        {
            
            
            
        }
    
    },
    
    documents : {
        
        init : function()
        {
            jQuery('select#select-url-type').change(function()
            {
                if (jQuery(this).val() == 'manual')
                {
                    jQuery.ajax({
                            url             : base_url + 'ajax/documents/get_url_input/' + jQuery('#bform-document-title').val(),
                            success         : function(data)
                            {
                                if (data.length)
                                {
                                    if ( ! jQuery('#my-document-url').length)
                                    {
                                        jQuery('#select-url-type-row').append(data);
                                    }
                                }
                            }
                    });
                }
                else
                {
                    jQuery('#my-document-url').remove();
                }
            });
        }
        
    },
    
    auth     : {
        
        generate_password   : function()
        {
            $('.password').val(Math.random().toString(36).substr(2, 8));
        }
        
    },
    
    layout      : function() {
        
            // wysuwa podmenu
        jQuery('div#sidebar ul li a').click(function() {
            if (jQuery(this).parent().find('ul:first').length > 0 && ! jQuery(this).parent().find("ul:first").is(":visible")) {
                jQuery(this).parent().find('ul:first').stop(false, true).slideDown('fast');
                return false;
            } else if (jQuery(this).parent().find("ul:first").length > 0 && jQuery(this).parent().find("ul:first").is(":visible")) {
                jQuery(this).parent().find("ul:first").stop(false, true).slideUp("fast");
                return false;
            }
            return true;
        });

        // podswietla aktywne menu i rodzicow
        jQuery('div#sidebar ul li a').hover(function() {
            jQuery(this).parentsUntil('div').filter('li').each(function() {
                jQuery(this).find('a:first').addClass('active').parent().addClass('active');
            });
        }, function() {
            jQuery(this).parentsUntil('div').filter('li').each(function() {
                var $a = jQuery(this).find('a:first');
                if ( ! $a.hasClass('current')) {
                    $a.removeClass('active').parent().removeClass('active');
                }
            });
        });

        // zaznacza aktywne menu i rodzicow
        var uri;
        for (uri in uris) {
            var tmp_uri = uris[uri];
            jQuery("div#sidebar ul li a").each(function() {
                var href = jQuery(this).attr('href');
                if (href == tmp_uri) {
                    jQuery(this).addClass('active').parentsUntil('div').filter('li').each(function() { // li
                        jQuery(this).find('a:first').addClass('active').addClass('current'); // a
                        jQuery(this).addClass('active').addClass('current'); // li
                        jQuery(this).find('ul:first').show();
                    });
                    return false; // dla wydajnosci - mozliwe uri sortujemy po dlugosci
                }
            });
        }

        // modyfikuje tabele
        jQuery('div#main table.table tbody tr:first td:first').addClass('radius-top-left');
        jQuery('div#main table.table tbody tr:first td:last').addClass('radius-top-right');
        if (jQuery('div#main table.table tfoot').length) {
            jQuery('div#main table.table tfoot tr:last td:first').addClass('radius-bottom-left');
            jQuery('div#main table.table tfoot tr:last td:last').addClass('radius-bottom-right');
        } else {
            jQuery('div#main table.table tbody tr:last td:first').addClass('radius-bottom-left');
            jQuery('div#main table.table tbody tr:last td:last').addClass('radius-bottom-right');
        }
        jQuery('div#main table.table tbody tr td').each(function() {
            jQuery(this).parent().find('td:last').addClass('actions');
        });
        jQuery('div#main table.table tbody tr:even').addClass('even');
        
        // tablesorter
        if (jQuery('table.tablesorter tbody').length) {
            jQuery('table.tablesorter').tablesorter({
                headers: {
                    0: {
                        sorter: false
                    }
                }
            });
        }

        // bform

        jQuery("input[type=checkbox].read-only").click(function() {
            return false;
        });

        // jquery tabs
        jQuery('div.tabs').tabs({
            create: function(event, ui) {
                var tab_parent_id = $('.tabs .error:first').parents('.ui-tabs-panel').attr('id');
                
                if(!tab_parent_id) 
                    return;
                
                var activate_tab = $('.ui-tabs-nav a').index($('.ui-tabs-nav a[href="#'+tab_parent_id+'"]'));
                
                if(!activate_tab) 
                    return;
                
                $( ".tabs" ).tabs('select', activate_tab);
            }
        });
        
    },
    
    submit_delete_form      : false,
    
    forms       : function() {
        
        jQuery('.form-many').submit(function() {
            
            var $form = jQuery(this);
            
            if ( ! $form.find("input[type=checkbox]:checked").length) {
                main.dialogs.show.alert_message("Nic nie zaznaczy\u0142eś!");
                return false;
            }
            if ( ! $form.find("select.form-many-actions").val()) {
                main.dialogs.show.alert_message("Wybierz akcję jaką chcesz wykonać!");
                return false;
            }
            if ($form.find('.form-many-actions').val() == 'delete') {
                var delete_confirm = $form.find('.form-many-actions :selected').data("title");
                
                if(!delete_confirm) {
                    delete_confirm = jQuery(this).attr("title");
                }
                
                main.dialogs.show.confirm_delete_form(delete_confirm);
                if (main.submit_delete_form) {
                    main.submit_delete_form = false;
                    return true;
                } else {
                    return false;
                }
            }
        });

        jQuery('a.check-all').click(function() {
            
            var $form = jQuery(this).closest("form");
            var $a = jQuery(this);
            
            if ($a.hasClass('selected') ) {
                $form.find('input.checkbox-list').attr('checked', false);
                $a.removeClass('selected');
                $a.text('Zaznacz wszystkie');
            } else {
                $form.find('input.checkbox-list').each(function() {
                    if ( ! jQuery(this).attr('disabled')) {
                        jQuery(this).attr('checked', true);
                    }
                });
                $a.addClass('selected');
                $a.text('Odznacz wszystkie');
            }
            return false;
        });

        jQuery('input.checkbox-list').click(function() {
            
            var $form = jQuery(this).closest("form");
            
            if (jQuery(this).attr('checked')) {
                $form.find('a.check-all').text('Odznacz wszystkie').addClass('selected');
            }

            var inputs_checked = false;

            $form.find('input.checkbox-list').each(function() {
                if (jQuery(this).attr('checked')) {
                    inputs_checked = true;
                }
            })

            if ( ! inputs_checked) {
                $form.find('a.check-all').text('Zaznacz wszystkie').removeClass('selected');
            }
        });
        
        jQuery('p.url-inputs input').live('focus', function() {
            this.select();
        });

        $('select.provinces').bind('change', function() {
            var $province = $(this);

            var $counties = $province.parents('form').find('select.counties');

            if($counties.hasClass('required')) {
                $counties.empty();
            } else {
                $counties.find('option:not([value=""])').remove();
            }

            if(!$province.val()) {
                return;
            }

            $.ajax({
                'url': base_url + 'ajax/regions/counties',
                'data': {
                    'province_id': $province.val()
                },
                'dataType': 'json',
                'success': function(json) {
                    if(json) {
                        for(var i in json) {
                            $counties.append('<option value="'+json[i]['id']+'">'+json[i]['name']+'</option>');
                        }
                    }
                }
            });
        });
        
    },
    
    dialogs         : {
        
        
        init        : function() {
            
            jQuery('body').on('click', 'a.confirm_delete', function() {
                return confirm(jQuery(this).attr("title"));
            });
            
            jQuery('a.confirm').live('click', function() {
                main.dialogs.show.confirm_delete(jQuery(this).attr('href'), jQuery(this).attr("title"));
                return false;
            });

            jQuery("#confirmDelete").dialog({
                modal: true,
                title: 'Potwierdzenie',
                position: 'center',
                draggable: false,
                resizable: false,
                autoOpen: false,
                width: 400
            });

            jQuery("#alertMessage").dialog({
                modal: true,
                title: 'Informacja',
                position: 'center',
                draggable: false,
                resizable: false,
                autoOpen: false,
                width: 400
            });
            
        },
        
        show            : {
            
            confirm_delete_form       : function(message) {
                jQuery('#confirmDelete').html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span></span>');
                jQuery("#confirmDelete").find("span:eq(1)").text(message)
                jQuery('#confirmDelete').dialog('option', 'buttons', {
                    "Tak": function() {main.submit_delete_form = true;jQuery('.form-many').submit();},
                    "Nie": function() {jQuery(this).dialog("close");}
                });
                jQuery('#confirmDelete').dialog('open');
                jQuery('.ui-dialog-titlebar-close').remove();
            },

            confirm_delete          : function(url, message) {
                jQuery('#confirmDelete').html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span></span>');
                jQuery("#confirmDelete").find("span:eq(1)").text(message);
                jQuery('#confirmDelete').dialog('option', 'buttons', {
                    "Tak": function() {jQuery('.ui-dialog-buttonset button').addClass('ui-button');window.location.href = url;},
                    "Nie": function() {jQuery(this).dialog("close");}
                });
                jQuery('#confirmDelete').dialog('open');
                jQuery('.ui-dialog-titlebar-close').remove();
            },

            alert_message       : function(message) {
            
                jQuery('#alertMessage').html('<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span></span>');
                jQuery("#alertMessage").find("span:eq(1)").text(message)
                jQuery('#alertMessage').dialog('option', 'buttons', {
                    "OK": function() {jQuery(this).dialog("close");}
                });
                jQuery('#alertMessage').dialog('open');
                jQuery('.ui-dialog-titlebar-close').remove();
            }
            
        }
    }
    
};

jQuery(document).ready(function() {
    
    main.init();
    
});