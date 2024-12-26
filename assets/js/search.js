$(document).ready(function() {
    $('#query').on('input', function() {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: '/shoppink/controller/user/search.php',
                type: 'GET',
                data: { query: query },
                success: function(data) {
                    if (data.trim().length > 0) {
                        $('#results-container').html(data).show();
                    } else {
                        $('#results-container').text("No results").show();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error: ' + textStatus + ': ' + errorThrown);
                }
            });
        }
         else {
            $('#results-container').hide();
        }
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('.search-box, #results-container').length) {
            $('#results-container').hide();
        }
    });
});
