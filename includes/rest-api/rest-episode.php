<?php
function add_episode_rest_fields() {
    register_rest_field('episode', 'collection_id', [
        'get_callback' => function ($object) {
            return get_post_meta($object['id'], 'collection_id', true);
        },
    ]);
}
add_action('rest_api_init', 'add_episode_rest_fields');
