jQuery(document).ready(function($) {
    var mediaFrame;
    $(document).on('click', '#upload-image-btn', function(e) {
        e.preventDefault();
        if (mediaFrame) { mediaFrame.open(); return; }
        mediaFrame = wp.media({ title: 'Select Image', multiple: false });
        mediaFrame.on('select', function() {
            var attachment = mediaFrame.state().get('selection').first().toJSON();
            $('#flight-image-url').val(attachment.url);
            $('#flight-image-preview').attr('src', attachment.url);
            $('#flight-image-preview-container').show();
            $('#remove-image-btn').show();
        });
        mediaFrame.open();
    });
    $(document).on('click', '#remove-image-btn', function() {
        $('#flight-image-url').val('');
        $('#flight-image-preview-container').hide();
        $(this).hide();
    });
});