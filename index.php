<?php

// Display the header (partial template)
get_header();


// "The Loop" - output any content in WordPress as a catch all.
if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        // the_ type methods immediately output content when called
        the_post_thumbnail();
        the_content();
        the_title();
        the_author();
    endwhile;
else :
    _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
endif;

// Display the footer (partial template)
get_footer();

?>