jQuery(document).ready(function ($) {
    var timer = 0;

    $('#ajax-search-form').submit(function(e){
        e.preventDefault();
        search();
    });

    $('#custom-search').keyup(function() {
        search();
    });

    //clean result
    $('#search-clean').click(function() {
        $('#ajax_search_results').empty();
        $('#custom-search').val('');
        $('#search-clean').css('display', 'none');
    });

/*Ajax search posts*/
    function search(){
        let paramsSearch = $("#custom-search").val();
            clearTimeout(timer);
            timer = setTimeout(function () {
                if(paramsSearch.length > 1){
                    $.ajax({
                        data: {action: 'search_post', 'params_search':paramsSearch, 'nonce': ajax_var.nonce},
                        type: 'post',
                        url: ajax_var.url,
                        success: function(data) {
                            $('#ajax_search_results').empty().append(data);
                            $('#search-clean').css('display', 'block');
                        },
                        error : function(jqXHR, textStatus) {
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