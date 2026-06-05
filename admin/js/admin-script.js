jQuery(document).ready(function($) {
    $('#upload-image-btn').click(function(e) {
        e.preventDefault();
        var frame = wp.media({ title: 'Select Image', multiple: false });
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#flight-image-url').val(attachment.url);
            $('#flight-image-preview').attr('src', attachment.url).show();
        });
        frame.open();
    });
});