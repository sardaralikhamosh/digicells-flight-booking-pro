<?php
class DCFB_Frontend {
    public function __construct() {
        add_shortcode('digicells_flight_booking', array($this, 'render_search_form'));
        add_shortcode('digicells_flight_listings', array($this, 'render_flight_listings'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
    }

    public function enqueue_frontend_assets() {
        global $post;
        if (is_a($post, 'WP_Post') && (has_shortcode($post->post_content, 'digicells_flight_booking') || has_shortcode($post->post_content, 'digicells_flight_listings'))) {
            wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', array(), '4.6.13');
            wp_enqueue_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr', array('jquery'), '4.6.13', true);
            wp_enqueue_style('dcfb-frontend', DCFB_PLUGIN_URL . 'assets/css/frontend-style.css', array(), DCFB_VERSION);
            wp_enqueue_script('dcfb-frontend', DCFB_PLUGIN_URL . 'assets/js/frontend-script.js', array('jquery', 'jquery-ui-autocomplete', 'flatpickr'), DCFB_VERSION, true);
            wp_localize_script('dcfb-frontend', 'dcfb_ajax', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('dcfb_booking_nonce'),
                'airports' => DCFB_Airports::get_all()
            ));
        }
    }

    public function render_search_form() {
        ob_start();
        include DCFB_PLUGIN_DIR . 'templates/flight-search-form.php';
        return ob_get_clean();
    }

    public function render_flight_listings() {
        global $wpdb;
        $flights = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dcfb_flights WHERE is_active = 1 ORDER BY id DESC");
        ob_start();
        include DCFB_PLUGIN_DIR . 'templates/flight-listings.php';
        return ob_get_clean();
    }
}