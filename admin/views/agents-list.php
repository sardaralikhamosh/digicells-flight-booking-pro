<div class="wrap">
    <h1>Flight Agents</h1>
    <a href="<?php echo admin_url('admin-post.php?action=dcfb_add_agent_form'); ?>" class="page-title-action">Add New Agent</a>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <?php wp_nonce_field('dcfb_add_agent'); ?>
        <input type="hidden" name="action" value="dcfb_add_agent">
        <table class="form-table">
            <tr><th>Name</th><td><input type="text" name="name" required></td></tr>
            <tr><th>Email</th><td><input type="email" name="email" required></td></tr>
            <tr><th>Origin (optional)</th><td><input type="text" name="origin_code" placeholder="e.g., JFK"></td></tr>
            <tr><th>Destination (optional)</th><td><input type="text" name="dest_code" placeholder="e.g., LHR"></td></tr>
        </table>
        <?php submit_button('Add Agent'); ?>
    </form>
    <table class="wp-list-table widefat fixed striped">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Route (if specific)</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach ($agents as $a): ?>
            <tr>
                <td><?php echo $a->id; ?></td>
                <td><?php echo esc_html($a->name); ?></td>
                <td><?php echo esc_html($a->email); ?></td>
                <td><?php echo ($a->origin_code ? $a->origin_code . ' → ' : '') . ($a->dest_code ?: 'All'); ?></td>
                <td><a href="<?php echo wp_nonce_url(admin_url('admin-post.php?action=dcfb_delete_agent&id='.$a->id), 'dcfb_delete_agent'); ?>" onclick="return confirm('Are you sure?')">Delete</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>