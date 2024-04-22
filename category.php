<?php
// Display the header (partial template)
get_header();
?>

<div class="category-container">
    <h1 class="category-title"><?php single_cat_title(); ?></h1>
    <?php
    // Get posts in the current category
    $posts_in_category = get_posts(array(
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'category' => get_query_var('cat') // Get current category ID
    ));

    // Loop through each post in the category
    foreach ($posts_in_category as $post) {
        setup_postdata($post); ?>
        <div class="post-item">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large', array('class' => 'full-width-thumbnail')); ?></a>
            <h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="post-excerpt"><?php the_excerpt(); ?></div>
            <div class="post-meta">
                <div class="author-info">
                <div class="author-avatar"><?php echo get_avatar(get_the_author_meta('ID'), 50); ?></div>
                    <div class="author-name"><?php the_author(); ?></div>
                </div>
                <div class="post-date"><?php echo get_the_date(); ?></div>
            </div>
        </div>
    <?php }
    // Reset post data
    wp_reset_postdata();
    ?>
</div>



<?php
// Display the footer (partial template)
get_footer();
?>