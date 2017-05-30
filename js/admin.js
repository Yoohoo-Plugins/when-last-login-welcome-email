jQuery(document).ready(function(){

	var wll_we_media_popup;
    jQuery(document.body).on('click.tgmOpenMediaManager', '#wll_we_upload_media', function(e){
        e.preventDefault();
        if ( wll_we_media_popup ) {
            wll_we_media_popup.open();
            return;
        }
        wll_we_media_popup = wp.media.frames.tgm_media_frame = wp.media({
            className: 'media-frame tgm-media-frame',
            frame: 'select',
            multiple: false,
            title: 'Upload Logo',
            library: {
                type: 'image'
            },
            button: {
                text: 'Use as Logo'
            }
        });

        wll_we_media_popup.on('select', function(){
            var media_attachment = wll_we_media_popup.state().get('selection').first().toJSON();
            jQuery('#wll_we_logo').val(media_attachment.url);
        });
        wll_we_media_popup.open();
    });


});