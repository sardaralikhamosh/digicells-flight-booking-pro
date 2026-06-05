<?php
class DCFB_Activator {
    public static function activate() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        // Bookings table
        $table_bookings = $wpdb->prefix . 'dcfb_bookings';
        $sql_bookings = "CREATE TABLE $table_bookings (
            id int(11) NOT NULL AUTO_INCREMENT,
            origin_code varchar(10) NOT NULL,
            origin_name varchar(255) NOT NULL,
            dest_code varchar(10) NOT NULL,
            dest_name varchar(255) NOT NULL,
            depart_date date NOT NULL,
            return_date date DEFAULT NULL,
            trip_type varchar(20) NOT NULL,
            adults int(3) NOT NULL,
            children int(3) NOT NULL,
            infants int(3) NOT NULL,
            cabin_class varchar(30) NOT NULL,
            passenger_name varchar(255) NOT NULL,
            passenger_email varchar(255) NOT NULL,
            passenger_phone varchar(50) NOT NULL,
            passenger_address text NOT NULL,
            special_requests text,
            booking_date datetime DEFAULT CURRENT_TIMESTAMP,
            status varchar(20) DEFAULT 'pending',
            flight_id int(11) DEFAULT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Agents table
        $table_agents = $wpdb->prefix . 'dcfb_agents';
        $sql_agents = "CREATE TABLE $table_agents (
            id int(11) NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            origin_code varchar(10) DEFAULT NULL,
            dest_code varchar(10) DEFAULT NULL,
            is_active tinyint(1) DEFAULT 1,
            PRIMARY KEY (id)
        ) $charset_collate;";

        // Flights table
        $table_flights = $wpdb->prefix . 'dcfb_flights';
        $sql_flights = "CREATE TABLE $table_flights (
            id int(11) NOT NULL AUTO_INCREMENT,
            flight_name varchar(255) NOT NULL,
            origin_code varchar(10) NOT NULL,
            dest_code varchar(10) NOT NULL,
            price decimal(10,2) DEFAULT NULL,
            image_url varchar(500) DEFAULT NULL,
            is_active tinyint(1) DEFAULT 1,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_bookings);
        dbDelta($sql_agents);
        dbDelta($sql_flights);

        // Default settings
        add_option('dcfb_admin_email', get_option('admin_email'));
        add_option('dcfb_notify_admin', 'yes');
        add_option('dcfb_cc_agent', 'yes');
    }
}