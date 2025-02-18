<?php
function register_story_post_type() {
    $labels = array(
        'name'               => 'Stories',
        'singular_name'      => 'Story',
        'add_new'            => 'Add New Story',
        'add_new_item'       => 'Add New Story',
        'edit_item'          => 'Edit Story',
        'new_item'           => 'New Story',
        'view_item'          => 'View Story',
        'search_items'       => 'Search Stories',
        'not_found'          => 'No stories found',
        'all_items'          => 'All Stories',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'hierarchical'       => true,
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon'          => 'dashicons-book',
        'show_in_rest'       => true,
        'rewrite'            => array('slug' => 'stories'),
    );

    register_post_type('story', $args);
}
add_action('init', 'register_story_post_type');
