<?php
add_action('rest_api_init', function () {
    // Register route for all authors
    register_rest_route('v1', '/authors', [
        'methods' => 'GET',
        'callback' => 'get_all_authors',
    ]);

    // Register route for a single author by slug
    register_rest_route('v1', '/authors/(?P<slug>[a-zA-Z0-9-]+)', [
        'methods' => 'GET',
        'callback' => 'get_author_by_slug',
    ]);

    // Register route for similar authors with pagination
    register_rest_route('v1', '/similar_authors', [
        'methods' => 'GET',
        'callback' => 'get_similar_authors',
        'args' => [
            'per_page' => [
                'required' => false,
                'default' => 10,
                'validate_callback' => function ($param) {
                    return is_numeric($param) && $param > 0;
                },
            ],
            'page' => [
                'required' => false,
                'default' => 1,
                'validate_callback' => function ($param) {
                    return is_numeric($param) && $param > 0;
                },
            ],
        ],
    ]);
});

// Callback for getting all authors
function get_all_authors() {
    $args = [
        'post_type' => 'author',
        'posts_per_page' => -1,
    ];
    $query = new WP_Query($args);
    $authors = [];
    while ($query->have_posts()) {
        $query->the_post();
        $authors[] = [
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'slug' => get_post_field( 'post_name', get_post() ),
            'content' => get_the_content(),
            'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
            'meta' => [
                'location' => get_post_meta(get_the_ID(), 'location', true),
                'job' => get_post_meta(get_the_ID(), 'job', true),
                'sum_topics' => get_post_meta(get_the_ID(), 'sum_topics', true),
                'age' => get_post_meta(get_the_ID(), 'age', true),
                'facebook_link' => get_post_meta(get_the_ID(), 'facebook_link', true),
                'instagram_link' => get_post_meta(get_the_ID(), 'instagram_link', true),
                'telegram_link' => get_post_meta(get_the_ID(), 'telegram_link', true),
                'youtube_link' => get_post_meta(get_the_ID(), 'youtube_link', true),
            ],
        ];
    }
    wp_reset_postdata();

    return $authors;
}

// Callback for getting a single author by slug
function get_author_by_slug($request) {
    $slug = $request['slug'];
    $args = [
        'post_type' => 'author',
        'name' => $slug,
        'posts_per_page' => 1,
    ];
    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return new WP_Error('author_not_found', 'Author not found', ['status' => 404]);
    }

    $query->the_post();
    $author = [
        'id' => get_the_ID(),
        'title' => get_the_title(),
        'content' => get_the_content(),
        'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
        'meta' => [
            'location' => get_post_meta(get_the_ID(), 'location', true),
            'job' => get_post_meta(get_the_ID(), 'job', true),
            'sum_topics' => get_post_meta(get_the_ID(), 'sum_topics', true),
            'age' => get_post_meta(get_the_ID(), 'age', true),
            'facebook_link' => get_post_meta(get_the_ID(), 'facebook_link', true),
            'instagram_link' => get_post_meta(get_the_ID(), 'instagram_link', true),
            'telegram_link' => get_post_meta(get_the_ID(), 'telegram_link', true),
            'youtube_link' => get_post_meta(get_the_ID(), 'youtube_link', true),
        ],
    ];

    wp_reset_postdata();
    return $author;
}

// Callback for getting similar authors with pagination
function get_similar_authors($request) {
    $per_page = $request['per_page'];
    $page = $request['page'];

    $args = [
        'post_type' => 'author',
        'posts_per_page' => $per_page,
        'paged' => $page,
    ];
    $query = new WP_Query($args);

    $authors = [];
    while ($query->have_posts()) {
        $query->the_post();
        $authors[] = [
            'id' => get_the_ID(),
            'title' => get_the_title(),
            'slug' => get_post_field( 'post_name', get_post() ),
            'content' => get_the_content(),
            'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
            'meta' => [
                'location' => get_post_meta(get_the_ID(), 'location', true),
                'job' => get_post_meta(get_the_ID(), 'job', true),
                'sum_topics' => get_post_meta(get_the_ID(), 'sum_topics', true),
                'age' => get_post_meta(get_the_ID(), 'age', true),
                'facebook_link' => get_post_meta(get_the_ID(), 'facebook_link', true),
                'instagram_link' => get_post_meta(get_the_ID(), 'instagram_link', true),
                'telegram_link' => get_post_meta(get_the_ID(), 'telegram_link', true),
                'youtube_link' => get_post_meta(get_the_ID(), 'youtube_link', true),
            ],
        ];
    }
    wp_reset_postdata();

    return [
        'authors' => $authors,
        'total' => $query->found_posts,
        'pages' => $query->max_num_pages,
    ];
}
