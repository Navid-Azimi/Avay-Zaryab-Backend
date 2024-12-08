<?php
// Load all includes
require_once get_template_directory() . '/includes/loader.php';

add_theme_support('post-thumbnails');

function zariab_get_authors()
{
    return get_posts([
        'post_type'   => 'author',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby'     => 'title',
        'order'       => 'ASC',
    ]);
}
