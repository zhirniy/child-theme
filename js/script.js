jQuery(document).ready(function ($) {
    const ajaxurl = '/wp-admin/admin-ajax.php';

    var timer = 0;

    $('#ajax-serach-form').submit(function(e){
        e.preventDefault();
        search();
    });

    $('#custom-search').keyup(function(e) {
        search();
    });

    //clean result
    $('#search-clean').click(function(e) {
        $('#ajax_search_results').empty();
        $('#custom-search').val('');
        $('#search-clean').css('display', 'none');
    });

/*Ajax search posts*/
    function search(){
        var paramsSearch = $("#custom-search").val();
            clearTimeout(timer);
            timer = setTimeout(function () {
                if(paramsSearch.length > 1){
                    $.ajax({
                        data: {action: 'search_post', 'params_search':paramsSearch},
                        type: 'post',
                        url: ajaxurl,
                        success: function(data) {
                            $('#ajax_search_results').empty().append(data);
                            $('#search-clean').css('display', 'block');
                        },
                        error : function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus);
                        },
                    });
                }else {
                    $('#ajax_search_results').empty();
                    $('#search-clean').css('display', 'none');
                }
            }, 1000 || 0);
    }

});