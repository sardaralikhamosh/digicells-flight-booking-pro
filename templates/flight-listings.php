<div class="dcfb-flight-listings">
    <div class="dcfb-flights-grid">
        <?php if ($flights): foreach ($flights as $flight): ?>
            <div class="dcfb-flight-card" data-flight-id="<?php echo $flight->id; ?>" data-origin="<?php echo esc_attr($flight->origin_code); ?>" data-dest="<?php echo esc_attr($flight->dest_code); ?>" data-name="<?php echo esc_attr($flight->flight_name); ?>">
                <?php if ($flight->image_url): ?>
                    <img src="<?php echo esc_url($flight->image_url); ?>" alt="<?php echo esc_attr($flight->flight_name); ?>" class="dcfb-flight-img">
                <?php endif; ?>
                <h3 class="dcfb-flight-name"><?php echo esc_html($flight->flight_name); ?></h3>
                <div class="dcfb-route"><?php echo esc_html($flight->origin_code); ?> → <?php echo esc_html($flight->dest_code); ?></div>
                <?php if ($flight->price): ?>
                    <div class="dcfb-price">$<?php echo esc_html($flight->price); ?></div>
                <?php endif; ?>
                <button class="dcfb-book-now-btn" data-flight-id="<?php echo $flight->id; ?>">Book Now</button>
            </div>
        <?php endforeach; else: ?>
            <p>No flights available at the moment.</p>
        <?php endif; ?>
    </div>
</div>