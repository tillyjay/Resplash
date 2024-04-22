<?php
// Display the header (partial template)
get_header();

// Enqueue the CSS file
wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/styles.css');


// Check if there are posts
if (have_posts()) {
    // Loop through each post
    while (have_posts()) {
        the_post(); ?>
        <div class="single-container">
        <div class="post-item mb-1">
            <?php the_post_thumbnail('large', array('class' => 'full-width-thumbnail')); ?>
            <h2 class="post-title mt-4 mb-3"><?php the_title(); ?></h2>
            <div class="post-meta">
                <div class="author-info">
                <div class="author-avatar"><?php echo get_avatar(get_the_author_meta('ID'), 50); ?></div>
                    <div class="author-name"><?php the_author(); ?></div>
                </div>
                <div class="post-date"><?php echo get_the_date(); ?></div>
            </div>
            <div class="post-excerpt mt-3 mb-3"><?php the_excerpt(); ?></div>
            <div class="post-content mt-4 "><?php the_content(); ?></div>
            </div>
            <?php
            // Display categories
   
            $categories = get_the_category();
            if ($categories) {
                echo '<div class="post-categories">';
                foreach ($categories as $category) {
                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="link-secondary text-decoration-none">' . esc_html($category->name) . '</a>';
                }
                echo '</div>'; 
            }

            // Display tags
            $tags = get_the_tags();
            if ($tags) {
                echo '<div class="post-tags">';

                foreach ($tags as $tag) {
                    echo '<span class="badge rounded-pill text-bg-light">';
                    echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="link-secondary text-decoration-none">' . esc_html($tag->name) . '</a>';
                    echo '</span>';
                }
                echo '</div>';
            }
            ?>
            </div>
        </div>
    </div>
<?php }
}

// Reset post data
wp_reset_postdata();

// Display the footer (partial template)
get_footer();
?>
