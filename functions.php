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


add_action('init', 'register_story_post_type', 5);  // Higher priority to load early
add_action('init', 'register_poem_post_type', 5);

add_action('add_meta_boxes', 'add_episode_meta_box', 15);  // Lower priority
