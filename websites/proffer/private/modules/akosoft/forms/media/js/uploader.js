$(function () {

    $('.file_uploader').each(function() {
        var $uploader_container = $(this);
        var $files_container = $uploader_container.find('.files_container');
        var $form = $uploader_container.parents('form');

        $uploader_container.find('.file_inputs').hide();

        $files_container.sortable({
            opacity: 0.6,
            cursor: 'move',
            placeholder: "placeholder",
            helper: 'clone'
        });

        $uploader_container.find('.fileuploader').show();

        var $input_file = $uploader_container.find('.filesuploader-input');

        var formData = $form.serializeArray();
        formData.push({name: 'form_id', value: $form.find('[name=form_id]').val()});

        $input_file.fileupload({
            dataType: 'json',
            url: $input_file.data('upload_url'),
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator && navigator.userAgent),
            imageMaxWidth: 1024,
            imageMaxHeight: 768,
            imageCrop: false,
            formData: formData
        }).on('fileuploadadd', function (e, data) {
            if(checkLimit()) {
                data.context = $('<div class="file"/>').appendTo($files_container);
                $.each(data.files, function (index, file) {
                    var img = $('<img/>').attr('src', base_url + 'media/img/spinner32.gif');
                    var anchor = $('<div class="inner"/>').append(img);

                    data.context.append($('<div class="image-wrapper" />').append(anchor));
                    data.context.append($('<a href="#" class="close">&times;</a>'));
                });

                data.context.data(data);
            } else {
                alert('Dodałeś zbyt wiele plików!');
                return false;
            }
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index];

            if (file.error) {
                on_error(data.context, file.error);
            } else {
                if(data.context) {
                    data.context.data().submit();
                }
            }

        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.download_url) {
                    var $image_wrapper = data.context.find('.image-wrapper');

                    var image = new Image();
                    image.onload = function() {
                        var img = $('<img/>').attr('src', file.download_url);
                        var anchor = $('<a/>')
                            .addClass('showGallery')
                            .attr({'href': file.download_url, 'target': '_blank'})
                            .append(img);

                        $image_wrapper.html(anchor);
                    };
                    image.onerror = function() {
                        on_error(data.context, 'Cannot load uploaded image!');
                    };
                    image.src = file.download_url;

                    data.context.append($('<input type="hidden" />')
                        .attr("name", '_uploaded_files[]')
                        .attr("value", file.serialized)
                    );

                } else if (file.error) {
                    on_error(data.context, file.error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index, file) {
                on_error(data.context, 'File upload failed.');
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');

        //delete files

        $files_container.on('click', '.close', function(e) {
            var $close_btn = $(this);

            if($close_btn.attr('href') === '#') {
                e.preventDefault();
                $close_btn.parents('.file').remove();
            } else {

            }
        });

        //show gallery

        $files_container.on('click', '.showGallery', function(e) {
            e.preventDefault();

            var images_list = [];

            var $anchor = $(this);
            var $images = $files_container.find('.showGallery img');

            $images.each(function() {
                images_list.push(this.src);
            });

            $.fancybox(images_list, {
                'padding'	: 0,
                'transitionIn'	: 'none',
                'transitionOut'	: 'none',
                'type'          : 'image',
                'changeFade'    : 0,
                'index'         : $images.index($anchor.find('img'))
            });
        });

        function checkLimit() {
            return $files_container.find('.file:not(.file--error)').length < $input_file.data('file_limit');
        }

        function on_error($file, message) {
            var error = $('<span class="error_text"/>').text(message);
            $file.addClass('file--error').html(error).fadeOut(2000, function() { $(this).remove(); });

            console.log('File upload failed with message: '+message);
        }
    });
});