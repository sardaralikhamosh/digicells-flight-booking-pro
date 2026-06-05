<div class="dcfb-search-form">
    <h2>Search hundreds of flight sites at once.</h2>
    <form id="dcfb-search-form">
        <div class="dcfb-trip-type">
            <label><input type="radio" name="trip_type" value="roundtrip" checked> Round-trip</label>
            <label><input type="radio" name="trip_type" value="oneway"> One-way</label>
        </div>
        <div class="dcfb-row">
            <div class="dcfb-field-group">
                <label>From?</label>
                <input type="text" class="dcfb-origin" placeholder="City or Airport" required>
            </div>
            <div class="dcfb-field-group">
                <label>To?</label>
                <input type="text" class="dcfb-destination" placeholder="City or Airport" required>
            </div>
            <div class="dcfb-field-group">
                <label>Departure</label>
                <input type="text" class="dcfb-depart" placeholder="Select date" required>
            </div>
            <div class="dcfb-field-group dcfb-return-group">
                <label>Return</label>
                <input type="text" class="dcfb-return" placeholder="Select date">
            </div>
            <div class="dcfb-field-group">
                <label>Travelers & Cabin</label>
                <div class="dcfb-occupancy-trigger" id="dcfb-occupancy-trigger">
                    <span id="dcfb-occupancy-summary">1 Adult, Economy</span>
                    <span class="dcfb-chevron">▼</span>
                </div>
                <div id="dcfb-occupancy-popup" class="dcfb-popup" style="display:none;">
                    <div class="dcfb-popup-content">
                        <!-- Adults -->
                        <div class="dcfb-popup-row">
                            <div class="dcfb-popup-label">Adults <span class="age-hint">18+</span></div>
                            <div class="dcfb-popup-controls">
                                <button type="button" class="dcfb-popup-btn minus" data-field="adults">−</button>
                                <span class="dcfb-popup-value" id="dcfb_popup_adults">1</span>
                                <button type="button" class="dcfb-popup-btn plus" data-field="adults">+</button>
                            </div>
                            <input type="range" class="dcfb-popup-slider" id="dcfb_range_adults" min="1" max="9" value="1">
                        </div>
                        <!-- Children -->
                        <div class="dcfb-popup-row">
                            <div class="dcfb-popup-label">Children <span class="age-hint">0-17</span></div>
                            <div class="dcfb-popup-controls">
                                <button type="button" class="dcfb-popup-btn minus" data-field="children">−</button>
                                <span class="dcfb-popup-value" id="dcfb_popup_children">0</span>
                                <button type="button" class="dcfb-popup-btn plus" data-field="children">+</button>
                            </div>
                            <input type="range" class="dcfb-popup-slider" id="dcfb_range_children" min="0" max="7" value="0">
                        </div>
                        <!-- Infants on lap -->
                        <div class="dcfb-popup-row">
                            <div class="dcfb-popup-label">Infants on lap <span class="age-hint">under 2</span></div>
                            <div class="dcfb-popup-controls">
                                <button type="button" class="dcfb-popup-btn minus" data-field="infants">−</button>
                                <span class="dcfb-popup-value" id="dcfb_popup_infants">0</span>
                                <button type="button" class="dcfb-popup-btn plus" data-field="infants">+</button>
                            </div>
                            <input type="range" class="dcfb-popup-slider" id="dcfb_range_infants" min="0" max="2" value="0">
                        </div>
                        <!-- Cabin Class -->
                        <div class="dcfb-popup-row">
                            <div class="dcfb-popup-label">Cabin Class</div>
                            <div class="dcfb-cabin-options">
                                <label><input type="radio" name="cabin_class" value="Economy" checked> Economy</label>
                                <label><input type="radio" name="cabin_class" value="Premium Economy"> Premium Economy</label>
                                <label><input type="radio" name="cabin_class" value="Business"> Business</label>
                                <label><input type="radio" name="cabin_class" value="First"> First</label>
                            </div>
                        </div>
                        <button type="button" id="dcfb-popup-done" class="dcfb-popup-done">Done</button>
                    </div>
                </div>
            </div>
            <div class="dcfb-field-group">
                <button type="submit" class="dcfb-search-btn">Search</button>
            </div>
        </div>
    </form>
</div>

<!-- Modal for contact details (reused) -->
<div id="dcfb-modal" class="dcfb-modal" style="display:none;">
    <div class="dcfb-modal-content">
        <span class="dcfb-close">&times;</span>
        <h3>Complete Your Booking</h3>
        <form id="dcfb-contact-form">
            <input type="hidden" id="modal-origin" name="origin">
            <input type="hidden" id="modal-dest" name="dest">
            <input type="hidden" id="modal-depart" name="depart">
            <input type="hidden" id="modal-return" name="return">
            <input type="hidden" id="modal-trip_type" name="trip_type">
            <input type="hidden" id="modal-adults" name="adults">
            <input type="hidden" id="modal-children" name="children">
            <input type="hidden" id="modal-infants" name="infants">
            <input type="hidden" id="modal-cabin" name="cabin">
            <input type="hidden" id="modal-flight_id" name="flight_id">
            <div class="booking-summary" style="background:#f5f5f5; padding:10px; margin-bottom:15px; border-radius:4px;">
                <p><strong>Flight:</strong> <span id="summary-origin"></span> → <span id="summary-dest"></span></p>
                <p><strong>Dates:</strong> <span id="summary-depart"></span> <span id="summary-return"></span></p>
                <p><strong>Travelers:</strong> <span id="summary-adults"></span> Adults, <span id="summary-children"></span> Children, <span id="summary-infants"></span> Infants</p>
                <p><strong>Cabin:</strong> <span id="summary-cabin"></span></p>
            </div>
            <p><label>Full Name *</label><input type="text" name="name" required></p>
            <p><label>Email *</label><input type="email" name="email" required></p>
            <p><label>Phone *</label><input type="tel" name="phone" required></p>
            <p><label>Address *</label><textarea name="address" required></textarea></p>
            <p><label>Special Requests</label><textarea name="requests"></textarea></p>
            <button type="submit">Submit Booking Request</button>
        </form>
    </div>
</div>