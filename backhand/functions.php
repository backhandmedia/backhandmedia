<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));

//remove new emoji code
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


global $wp_query;

//adds paginated links
$big = 999999999; // need an unlikely integer
$translated = __( 'Page', 'mytextdomain' ); // Supply translatable string

echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'show_all' => true,
	'current' => max( 1, get_query_var('paged') ),
	'total' => $wp_query->max_num_pages,
        'before_page_number' => '<span class="screen-reader-text">'.$translated.' </span>'
) );

//adds a custom image for sharing
function jeherve_custom_image( $media, $post_id, $args ) {
    if ( $media ) {
        return $media;
    } else {
        $permalink = get_permalink( $post_id );
        $url = apply_filters( 'jetpack_photon_url', 'http://www.backhandstories.com/wp-content/uploads/2016/07/fb_default.png' );
     
        return array( array(
            'type'  => 'image',
            'from'  => 'custom_fallback',
            'src'   => esc_url( $url ),
            'href'  => $permalink,
        ) );
    }
}
add_filter( 'jetpack_images_get_images', 'jeherve_custom_image', 10, 3 );

//adds a custom og & twitter description for non-post pages
function tweakjp_custom_twitter_site( $og_tags ) {
    if ( !(is_single()) ) {
    $og_tags['twitter:description'] = 'Backhand Stories is a creative writing blog that publishes new short stories, flash fiction, non-fiction and essays by new and unpublished writers. Submit your own short story!';
    $og_tags['twitter:card'] = 'summary';
    $og_tags['twitter:title'] = 'Backhand Stories. The Creative Writing Blog.';
    return $og_tags;
} else {
    return $og_tags;
}
}
add_filter( 'jetpack_open_graph_tags', 'tweakjp_custom_twitter_site', 11 );


 ?>
