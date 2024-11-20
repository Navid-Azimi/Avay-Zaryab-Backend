<?php

add_action('rest_api_init', function () {
    // Endpoint: List all podcasts
    register_rest_route('v1', '/podcasts', [
        'methods' => 'GET',
        'callback' => 'get_all_podcasts',
    ]);

    // Endpoint: Single podcast by slug
    register_rest_route('v1', '/podcast/(?P<slug>[a-zA-Z0-9-]+)', [
        'methods' => 'GET',
        'callback' => 'get_podcast_by_slug',
    ]);

    // Endpoint: Similar podcasts excluding a provided slug
    register_rest_route('v1', '/podcasts/similar/(?P<slug>[a-zA-Z0-9-]+)', [
        'methods' => 'GET',
        'callback' => 'get_similar_podcasts',
        'args' => [
            'per_page' => [
                'required' => false,
                'default' => 10,
                'validate_callback' => function ($param) {
                    return is_numeric($param) && $param > 0;
                },
            ],
        ],
    ]);
});

// Callback: List all podcasts
function get_all_podcasts()
{
    $args = [
        'post_type' => 'podcast',
        'posts_per_page' => -1,
    ];
    $query = new WP_Query($args);
    $podcasts = [];
    while ($query->have_posts()) {
        $query->the_post();
        $podcasts[] = [
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'slug' => get_post_field('post_name', get_the_ID()),
            'content' => get_the_content(),
            'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
            'meta' => [
                'host_name' => get_post_meta(get_the_ID(), 'host_name', true),
                'guest_name' => get_post_meta(get_the_ID(), 'guest_name', true),
                'audio_file' => get_post_meta(get_the_ID(), 'audio_file', true),
                'podcast_date_shamsi' => get_post_meta(get_the_ID(), 'podcast_date_shamsi', true),
                'podcast_duration' => get_post_meta(get_the_ID(), 'podcast_duration', true),
            ],
        ];
    }
    wp_reset_postdata();
    return $podcasts;
}

// Callback: Single podcast by slug
function get_podcast_by_slug($request)
{
    $slug = $request['slug'];
    $args = [
        'post_type' => 'podcast',
        'name' => $slug,
        'posts_per_page' => 1,
    ];
    $query = new WP_Query($args);
    if (!$query->have_posts()) {
        return new WP_Error('podcast_not_found', 'Podcast not found', ['status' => 404]);
    }

    $query->the_post();
    $podcast = [
        'id' => get_the_ID(),
        'title' => get_the_title(),
        'slug' => get_post_field('post_name', get_the_ID()),
        'content' => get_the_content(),
        'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
        'meta' => [
            'host_name' => get_post_meta(get_the_ID(), 'host_name', true),
            'guest_name' => get_post_meta(get_the_ID(), 'guest_name', true),
            'audio_file' => get_post_meta(get_the_ID(), 'audio_file', true),
            'podcast_date_shamsi' => get_post_meta(get_the_ID(), 'podcast_date_shamsi', true),
            'podcast_duration' => get_post_meta(get_the_ID(), 'podcast_duration', true),  ],
    ];
    wp_reset_postdata();
    return $podcast;
}

// Callback: Similar podcasts excluding the provided slug
function get_similar_podcasts($request)
{
    $slug = $request['slug'];
    $per_page = $request['per_page'];

    $args = [
        'post_type' => 'podcast',
        'posts_per_page' => $per_page,
        'post__not_in' => [get_page_by_path($slug, OBJECT, 'podcast')->ID],
    ];
    $query = new WP_Query($args);
    $podcasts = [];
    while ($query->have_posts()) {
        $query->the_post();
        $podcasts[] = [
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'slug' => get_post_field('post_name', get_the_ID()),
            'content' => get_the_content(),
            'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
            'meta' => [
                'host_name' => get_post_meta(get_the_ID(), 'host_name', true),
                'guest_name' => get_post_meta(get_the_ID(), 'guest_name', true),
                'audio_file' => get_post_meta(get_the_ID(), 'audio_file', true),
                'podcast_date_shamsi' => get_post_meta(get_the_ID(), 'podcast_date_shamsi', true),
                'podcast_duration' => get_post_meta(get_the_ID(), 'podcast_duration', true),    ],
        ];
    }
    wp_reset_postdata();
    return $podcasts;
}
