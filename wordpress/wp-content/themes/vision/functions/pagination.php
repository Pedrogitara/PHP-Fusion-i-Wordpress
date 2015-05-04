<?php

if ( ! function_exists( 'vision_round_num' ) ) :
  function vision_round_num( $num, $to_nearest ) {
    return floor( $num / $to_nearest ) * $to_nearest;
  }
endif;



// Pagination
// =============================================================================

if ( ! function_exists( 'vision_pagenavi' ) ) :
    function vision_pagenavi(){
    global $wp_query;

    $big = 999999999;

    echo paginate_links( array(
      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'format' => '?paged=%#%',
      'current' => max( 1, get_query_var('paged') ),
      'total' => $wp_query->max_num_pages
    ) );

      }
endif;



// Posts Link Attributes
// =============================================================================

if ( ! function_exists( 'vision_posts_link_attributes' ) ) :
  function vision_posts_link_attributes() {
    return 'class="prev-next hidden-phone"';
  }

  add_filter( 'next_posts_link_attributes', 'vision_posts_link_attributes' );
  add_filter( 'previous_posts_link_attributes', 'vision_posts_link_attributes' );
endif;