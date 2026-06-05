<?php
class DCFB_Ajax {
    public function __construct() {
        add_action('wp_ajax_dcfb_submit_booking', array($this, 'submit_booking'));
        add_action('wp_ajax_nopriv_dcfb_submit_booking', array($this, 'submit_booking'));
    }

    public function submit_booking() {
        check_ajax_referer('dcfb_booking_nonce', 'nonce');

        // Sanitize inputs
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

        // Validate required
        if (!$origin || !$dest || !$depart || !$name || !$email || !$phone || !$address) {
            wp_send_json_error('Please fill all required fields.');
        }

        // Save to database
        global $wpdb;
        $table = $wpdb->prefix . 'dcfb_bookings';
        $data = array(
            'origin_code' => $origin,
            'origin_name' => $origin, // could store full name from autocomplete
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
            'status' => 'pending'
        );
        $wpdb->insert($table, $data);
        $booking_id = $wpdb->insert_id;

        // Send emails
        $this->send_admin_email($data, $booking_id);
        $this->send_agent_emails($data, $booking_id);

        wp_send_json_success('Booking request submitted successfully. We will contact you soon.');
    }

    private function send_admin_email($data, $booking_id) {
        $admin_email = get_option('dcfb_admin_email', get_option('admin_email'));
        $notify_admin = get_option('dcfb_notify_admin', 'yes');
        if ($notify_admin !== 'yes') return;

        $subject = 'New Flight Booking Request #' . $booking_id;
        $message = $this->build_email_message($data, $booking_id);
        wp_mail($admin_email, $subject, $message, array('Content-Type: text/html; charset=UTF-8'));
    }

    private function send_agent_emails($data, $booking_id) {
        $cc_agent = get_option('dcfb_cc_agent', 'yes');
        if ($cc_agent !== 'yes') return;

        global $wpdb;
        $agents = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}dcfb_agents WHERE is_active = 1");
        $subject = 'New Flight Booking Assignment #' . $booking_id;
        $message = $this->build_email_message($data, $booking_id);
        foreach ($agents as $agent) {
            // Optional: filter agents by route if origin_code/dest_code match
            if ($agent->origin_code && $agent->origin_code != $data['origin_code']) continue;
            if ($agent->dest_code && $agent->dest_code != $data['dest_code']) continue;
            wp_mail($agent->email, $subject, $message, array('Content-Type: text/html; charset=UTF-8'));
        }
    }

    private function build_email_message($data, $booking_id) {
        ob_start();
        ?>
        <h2>Flight Booking Request</h2>
        <p><strong>Booking ID:</strong> <?php echo $booking_id; ?></p>
        <p><strong>From:</strong> <?php echo $data['origin_name']; ?> (<?php echo $data['origin_code']; ?>)<br>
        <strong>To:</strong> <?php echo $data['dest_name']; ?> (<?php echo $data['dest_code']; ?>)<br>
        <strong>Departure:</strong> <?php echo $data['depart_date']; ?><br>
        <strong>Return:</strong> <?php echo $data['return_date'] ?: 'N/A'; ?><br>
        <strong>Trip Type:</strong> <?php echo ucfirst($data['trip_type']); ?><br>
        <strong>Travelers:</strong> Adults: <?php echo $data['adults']; ?>, Children: <?php echo $data['children']; ?>, Infants: <?php echo $data['infants']; ?><br>
        <strong>Cabin Class:</strong> <?php echo $data['cabin_class']; ?></p>
        <h3>Passenger Details</h3>
        <p><strong>Name:</strong> <?php echo $data['passenger_name']; ?><br>
        <strong>Email:</strong> <?php echo $data['passenger_email']; ?><br>
        <strong>Phone:</strong> <?php echo $data['passenger_phone']; ?><br>
        <strong>Address:</strong> <?php echo nl2br($data['passenger_address']); ?><br>
        <strong>Special Requests:</strong> <?php echo nl2br($data['special_requests']); ?></p>
        <?php
        return ob_get_clean();
    }
}