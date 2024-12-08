<?php
// Register Status Taxonomy
function register_status_taxonomy() {
    $args = [
        'hierarchical'      => true,
        'labels'            => [
            'name'              => 'Statuses',
            'singular_name'     => 'Status',
            'search_items'      => 'Search Statuses',
            'all_items'         => 'All Statuses',
            'edit_item'         => 'Edit Status',
            'update_item'       => 'Update Status',
            'add_new_item'      => 'Add New Status',
            'new_item_name'     => 'New Status Name',
            'menu_name'         => 'Status',
        ],
        'show_ui'           => true,
        'show_in_menu'      => true,
        'show_in_rest'      => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'post_status'],
    ];

    // Register taxonomy for specified post types
    register_taxonomy('post_status', ['letter', 'podcast', 'author'], $args);
}

add_action('init', 'register_status_taxonomy');
