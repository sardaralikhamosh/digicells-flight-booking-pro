jQuery(document).ready(function($) {
    var airports = dcfb_ajax.airports;
    // Autocomplete
    function airportSource(request, response) {
        var term = request.term.toLowerCase();
        var matches = airports.filter(function(a) {
            return a.code.toLowerCase().indexOf(term) !== -1 ||
                   a.name.toLowerCase().indexOf(term) !== -1 ||
                   a.city.toLowerCase().indexOf(term) !== -1;
        });
        response($.map(matches.slice(0, 10), function(a) {
            return { label: a.code + ' - ' + a.name + ', ' + a.city, value: a.code, full: a };
        }));
    }
    $('.dcfb-origin, .dcfb-destination').autocomplete({
        source: airportSource,
        minLength: 1,
        select: function(event, ui) { $(this).data('full', ui.item.full); }
    });

    // Date picker
    flatpickr('.dcfb-depart, .dcfb-return', { dateFormat: 'Y-m-d', minDate: 'today' });
    $('.dcfb-depart').on('change', function() {
        var depart = $(this).val();
        $('.dcfb-return').flatpickr({ minDate: depart });
    });

    // Trip type toggle
    $('input[name="trip_type"]').on('change', function() {
        $('.dcfb-return-group').toggle($(this).val() === 'roundtrip');
    });

    // Travelers & Cabin popup
    var occupancy = { adults: 1, children: 0, infants: 0, cabin: 'Economy' };
    function updateSummary() {
        var text = occupancy.adults + ' Adult' + (occupancy.adults > 1 ? 's' : '');
        if (occupancy.children > 0) text += ', ' + occupancy.children + ' Child' + (occupancy.children > 1 ? 'ren' : '');
        if (occupancy.infants > 0) text += ', ' + occupancy.infants + ' Infant' + (occupancy.infants > 1 ? 's' : '');
        text += ', ' + occupancy.cabin;
        $('#dcfb-occupancy-summary').text(text);
    }
    function updatePopupValues() {
        $('#dcfb_popup_adults').text(occupancy.adults);
        $('#dcfb_range_adults').val(occupancy.adults);
        $('#dcfb_popup_children').text(occupancy.children);
        $('#dcfb_range_children').val(occupancy.children);
        $('#dcfb_popup_infants').text(occupancy.infants);
        $('#dcfb_range_infants').val(occupancy.infants);
        $('input[name="cabin_class"]').filter('[value="'+occupancy.cabin+'"]').prop('checked', true);
    }
    $('#dcfb-occupancy-trigger').click(function(e) {
        e.stopPropagation();
        $('#dcfb-occupancy-popup').toggle();
    });
    $(document).click(function(e) {
        if (!$(e.target).closest('#dcfb-occupancy-trigger, #dcfb-occupancy-popup').length) {
            $('#dcfb-occupancy-popup').hide();
        }
    });
    $('.dcfb-popup-btn.plus').click(function() {
        var field = $(this).data('field');
        if (field === 'adults' && occupancy.adults < 9) occupancy.adults++;
        if (field === 'children' && occupancy.children < 7) occupancy.children++;
        if (field === 'infants' && occupancy.infants < 2) occupancy.infants++;
        updatePopupValues();
        updateSummary();
    });
    $('.dcfb-popup-btn.minus').click(function() {
        var field = $(this).data('field');
        if (field === 'adults' && occupancy.adults > 1) occupancy.adults--;
        if (field === 'children' && occupancy.children > 0) occupancy.children--;
        if (field === 'infants' && occupancy.infants > 0) occupancy.infants--;
        updatePopupValues();
        updateSummary();
    });
    $('.dcfb-popup-slider').on('input', function() {
        var id = $(this).attr('id');
        if (id === 'dcfb_range_adults') occupancy.adults = parseInt($(this).val());
        if (id === 'dcfb_range_children') occupancy.children = parseInt($(this).val());
        if (id === 'dcfb_range_infants') occupancy.infants = parseInt($(this).val());
        updatePopupValues();
        updateSummary();
    });
    $('input[name="cabin_class"]').change(function() {
        occupancy.cabin = $(this).val();
        updateSummary();
    });
    $('#dcfb-popup-done').click(function() {
        $('#dcfb-occupancy-popup').hide();
    });
    updateSummary();

    // Open modal on search
    $('#dcfb-search-form').on('submit', function(e) {
        e.preventDefault();
        if (!$('.dcfb-origin').val() || !$('.dcfb-destination').val() || !$('.dcfb-depart').val()) {
            alert('Please fill origin, destination and departure date.');
            return;
        }
        $('#modal-origin').val($('.dcfb-origin').val());
        $('#modal-dest').val($('.dcfb-destination').val());
        $('#modal-depart').val($('.dcfb-depart').val());
        $('#modal-return').val($('.dcfb-return').val());
        $('#modal-trip_type').val($('input[name="trip_type"]:checked').val());
        $('#modal-adults').val(occupancy.adults);
        $('#modal-children').val(occupancy.children);
        $('#modal-infants').val(occupancy.infants);
        $('#modal-cabin').val(occupancy.cabin);
        $('#modal-flight_id').val('');
        updateModalSummary();
        $('#dcfb-modal').fadeIn();
    });

    // Flight listings book now
    $('.dcfb-book-now-btn').click(function() {
        var $card = $(this).closest('.dcfb-flight-card');
        var origin = $card.data('origin');
        var dest = $card.data('dest');
        var flightId = $card.data('flight-id');
        var flightName = $card.data('name');
        $('#modal-origin').val(origin);
        $('#modal-dest').val(dest);
        $('#modal-depart').val('');
        $('#modal-return').val('');
        $('#modal-trip_type').val('roundtrip');
        $('#modal-adults').val(occupancy.adults);
        $('#modal-children').val(occupancy.children);
        $('#modal-infants').val(occupancy.infants);
        $('#modal-cabin').val(occupancy.cabin);
        $('#modal-flight_id').val(flightId);
        updateModalSummary();
        $('#dcfb-modal').fadeIn();
    });

    function updateModalSummary() {
        $('#summary-origin').text($('#modal-origin').val());
        $('#summary-dest').text($('#modal-dest').val());
        $('#summary-depart').text($('#modal-depart').val());
        var returnVal = $('#modal-return').val();
        $('#summary-return').text(returnVal ? ' → ' + returnVal : '');
        $('#summary-adults').text($('#modal-adults').val());
        $('#summary-children').text($('#modal-children').val());
        $('#summary-infants').text($('#modal-infants').val());
        $('#summary-cabin').text($('#modal-cabin').val());
    }

    // Close modal
    $('.dcfb-close, .dcfb-modal').on('click', function(e) {
        if (e.target === this) $('#dcfb-modal').fadeOut();
    });

    // Submit contact form
    $('#dcfb-contact-form').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize() + '&action=dcfb_submit_booking&nonce=' + dcfb_ajax.nonce;
        $.post(dcfb_ajax.ajax_url, formData, function(res) {
            if (res.success) {
                alert(res.data);
                $('#dcfb-modal').fadeOut();
                $('#dcfb-contact-form')[0].reset();
            } else {
                alert('Error: ' + res.data);
            }
        }).fail(function() { alert('Server error. Please try again.'); });
    });
});