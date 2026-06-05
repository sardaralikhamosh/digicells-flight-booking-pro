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
                <select class="dcfb-adults"><option value="1">1 Adult</option><option value="2">2 Adults</option>...</select>
                <select class="dcfb-children"><option value="0">0 Children</option><option value="1">1 Child</option>...</select>
                <select class="dcfb-infants"><option value="0">0 Infants</option><option value="1">1 Infant</option></select>
                <select class="dcfb-cabin">
                    <option value="Economy">Economy</option>
                    <option value="Premium Economy">Premium Economy</option>
                    <option value="Business">Business</option>
                    <option value="First">First</option>
                </select>
            </div>
            <div class="dcfb-field-group">
                <button type="submit" class="dcfb-search-btn">Search</button>
            </div>
        </div>
    </form>
</div>

<!-- Modal for contact details -->
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
            <p><label>Full Name *</label><input type="text" name="name" required></p>
            <p><label>Email *</label><input type="email" name="email" required></p>
            <p><label>Phone *</label><input type="tel" name="phone" required></p>
            <p><label>Address *</label><textarea name="address" required></textarea></p>
            <p><label>Special Requests</label><textarea name="requests"></textarea></p>
            <button type="submit">Submit Booking Request</button>
        </form>
    </div>
</div>