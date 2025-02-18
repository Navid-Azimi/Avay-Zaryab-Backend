<?php
add_action('rest_api_init', function () {
    register_rest_route('zariab/v1', '/episodes/(?P<story_id>\d+)', array(
        'methods'  => 'GET',
        'callback' => 'get_story_episodes',
    ));
});

function get_story_episodes($data) {
    $episodes = get_posts(array(
        'post_type'  => 'episode',
        'meta_key'   => 'parent_story',
        'meta_value' => $data['story_id'],
        'orderby'    => 'meta_value_num',
        'meta_key'   => 'episode_number',
        'order'      => 'ASC'
    ));

    if (empty($episodes)) {
        return new WP_Error('no_episodes', 'No episodes found', array('status' => 404));
    }

    return rest_ensure_response($episodes);
}
