<?php
// Register Poem Collection Taxonomy
function register_poem_collection_taxonomy()
{
    $labels = [
        'name' => 'Collections',
        'singular_name' => 'Collection',
        'search_items' => 'Search Collections',
        'all_items' => 'All Collections',
        'edit_item' => 'Edit Collection',
        'update_item' => 'Update Collection',
        'add_new_item' => 'Add New Collection',
        'new_item_name' => 'New Collection Name',
        'menu_name' => 'Collections',
    ];

    $args = [
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'collection'],
    ];

    register_taxonomy('collection', 'poem', $args);
}

// Register Poem Categories Taxonomy
function register_poem_categories_taxonomy()
{
    $labels = [
        'name' => 'Categories',
        'singular_name' => 'Category',
        'search_items' => 'Search Categories',
        'all_items' => 'All Categories',
        'edit_item' => 'Edit Category',
        'update_item' => 'Update Category',
        'add_new_item' => 'Add New Category',
        'new_item_name' => 'New Category Name',
        'menu_name' => 'Categories',
    ];

    $args = [
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'poem-category'],
    ];

    register_taxonomy('poem_category', 'poem', $args);
}

add_action('init', 'register_poem_collection_taxonomy');
add_action('init', 'register_poem_categories_taxonomy');
