<div class="wrap">
    <h1>Flight Listings</h1>
    <button type="button" id="dcfb-add-flight-btn" class="page-title-action">Add New Flight</button>
    
    <div id="dcfb-flight-form" style="display:none; margin-top:20px; background:#f1f1f1; padding:20px; border-radius:5px;">
        <h2>Add New Flight</h2>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <?php wp_nonce_field('dcfb_add_flight'); ?>
            <input type="hidden" name="action" value="dcfb_add_flight">
            <table class="form-table">
                <tr><th>Flight Name *</th><td><input type="text" name="flight_name" required style="width:100%"></td></tr>
                <tr><th>Origin (Airport Code) *</th><td><input type="text" name="origin_code" required placeholder="e.g., JFK" style="width:100%"></td></tr>
                <tr><th>Destination (Airport Code) *</th><td><input type="text" name="dest_code" required placeholder="e.g., LHR" style="width:100%"></td></tr>
                <tr><th>Price (optional)</th><td><input type="number" step="0.01" name="price" placeholder="0.00" style="width:100%"></td></tr>
                <tr><th>Featured Image</th>
                    <td>
                        <input type="hidden" name="image_url" id="flight-image-url">
                        <button type="button" class="button" id="upload-image-btn">Upload Image</button>
                        <button type="button" class="button" id="remove-image-btn" style="display:none;">Remove</button>
                        <div id="flight-image-preview-container" style="margin-top:10px; display:none;">
                            <img id="flight-image-preview" style="max-width:200px;">
                        </div>
                    </td>
                </tr>
            </table>
            <?php submit_button('Save Flight', 'primary'); ?>
            <button type="button" id="cancel-flight-btn" class="button">Cancel</button>
        </form>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
        <div class="notice notice-success"><p>Flight added successfully.</p></div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="notice notice-success"><p>Flight deleted.</p></div>
    <?php elseif (isset($_GET['msg']) && $_GET['msg'] == 'error'): ?>
        <div class="notice notice-error"><p>Error saving flight. Please check fields.</p></div>
    <?php endif; ?>

    <table class="wp-list-table widefat fixed striped">
        <thead><tr><th>ID</th><th>Image</th><th>Flight Name</th><th>Route</th><th>Price</th><th>Actions</th></tr></thead>
        <tbody>
        <?php if ($flights && !empty($flights)): foreach ($flights as $f): ?>
            <tr>
                <td><?php echo $f->id; ?></td>
                <td><?php if ($f->image_url) echo '<img src="'.esc_url($f->image_url).'" style="max-width:50px;">'; ?></td>
                <td><?php echo esc_html($f->flight_name); ?></td>
                <td><?php echo esc_html($f->origin_code); ?> → <?php echo esc_html($f->dest_code); ?></td>
                <td><?php echo $f->price ? '$'.number_format($f->price,2) : '-'; ?></td>
                <td><a href="<?php echo wp_nonce_url(admin_url('admin-post.php?action=dcfb_delete_flight&id='.$f->id), 'dcfb_delete_flight'); ?>" onclick="return confirm('Delete this flight?')" class="button-link-delete">Delete</a></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="6">No flights added yet. Click "Add New Flight" to get started.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
jQuery(document).ready(function($) {
    $('#dcfb-add-flight-btn').click(function() { $('#dcfb-flight-form').slideToggle(); });
    $('#cancel-flight-btn').click(function() { $('#dcfb-flight-form').slideUp(); });
    var frame;
    $('#upload-image-btn').click(function(e) {
        e.preventDefault();
        if (frame) { frame.open(); return; }
        frame = wp.media({ title: 'Select Image', multiple: false });
        frame.on('select', function() {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#flight-image-url').val(attachment.url);
            $('#flight-image-preview').attr('src', attachment.url);
            $('#flight-image-preview-container').show();
            $('#remove-image-btn').show();
        });
        frame.open();
    });
    $('#remove-image-btn').click(function() {
        $('#flight-image-url').val('');
        $('#flight-image-preview-container').hide();
        $(this).hide();
    });
});
</script>