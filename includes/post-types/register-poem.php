<?php
function register_poem_post_type() {
    $args = [
        'labels' => [
            'name' => 'Poems',
            'singular_name' => 'Poem',
        ],
        'public' => true,  // Ensure it's public and visible on the front-end
        'has_archive' => true,
        'supports' => ['title', 'editor', 'excerpt', 'author', 'thumbnail'],
        'show_ui' => true,  // Make sure UI is enabled
        'show_in_rest' => true, // Enable REST API support
        'rest_base' => 'poems', // REST API base route
        'rewrite' => ['slug' => 'poem'],
    ];

    register_post_type('poem', $args);
}

add_action('init', 'register_poem_post_type');
