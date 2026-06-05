jQuery(document).ready(function($) {
    // Airport autocomplete
    var airports = dcfb_ajax.airports;
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
        select: function(event, ui) {
            $(this).data('full', ui.item.full);
        }
    });

    // Date picker
    flatpickr('.dcfb-depart, .dcfb-return', {
        dateFormat: 'Y-m-d',
        minDate: 'today'
    });
    $('.dcfb-depart').on('change', function() {
        var depart = $(this).val();
        $('.dcfb-return').flatpickr({ minDate: depart });
    });

    // Trip type toggle
    $('input[name="trip_type"]').on('change', function() {
        if ($(this).val() === 'oneway') {
            $('.dcfb-return-group').hide();
        } else {
            $('.dcfb-return-group').show();
        }
    });

    // Open modal on search
    $('#dcfb-search-form').on('submit', function(e) {
        e.preventDefault();
        // Validate fields
        if (!$('.dcfb-origin').val() || !$('.dcfb-destination').val() || !$('.dcfb-depart').val()) {
            alert('Please fill origin, destination and departure date.');
            return;
        }
        // Populate modal hidden fields with search data
        $('#modal-origin').val($('.dcfb-origin').val());
        $('#modal-dest').val($('.dcfb-destination').val());
        $('#modal-depart').val($('.dcfb-depart').val());
        $('#modal-return').val($('.dcfb-return').val());
        $('#modal-trip_type').val($('input[name="trip_type"]:checked').val());
        $('#modal-adults').val($('.dcfb-adults').val());
        $('#modal-children').val($('.dcfb-children').val());
        $('#modal-infants').val($('.dcfb-infants').val());
        $('#modal-cabin').val($('.dcfb-cabin').val());
        $('#dcfb-modal').fadeIn();
    });

    $('.dcfb-close, .dcfb-modal').on('click', function(e) {
        if (e.target === this) $('#dcfb-modal').fadeOut();
    });

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
        }).fail(function() {
            alert('Server error. Please try again.');
        });
    });
});