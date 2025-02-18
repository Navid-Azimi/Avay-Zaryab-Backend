<?php
/**
 * Retrieves a list of poems with pagination support.
 *
 * This function queries the 'poem' post type and returns a paginated list of poems.
 * It includes details such as the poem's title, excerpt, author information, featured image,
 * publication date, reading time, categories, and slug.
 *
 * @param array $data An associative array containing query parameters.
 *                    - 'per_page' (int): The number of poems to return per page. Defaults to 10.
 *                    - 'page' (int): The page number to retrieve. Defaults to 1.
 *
 * @return array An associative array containing:
 *               - 'current_page' (int): The current page number.
 *               - 'total_pages' (int): The total number of pages available.
 *               - 'total_posts' (int): The total number of poems found.
 *               - 'poems' (array): An array of poems, each containing:
 *                   - 'ID' (int): The poem ID.
 *                   - 'title' (string): The poem title.
 *                   - 'excerpt' (string): The poem excerpt.
 *                   - 'author' (array|null): The author details or null if not available.
 *                   - 'author_id' (int): The ID of the post author.
 *                   - 'featured_image' (string|null): The URL of the featured image or null if not available.
 *                   - 'shamsi_date' (string|null): The publication date in Shamsi calendar or null if not available.
 *                   - 'time' (string|null): The estimated reading time or null if not available.
 *                   - 'categories' (array): An array of category names.
 *                   - 'slug' (string): The poem slug.
 */
function get_poems_list($data)
{
    // Get the per_page and page parameters from the request
    $per_page = isset($data['per_page']) ? intval($data['per_page']) : 10; // Default to 10 items per page
    $page = isset($data['page']) ? intval($data['page']) : 1; // Default to page 1 if not set

    // Set up query arguments
    $args = [
        'post_type' => 'poem',
        'posts_per_page' => $per_page,
        'paged' => $page,
//        'post_status' => 'publish', // Only get published poems
    ];

    // Run the query
    $poems_query = new WP_Query($args);

    // Get the total number of pages
    $total_pages = $poems_query->max_num_pages;

    // Prepare the data to return
    $poems = [];
    if ($poems_query->have_posts()) {
        while ($poems_query->have_posts()) {
            $poems_query->the_post();


            // Get the related author information (assuming 'poem_author' is a custom field linking to author post)
            $author_id = get_post_meta(get_the_ID(), '_poem_author', true);
            $author = null;

            // If we have an author ID, get the author post details
            if ($author_id) {
                $author_post = get_post($author_id);
                $author = [
                    'ID' => $author_post->ID,
                    'name' => $author_post->post_title,
                    'slug' => $author_post->post_name,
                    'excerpt' => get_the_excerpt($author_post),
                    'location' => get_post_meta($author_post->ID, 'location', true),
                    'job' => get_post_meta($author_post->ID, 'job', true),
                    'age' => get_post_meta($author_post->ID, 'age', true),
                    'facebook_link' => get_post_meta($author_post->ID, 'facebook_link', true),
                    'instagram_link' => get_post_meta($author_post->ID, 'instagram_link', true),
                    'telegram_link' => get_post_meta($author_post->ID, 'telegram_link', true),
                    'youtube_link' => get_post_meta($author_post->ID, 'youtube_link', true), 'featured_image' => get_the_post_thumbnail_url($author_post),
                ];
            }

            $content = apply_filters('the_content', get_the_content());
            $content_array = explode('<br />', $content);

            // Get poem details
            $poem = [
                'ID' => get_the_ID(),
                'title' => get_the_title(),
                'content_array' => $content_array,
                'author' => $author,
                'author_id' => get_post_field('post_author', get_the_ID()),
                'featured_image' => get_the_post_thumbnail_url(),
                'shamsi_date' => get_post_meta(get_the_ID(), '_publish_date', true),
                'time' => get_post_meta(get_the_ID(), '_read_time', true),
                'categories' => wp_get_post_terms(get_the_ID(), 'poem_category', ['fields' => 'names']),
                'slug' => get_post_field('post_name', get_the_ID())
            ];
            $poems[] = $poem;
        }
    }

    // Return the response with pagination data
    return [
        'current_page' => $page,
        'total_pages' => $total_pages,
        'total_posts' => $poems_query->found_posts,
        'poems' => $poems,
    ];
}


function register_poem_api_endpoints()
{
    register_rest_route('v1', '/poems/', [
        'methods' => 'GET',
        'callback' => 'get_poems_list',
        'args' => [
            'page' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param) && $param > 0;
                },
            ],
            'per_page' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param) && $param > 0;
                },
            ],
        ],
    ]);
}

add_action('rest_api_init', 'register_poem_api_endpoints');


