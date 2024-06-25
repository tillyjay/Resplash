<?php
//display header (partial template)
get_header();

//get current author's ID
$author_id = get_the_author_meta('ID');

//get author's profile information
$avatar_src = get_avatar_url($author_id);
$display_name = get_the_author_meta('display_name', $author_id);
$nickname = get_the_author_meta('nickname', $author_id);
$email = get_the_author_meta('email', $author_id);
$biography = get_the_author_meta('description', $author_id);

//get posts by current author
$posts = get_posts(array(
    'author' => $author_id,
    //get all posts
    'numberposts' => -1, 
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC'
));
?>

<div class="author-profile container">
    <div class="author-info px-4 ">
        <div class="d-flex  mb-3 ">
            <img src="<?= $avatar_src ?>" class="post_profile_img">
            <div class="d-flex flex-column m-lg-2 ">
                <h2><?= $display_name ?></h2>
                <p class="d-flex"><?= $nickname ?></p>
            </div>
        </div>
        <div class="d-flex">
            <p><strong>Contact:</strong> <?= $email ?></p>
        </div>
        <div class="d-flex">
            <p class="bio"><?= $biography ?></p>
        </div>
        </div>
    </div>

    <div class="author-posts">
        <div class="pin-container">
            <?php foreach($posts as $post): ?>
                <?php
                $id = $post->ID;
                $photo_src = get_the_post_thumbnail_url($id, 'large');
                $post_url = get_permalink($id);
                ?>
                <div class="pin-box">
                    <a href="<?= $post_url ?>"></a>
                    <img src="<?= $photo_src ?>">
                    <div class="pin-caption">
                        <img src="<?= $avatar_src ?>">
                        <div><?= $display_name ?></div>
                    </div>  
                </div>
            <?php endforeach; ?>
        </div> 
    </div>
</div> 

<div class="container">
<?php

//display footer (partial template)
get_footer();

?>
</div>