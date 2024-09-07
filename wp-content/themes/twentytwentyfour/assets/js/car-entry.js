jQuery(document).ready(function($) {
    $('#car-entry-form').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('action', 'addweb_solution_car_entry_form_submission');
        formData.append('nonce', car_entry.nonce);

        $.ajax({
            url: car_entry.ajax_url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $('#form-response').html('<p>' + data.success + '</p>');
                    $('#car-entry-form')[0].reset();
                } else {
                    $('#form-response').html('<p>' + data.error + '</p>');
                }
            }
        });
    });
});
