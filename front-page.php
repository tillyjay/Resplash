<?php
// Display the header (partial template)
get_header();

// Get all categories
$categories = get_categories();

// Loop through each category
foreach ($categories as $category) {
    // Get posts in the current category
    $posts_in_category = get_posts(array(
        'numberposts' => -1,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'category' => $category->term_id
    ));

    // Ensure there are posts in the category
    if ($posts_in_category) {
        // Split the posts into post 0 and posts 1-3
        $post_0 = array_shift($posts_in_category); // Most recent post
        $posts_1_to_3 = array_slice($posts_in_category, 0, 3); // Remaining 3 posts
?>

        <div class="front-page-container">
            <h1 id="front-category-title"><?php echo $category->name; ?></h1>
            <div class="row">
                <div class="col-md-6 featured-post gx-3">
                    <!-- Left Column - Featured Post -->
                    <div class="post-thumbnail">
                        <a href="<?php echo get_permalink($post_0->ID); ?>"><?php echo get_the_post_thumbnail($post_0->ID, 'large'); ?></a>
                        <div class="post-caption">
                            <div class="post-title"><a href="<?php echo get_permalink($post_0->ID); ?>"><?php echo $post_0->post_title; ?></a></div>
                            <div class="post-meta">
                                <div class="author-info">
                                    <div class="author-avatar"><?php echo get_avatar(get_the_author_meta('ID', $post_0->post_author), 96); ?></div>
                                    <div class="author-name"><div class="by">by </div><?php echo get_the_author_meta('display_name', $post_0->post_author); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 recent-posts">
                    <!-- Right Column - Posts 1-3 -->
                    <ul>
                        <?php foreach ($posts_1_to_3 as $post) : setup_postdata($post); ?>
                            <div class="right-col-group">
                                <li class="post-titles-front"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <li>by <?php the_author(); ?></li>
                            </div>
                        <?php endforeach;
                        wp_reset_postdata(); ?>
                    </ul>
                </div>
            </div>
        </div>

<?php
    } // end if $posts_in_category
} // end foreach $categories

// Display the footer (partial template)
get_footer();
?>
