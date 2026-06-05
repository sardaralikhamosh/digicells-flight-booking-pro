<?php
class DCFB_Airports {
    public static function get_all() {
        // Sample airports - you can extend this list
        return array(
            array('code' => 'JFK', 'name' => 'New York John F. Kennedy', 'city' => 'New York', 'country' => 'USA'),
            array('code' => 'LAX', 'name' => 'Los Angeles International', 'city' => 'Los Angeles', 'country' => 'USA'),
            array('code' => 'LHR', 'name' => 'London Heathrow', 'city' => 'London', 'country' => 'UK'),
            array('code' => 'DXB', 'name' => 'Dubai International', 'city' => 'Dubai', 'country' => 'UAE'),
            array('code' => 'ISB', 'name' => 'Islamabad International', 'city' => 'Islamabad', 'country' => 'Pakistan'),
            array('code' => 'KHI', 'name' => 'Jinnah International', 'city' => 'Karachi', 'country' => 'Pakistan'),
            array('code' => 'LHE', 'name' => 'Allama Iqbal International', 'city' => 'Lahore', 'country' => 'Pakistan'),
            // Add more as needed
        );
    }
}