<?php
function register_episode_post_type() {
    $labels = array(
        'name'               => 'Episodes',
        'singular_name'      => 'Episode',
        'add_new'            => 'Add New Episode',
        'add_new_item'       => 'Add New Episode',
        'edit_item'          => 'Edit Episode',
        'new_item'           => 'New Episode',
        'view_item'          => 'View Episode',
        'search_items'       => 'Search Episodes',
        'not_found'          => 'No episodes found',
        'all_items'          => 'All Episodes',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'supports'           => array('title', 'editor', 'custom-fields'),
        'menu_icon'          => 'dashicons-controls-play',
        'show_in_rest'       => true,
        'rewrite'            => array('slug' => 'episodes'),
    );

    register_post_type('episode', $args);
}
add_action('init', 'register_episode_post_type');
