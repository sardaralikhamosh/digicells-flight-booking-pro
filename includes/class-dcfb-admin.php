<?php
class DCFB_Admin {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menus'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('admin_post_dcfb_add_agent', array($this, 'add_agent'));
        add_action('admin_post_dcfb_delete_agent', array($this, 'delete_agent'));
        add_action('admin_post_dcfb_add_flight', array($this, 'add_flight'));
        add_action('admin_post_dcfb_delete_flight', array($this, 'delete_flight'));
    }

    public function add_admin_menus() {
        add_menu_page(
            'Flight Booking',
            'Flight Booking',
            'manage_options',
            'dcfb-dashboard',
            array($this, 'render_bookings_page'),
            'dashicons-airplane',
            25
        );
        add_submenu_page(
            'dcfb-dashboard',
            'Flights',
            'Flights',
            'manage_options',
            'dcfb-flights',
            array($this, 'render_flights_page')
        );
        add_submenu_page(
            'dcfb-dashboard',
            'Agents',
            'Agents',
            'manage_options',
            'dcfb-agents',
            array($this, 'render_agents_page')
        );
        add_submenu_page(
            'dcfb-dashboard',
            'Settings',
            'Settings',
            'manage_options',
            'dcfb-settings',
            array($this, 'render_settings_page')
        );
    }

   public function enqueue_admin_assets($hook) {
    if (strpos($hook, 'dcfb') !== false) {
        wp_enqueue_media(); // Required for image uploader
        wp_enqueue_style('dcfb-admin', DCFB_PLUGIN_URL . 'admin/css/admin-style.css', array(), DCFB_VERSION);
        wp_enqueue_script('dcfb-admin', DCFB_PLUGIN_URL . 'admin/js/admin-script.js', array('jquery'), DCFB_VERSION, true);
    }
}

    public function render_bookings_page() {
        global $wpdb;
        $table = $wpdb->prefix . 'dcfb_bookings';
        $bookings = $wpdb->get_results("SELECT * FROM $table ORDER BY booking_date DESC");
        include DCFB_PLUGIN_DIR . 'admin/views/bookings-list.php';
    }

    public function render_flights_page() {
        global $wpdb;
        $table = $wpdb->prefix . 'dcfb_flights';
        $flights = $wpdb->get_results("SELECT * FROM $table ORDER BY id DESC");
        include DCFB_PLUGIN_DIR . 'admin/views/flights-list.php';
    }

    public function add_flight() {
    if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['_wpnonce'], 'dcfb_add_flight')) {
        wp_die('Security check failed.');
    }
    global $wpdb;
    $flight_name = sanitize_text_field($_POST['flight_name']);
    $origin_code = sanitize_text_field($_POST['origin_code']);
    $dest_code = sanitize_text_field($_POST['dest_code']);
    $price = !empty($_POST['price']) ? floatval($_POST['price']) : null;
    $image_url = !empty($_POST['image_url']) ? esc_url_raw($_POST['image_url']) : '';

    if (empty($flight_name) || empty($origin_code) || empty($dest_code)) {
        wp_redirect(admin_url('admin.php?page=dcfb-flights&msg=error'));
        exit;
    }

    $inserted = $wpdb->insert($wpdb->prefix . 'dcfb_flights', array(
        'flight_name' => $flight_name,
        'origin_code' => $origin_code,
        'dest_code' => $dest_code,
        'price' => $price,
        'image_url' => $image_url,
        'is_active' => 1
    ));

    if ($inserted) {
        wp_redirect(admin_url('admin.php?page=dcfb-flights&msg=added'));
    } else {
        wp_redirect(admin_url('admin.php?page=dcfb-flights&msg=error'));
    }
    exit;
}

    public function delete_flight() {
        if (!current_user_can('manage_options') || !wp_verify_nonce($_GET['_wpnonce'], 'dcfb_delete_flight')) wp_die('Security check');
        global $wpdb;
        $id = intval($_GET['id']);
        $wpdb->delete($wpdb->prefix . 'dcfb_flights', array('id' => $id));
        wp_redirect(admin_url('admin.php?page=dcfb-flights&msg=deleted'));
        exit;
    }

    public function render_agents_page() {
        global $wpdb;
        $agents_table = $wpdb->prefix . 'dcfb_agents';
        $agents = $wpdb->get_results("SELECT * FROM $agents_table");
        include DCFB_PLUGIN_DIR . 'admin/views/agents-list.php';
    }

    public function render_settings_page() {
        if (isset($_POST['save_settings']) && check_admin_referer('dcfb_settings')) {
            update_option('dcfb_admin_email', sanitize_email($_POST['admin_email']));
            update_option('dcfb_notify_admin', isset($_POST['notify_admin']) ? 'yes' : 'no');
            update_option('dcfb_cc_agent', isset($_POST['cc_agent']) ? 'yes' : 'no');
            echo '<div class="notice notice-success"><p>Settings saved.</p></div>';
        }
        $admin_email = get_option('dcfb_admin_email', get_option('admin_email'));
        $notify_admin = get_option('dcfb_notify_admin', 'yes');
        $cc_agent = get_option('dcfb_cc_agent', 'yes');
        include DCFB_PLUGIN_DIR . 'admin/views/settings.php';
    }

    public function add_agent() {
        if (!current_user_can('manage_options') || !wp_verify_nonce($_POST['_wpnonce'], 'dcfb_add_agent')) wp_die('Security check');
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'dcfb_agents', array(
            'name' => sanitize_text_field($_POST['name']),
            'email' => sanitize_email($_POST['email']),
            'origin_code' => sanitize_text_field($_POST['origin_code']),
            'dest_code' => sanitize_text_field($_POST['dest_code']),
            'is_active' => 1
        ));
        wp_redirect(admin_url('admin.php?page=dcfb-agents&msg=added'));
        exit;
    }

    public function delete_agent() {
        if (!current_user_can('manage_options') || !wp_verify_nonce($_GET['_wpnonce'], 'dcfb_delete_agent')) wp_die('Security check');
        global $wpdb;
        $id = intval($_GET['id']);
        $wpdb->delete($wpdb->prefix . 'dcfb_agents', array('id' => $id));
        wp_redirect(admin_url('admin.php?page=dcfb-agents&msg=deleted'));
        exit;
    }
}