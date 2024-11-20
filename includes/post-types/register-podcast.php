<?php

function register_podcast_post_type()
{
    register_post_type('podcast', [
        'labels' => [
            'name' => __('Podcasts'),
            'singular_name' => __('Podcast'),
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'], // Supports content, title, and featured image
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-microphone',
    ]);
}

add_action('init', 'register_podcast_post_type');


function podcast_meta_boxes()
{
    add_meta_box(
        'podcast_details',
        'Podcast Details',
        'render_podcast_meta_box',
        'podcast',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'podcast_meta_boxes');


function save_podcast_meta_box($post_id)
{
    if (!isset($_POST['podcast_meta_nonce']) || !wp_verify_nonce($_POST['podcast_meta_nonce'], 'save_podcast_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = [
        'host_name',
        'guest_name',
        'audio_file',
        'podcast_date_shamsi',
        'podcast_duration',
    ];

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post_podcast', 'save_podcast_meta_box');

