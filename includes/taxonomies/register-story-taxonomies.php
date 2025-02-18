<?php
function register_story_taxonomies() {
    // Genre Taxonomy
    register_taxonomy('story_genre', 'story', array(
        'label'        => 'Genres',
        'rewrite'      => array('slug' => 'story-genre'),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));

    // Type Taxonomy (e.g., Serialized, One-shot)
    register_taxonomy('story_type', 'story', array(
        'label'        => 'Types',
        'rewrite'      => array('slug' => 'story-type'),
        'hierarchical' => true,
        'show_in_rest' => true,
    ));
}
add_action('init', 'register_story_taxonomies');
