<div class="wrap">
    <h1>Flight Booking Settings</h1>
    <form method="post">
        <?php wp_nonce_field('dcfb_settings'); ?>
        <table class="form-table">
            <tr><th>Admin Email</th><td><input type="email" name="admin_email" value="<?php echo esc_attr($admin_email); ?>" class="regular-text"></td></tr>
            <tr><th>Notify Admin on new booking</th><td><input type="checkbox" name="notify_admin" <?php checked($notify_admin, 'yes'); ?>></td></tr>
            <tr><th>CC agents on new booking</th><td><input type="checkbox" name="cc_agent" <?php checked($cc_agent, 'yes'); ?>></td></tr>
        </table>
        <?php submit_button('Save Settings', 'primary', 'save_settings'); ?>
    </form>
</div>