function get_single_poem_by_slug($data)
{
    // Get the slug from the URL
    $poem_slug = $data['slug'];

    // Query the poem by slug
    $args = [
        'post_type' => 'poem',
        'name' => $poem_slug,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ];

    // Run the query to fetch the poem
    $poem_query = new WP_Query($args);

    // Check if we found the poem
    if ($poem_query->have_posts()) {
        $poem_query->the_post();

        

        // Get the related author information (assuming 'poem_author' is a custom field linking to author post)
        $author_id = get_post_meta(get_the_ID(), '_poem_author', true);
        $author = null;

        // If we have an author ID, get the author post details
        if ($author_id) {
            $author_post = get_post($author_id);
            $author = [
                'ID' => $author_post->ID,
                'name' => $author_post->post_title,
                'slug' => $author_post->post_name,
                'excerpt' => get_the_excerpt($author_post),
                'location' => get_post_meta($author_post->ID, 'location', true),
                'job' => get_post_meta($author_post->ID, 'job', true),
                'age' => get_post_meta($author_post->ID, 'age', true),
                'facebook_link' => get_post_meta($author_post->ID, 'facebook_link', true),
                'instagram_link' => get_post_meta($author_post->ID, 'instagram_link', true),
                'telegram_link' => get_post_meta($author_post->ID, 'telegram_link', true),
                'youtube_link' => get_post_meta($author_post->ID, 'youtube_link', true), 'featured_image' => get_the_post_thumbnail_url($author_post),
            ];
        }

        // Get poem details
        $poem = [
            'ID' => get_the_ID(),
            'title' => get_the_title(),
            'excerpt' => get_the_excerpt(),
            'author' => $author, // Including the author information
            'featured_image' => get_the_post_thumbnail_url(),
            'shamsi_date' => get_post_meta(get_the_ID(), '_publish_date', true),
            'time' => get_post_meta(get_the_ID(), '_read_time', true),
            'categories' => get_poem_categories(get_the_ID()), // Including category details
            'content' => apply_filters('the_content', get_the_content()), // Rich content in HTML format
            'slug' => get_post_field('post_name', get_the_ID())
        ];

        // Return the poem data
        return $poem;
    } else {
        return new WP_Error('no_poem', 'Poem not found', ['status' => 404]);
    }
}

// Get categories for the poem with slug, count, and title
function get_poem_categories($poem_id)
{
    $terms = wp_get_post_terms($poem_id, 'poem_category');

    $category_data = [];
    foreach ($terms as $term) {
        $category_data[] = [
            'slug' => $term->slug,
            'count' => $term->count,
            'title' => $term->name
        ];
    }

    return $category_data;
}


function register_single_poem_api_endpoint()
{
    register_rest_route('v1', '/poem/(?P<slug>[a-zA-Z0-9-]+)', [
        'methods' => 'GET',
        'callback' => 'get_single_poem_by_slug',
    ]);
}

add_action('rest_api_init', 'register_single_poem_api_endpoint');



function get_similar_poems($data) {
    // Get the slug of the current poem
    $current_poem_slug = $data['slug'];

    // Query the current poem to get its ID and categories
    $args = [
        'post_type' => 'poem',
        'name' => $current_poem_slug,
        'posts_per_page' => 1,
    ];

    // Run the query to fetch the poem
    $current_poem_query = new WP_Query($args);

    // If no poem is found, return an error
    if (!$current_poem_query->have_posts()) {
        return new WP_Error('no_poem', 'Poem not found', ['status' => 404]);
    }

    // Get the current poem's ID and categories
    $current_poem = $current_poem_query->posts[0];
    $poem_categories = wp_get_post_terms($current_poem->ID, 'poem_category', ['fields' => 'ids']);

    // Get pagination arguments
    $per_page = isset($data['per_page']) ? intval($data['per_page']) : 10; // Default 10
    $page = isset($data['page']) ? intval($data['page']) : 1; // Default to page 1

    // Query for similar poems based on the same categories but exclude the current poem by slug
    $args = [
        'post_type' => 'poem',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'post__not_in' => [$current_poem->ID], // Exclude current poem
        'tax_query' => [
            [
                'taxonomy' => 'poem_category',
                'field'    => 'id',
                'terms'    => $poem_categories, // Filter by the current poem's categories
                'operator' => 'IN',
            ],
        ],
    ];

    // Run the query to get similar poems
    $similar_poems_query = new WP_Query($args);

    // Check if we have similar poems
    if (!$similar_poems_query->have_posts()) {
        return new WP_Error('no_similar_poems', 'No similar poems found', ['status' => 404]);
    }

    // Prepare the response data
    $similar_poems = [];
    while ($similar_poems_query->have_posts()) {
        $similar_poems_query->the_post();

        // Get the author
        $author_id = get_post_meta(get_the_ID(), '_poem_author', true);
        $author_name = $author_id ? get_the_author_meta('display_name', $author_id) : 'Unknown';

        // Get categories
        $categories = get_poem_categories(get_the_ID());

        $content = apply_filters('the_content', get_the_content());
        $content_array = explode('<br />', $content);
        // Prepare poem data
        $similar_poems[] = [
            'featured_image' => get_the_post_thumbnail_url(),
            'slug' => get_post_field('post_name', get_the_ID()),
            'title' => get_the_title(),
            'content_array' => $content_array,
            'author' => $author_name,
            'shamsi_date' => get_post_meta(get_the_ID(), '_publish_date', true),
            'time' => get_post_meta(get_the_ID(), '_read_time', true),
            'poem_categories' => $categories,
        ];
    }

    // Reset the post data after custom query
    wp_reset_postdata();

    // Prepare pagination data
    $pagination = [
        'total' => $similar_poems_query->found_posts,
        'per_page' => $per_page,
        'current_page' => $page,
        'total_pages' => $similar_poems_query->max_num_pages,
    ];

    // Return the response with poems and pagination info
    return [
        'similar_poems' => $similar_poems,
        'pagination' => $pagination,
    ];
}

// Register the similar poems API endpoint
function register_similar_poems_api_endpoint() {
    register_rest_route('v1', '/similar-poems/(?P<slug>[a-zA-Z0-9-]+)', [
        'methods' => 'GET',
        'callback' => 'get_similar_poems',
        'args' => [
            'per_page' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ],
            'page' => [
                'validate_callback' => function ($param, $request, $key) {
                    return is_numeric($param);
                }
            ],
        ]
    ]);
}

add_action('rest_api_init', 'register_similar_poems_api_endpoint');


