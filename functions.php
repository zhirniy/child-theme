<?php
add_action( 'wp_enqueue_scripts', 'child_scripts' );
function child_scripts() {
    /* Add child style after parent */
    $parenthandle = 'twenty-twenty-one-style'; // This is 'twenty-twenty-one-style' for the Twenty Twenty-one theme.
    wp_enqueue_style( 'custom-style', get_stylesheet_uri(),
        array( $parenthandle ),
        wp_get_theme()->get('Version') // this only works if you have Version in the style header
    );
    /*end child style after parent*/

    wp_enqueue_script('jquery');
    wp_enqueue_script('script-js', get_stylesheet_directory_uri() . '/js/script.js',
        array('jquery'), null, true);

    wp_localize_script('script-js', 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    ));
}

/**
 * Search post by parameter.
 *  @uses $_POST['params_search']
 */
function search_post(){
    // Check for nonce security
    if ( ! wp_verify_nonce( $_POST['nonce'], 'ajax-nonce' ) ) {
        die ( 'Busted!');
    }

    $searchParams = (isset($_POST["params_search"])) ? $_POST["params_search"] : '';
    $searchParams = trim($searchParams);

    $args= array(
        'post_type' => 'post',
        'search_prod_title' => $searchParams,
        'post_status' => 'publish',
        'posts_per_page' => -1
    );

    $out ='';
    add_filter( 'posts_where', 'title_filter', 10, 2 );
    $loop = new WP_Query( $args );
    remove_filter( 'posts_where', 'title_filter');

    if ($loop -> have_posts()) :
        $out .= '<ul class="search-posts-items">';
        while ($loop -> have_posts()) : $loop -> the_post();
            $out .= '<li class="search-post-item">'.'<a class="search-post-link" href="'.get_permalink().'"  target="_blank">'.get_the_title().'</a></li>';
        endwhile;
        $out .= '</ul>';
    endif;
    wp_reset_postdata();

    die($out);
}

/**
 * Custom filter for search post title by parameter
 * var $where
 * var $wp_query
 * @return void
 */
function title_filter( $where, $wp_query ){
    global $wpdb;
    if ( $search_term = $wp_query->get( 'search_prod_title' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $search_term ) ) . '%\'';
    }
    return $where;
}

add_action('wp_ajax_nopriv_search_post', 'search_post');
add_action('wp_ajax_search_post', 'search_post');