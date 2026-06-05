<div class="wrap">
    <h1>Flight Bookings</h1>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr><th>ID</th><th>Passenger</th><th>Route</th><th>Dates</th><th>Travelers</th><th>Cabin</th><th>Status</th><th>Date</th></tr>
        </thead>
        <tbody>
        <?php if ($bookings): foreach ($bookings as $b): ?>
            <tr>
                <td><?php echo $b->id; ?></td>
                <td><?php echo esc_html($b->passenger_name); ?><br><small><?php echo esc_html($b->passenger_email); ?></small></td>
                <td><?php echo esc_html($b->origin_code); ?> → <?php echo esc_html($b->dest_code); ?></td>
                <td><?php echo $b->depart_date; ?><br><?php echo $b->return_date ?: '-'; ?></td>
                <td>A:<?php echo $b->adults; ?> C:<?php echo $b->children; ?> I:<?php echo $b->infants; ?></td>
                <td><?php echo esc_html($b->cabin_class); ?></td>
                <td><?php echo ucfirst($b->status); ?></td>
                <td><?php echo $b->booking_date; ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr><td colspan="8">No bookings yet.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>