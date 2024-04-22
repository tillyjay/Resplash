</div> <!-- div.container -->

<footer class="mt-5">
    <div class="container secondary-menu">
    <div class="row">
    <div class="col-md-6">
        <div class="copy">
            &copy; 2024 - <?= get_bloginfo("name") ?> - <?= get_bloginfo("description") ?>
        </div>
        </div>
        <div class="col-md-6">
        <div class="secondary">
            <?php
                $menu_items = wp_get_nav_menu_items('Secondary Menu');

                foreach ($menu_items as $menu_item) {
                    echo '<a class="nav-link" href="' . $menu_item->url . '">' . $menu_item->title . '</a>';
                }
            ?>
        </div>
        </div>
    </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
