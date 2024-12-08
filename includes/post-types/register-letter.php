<?php
// Register "Letter" Post Type
function register_letter_post_type()
{
    $labels = array(
        'name' => 'Letters',
        'singular_name' => 'Letter',
        'add_new' => 'Add New Letter',
        'add_new_item' => 'Add New Letter',
        'edit_item' => 'Edit Letter',
        'new_item' => 'New Letter',
        'view_item' => 'View Letter',
        'search_items' => 'Search Letters',
        'not_found' => 'No Letters found',
        'not_found_in_trash' => 'No Letters found in Trash',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-media-document',
        'rewrite' => array('slug' => 'letters'),
        'supports' => array('title', 'editor', 'thumbnail'),
        'show_in_rest' => true,
    );

    register_post_type('letter', $args);
}

add_action('init', 'register_letter_post_type');
