<?php
function add_collection_meta_boxes() {
    add_meta_box('collection_details', 'Collection Details', 'render_collection_meta_box', 'collection');
}

function render_collection_meta_box($post) {
    // Example field for the collection category or order
    echo '<label for="collection_order">Order:</label>';
    echo '<input type="number" name="collection_order" value="' . get_post_meta($post->ID, 'collection_order', true) . '" />';
}

add_action('add_meta_boxes', 'add_collection_meta_boxes');
