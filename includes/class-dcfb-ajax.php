<?php
class DCFB_Ajax {
    public function __construct() {
        add_action('wp_ajax_dcfb_submit_booking', array($this, 'submit_booking'));
        add_action('wp_ajax_nopriv_dcfb_submit_booking', array($this, 'submit_booking'));
    }

    public function submit_booking() {
        check_ajax_referer('dcfb_booking_nonce', 'nonce');

        // Sanitize
        $origin = sanitize_text_field($_POST['origin']);
        $dest = sanitize_text_field($_POST['dest']);
        $depart = sanitize_text_field($_POST['depart']);
        $return = !empty($_POST['return']) ? sanitize_text_field($_POST['return']) : null;
        $trip_type = sanitize_text_field($_POST['trip_type']);
        $adults = intval($_POST['adults']);
        $children = intval($_POST['children']);
        $infants = intval($_POST['infants']);
        $cabin = sanitize_text_field($_POST['cabin']);
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $address = sanitize_textarea_field($_POST['address']);
        $requests = sanitize_textarea_field($_POST['requests']);
        $flight_id = isset($_POST['flight_id']) ? intval($_POST['flight_id']) : null;

        if (!$origin || !$dest || !$depart || !$name || !$email || !$phone || !$address) {
            wp_send_json_error('Please fill all required fields.');
        }

        global $wpdb;
        $table = $wpdb->prefix . 'dcfb_bookings';
        $data = array(
            'origin_code' => $origin,
            'origin_name' => $origin,
            'dest_code' => $dest,
            'dest_name' => $dest,
            'depart_date' => $depart,
            'return_date' => $return,
            'trip_type' => $trip_type,
            'adults' => $adults,
            'children' => $children,
            'infants' => $infants,
            'cabin_class' => $cabin,
            'passenger_name' => $name,
            'passenger_email' => $email,
            'passenger_phone' => $phone,
            'passenger_address' => $address,
            'special_requests' => $requests,
            'booking_date' => current_time('mysql'),
            'status' => 'pending',
            'flight_id' => $flight_id
        );
        $wpdb->insert($table, $data);
        $booking_id = $wpdb->insert_id;

        $this->send_admin_email($data, $booking_id);
        $this->send_agent_emails($data, $booking_id);

        wp_send_json_success('Booking request submitted successfully. We will contact you soon.');
    }

    // ... email functions same as before, but add flight_id to message
}