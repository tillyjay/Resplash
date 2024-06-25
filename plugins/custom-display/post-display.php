<?php
/*
Plugin Name: Post Display
Description: This is a plugin that displays the author's name and avatar with a hover effect showing the last three post by that author. It also displays below the post any other posts that have related tags.
Author: Tilly Jay
Version: 1.0
*/

//enqueue Bootstrap CSS
function enqueue_bootstrap_css() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/[email protected]/dist/css/bootstrap.min.css');
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_css');

//enqueue Bootstrap JavaScript
function enqueue_bootstrap_js() {
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/[email protected]/dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap_js');


//FILTER HOOK - display author's name and avatar with hover effect
function display_author_filter($display_name) {

    //global $post object used to access current post's data
    global $post;
    //get the author's ID from current post
    $author_id = $post->post_author;
    //retrieve author's information using ID
    $author_info = get_userdata($author_id);
    //generate URL for author's posts
    $author_url = get_author_posts_url($author_id);
    //get author's avatar.
    $author_avatar = get_avatar($author_id, 60, '', '', array('class' => 'avatar-img'));

    //fetch 3 most recent posts by author
    $args = array(
        'author' => $author_id,
        'posts_per_page' => 3,
    );
    $recent_posts = get_posts($args);

    //start output for hover content
    ob_start();
    ?>
    <div class="author-hover-content ">
    <div class="author-details-hover">
<?php if ($author_avatar): ?>
    <div class="author-avatar">
        <a href="<?php echo esc_url($author_url); ?>">
            <?php echo $author_avatar; ?>
        </a>
    </div>
    <div class="author-links">
    <h4>
        <a href="<?php echo esc_url($author_url); ?>">
            <?php echo esc_html($author_info->display_name); ?>
        </a>
    </h4>
    <p class="author-nickname-hover">
            <a href="<?php echo esc_url($author_url); ?>">
                <?php echo esc_html(get_the_author_meta('nickname', $author_id)); ?>
            </a>
        </p>
        </div>
    </div>
    
<?php endif; ?>
    </div>
        <div class="author-posts">
        <?php foreach ($recent_posts as $post): ?>
    <a href="<?php echo esc_url(get_permalink($post->ID)); ?>">
        <?php 
        //check if the post has a thumbnail
        if (has_post_thumbnail($post->ID)) {
        //display post thumbnail
            echo get_the_post_thumbnail($post->ID, 'thumbnail');
        }
        ?>
    </a>
<?php endforeach; ?>
        </div>
        <div class="view-profile">
        <a href="<?php echo esc_url($author_url); ?>">View Profile</a>
        </div>
    </div>
    <?php

    //end hover content output
    $hover_content = ob_get_clean();
    wp_reset_postdata();

    //check if author has an avatar
    if ($author_avatar) {

    //prepend author's avatar to display name
        $display_name = $author_avatar . ' ';
    } else {
    //if no avatar, clear display name
        $display_name = '';
    }
    
    //wrap author's name and nickname
    $display_name .= '<div class="author-details">';
    //add the author's display name and nickname, linked to their posts
    $display_name .= '<a href="' . esc_url($author_url) . '" class="author-link">' . esc_html($author_info->display_name) . '</a>';
    $display_name .= '<br>' . '<a href="' . esc_url($author_url) . '" class="author-nickname">' . esc_html(get_the_author_meta('nickname', $author_id)) . '</a>';
    $display_name .= '</div>';
    
    //wrap display name that will contain hover content
    $display_name = '<div class="author-container">' . $display_name . '<div class="author-hover-wrapper">' . $hover_content . '</div></div>';
    
    //return modified display name
    return $display_name;
}
add_filter('the_author', 'display_author_filter');



//ACTION HOOK - display related posts with related tags
function display_related_posts() {

    //check if current page is an author or front page.
    if (is_author() || is_front_page()) {
        //if yes, exit function early to prevent related posts from being displayed
        return;
    }

    //global $post object is used to access current post's data
    global $post;
    //global variable to prevent displaying related posts multiple times
    global $displayed_related_posts;

    //check if related posts have already been displayed
    if (isset($displayed_related_posts) && $displayed_related_posts) {
        return;
    }

    // Get tags associated with current post
    $tags = wp_get_post_tags($post->ID);

    //if post has tags, proceed to fetch related posts
    if ($tags) {

        //prepare an array of tag IDs
        $tag_ids = array();
        foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        //define arguments for fetching related posts
        $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            //set 'posts_per_page' to -1 to fetch all matching posts
            'posts_per_page' => -1,
        );

        //fetch related posts based on args
        $related_posts = get_posts($args);

        //if related posts are found, display them
        if ($related_posts) {
            echo '<h3 class="mt-5">Related</h3>';
            echo '<div class="pin-container">';
            foreach ($related_posts as $post) {
                setup_postdata($post);
                $thumbnail_url = get_the_post_thumbnail_url($post->ID);
                $author_id = $post->post_author;
                $author_avatar = get_avatar_url($author_id);
                $author_name = get_the_author_meta('display_name', $author_id);
                ?>
                <div class="pin-box">
                    <a href="<?php the_permalink(); ?>"></a>
                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php the_title_attribute(); ?>">
                    <div class="pin-caption">
                        <img src="<?php echo esc_url($author_avatar); ?>">
                        <div><?php echo esc_html($author_name); ?></div>
                    </div>  
                </div>
                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        }
    }

    //mark related posts as displayed to prevent duplicate display
    $displayed_related_posts = true;
}
add_action('wp_footer', 'display_related_posts');



//CSS styles 
//display author filter hook styles
function enqueue_author_displays_css() {
    wp_enqueue_style('author-displays', plugins_url('/author-displays.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'enqueue_author_displays_css');

//display related posts action hook styles
function enqueue_related_displays_css() {
    wp_enqueue_style('related-displays', plugins_url('/related-displays.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'enqueue_related_displays_css');

?>