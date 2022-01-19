<?php
/**
 * The custom template search form.
 */

$custom_id = 'custom-search';

$twentytwentyone_aria_label = ! empty( $args['aria_label'] ) ? 'aria-label="' . esc_attr( $args['aria_label'] ) . '"' : '';
?>
<form id="ajax-serach-form" role="search" <?php echo $twentytwentyone_aria_label; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?> method="get" class="search-form search-form-custom" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="<?php echo esc_attr( $custom_id ); ?>"><?php _e( 'Search&hellip;', 'twentytwentyone' ); // phpcs:ignore: WordPress.Security.EscapeOutput.UnsafePrintingFunction -- core trusts translations ?></label>
    <label for="<?php echo esc_attr( $custom_id ); ?>" id="search-clean" class="search-clean"></label>
    <input type="search" id="<?php echo esc_attr( $custom_id ); ?>" class="search-field custom-search-field" value="" name="s" />
    <input type="submit" class="search-submit search-submit-mob" value="<?php echo esc_attr_x( 'Search', 'submit button', 'twentytwentyone' ); ?>" />
</form>
<div id="ajax_search_results" class="ajax_search_results search-form">
</div>
