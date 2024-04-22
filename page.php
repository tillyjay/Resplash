<?php
get_header(); ?>

<div class="page-container container">
    <div id="content" role="main">

        <?php while ( have_posts() ) : the_post(); ?>
            <header class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1> <!-- Page Title -->
            </header>

            <div class="entry-content">
                <?php the_content(); ?> 
            </div>

        <?php endwhile; ?>

    </div>
</div>

<?php
get_footer();
?>