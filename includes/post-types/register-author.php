<?php
add_action('init', function () {
    register_post_type('author', [
        'label' => 'Authors',
        'public' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'authors'],
        'menu_icon' => 'dashicons-admin-users',
    ]);
});
add_action('rest_api_init', function () {
    register_meta('post', 'location', [
        'type' => 'string',
        'description' => 'Author Location',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'job', [
        'type' => 'string',
        'description' => 'Author Job',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'age', [
        'type' => 'integer',
        'description' => 'Author Age',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'facebook_link', [
        'type' => 'string',
        'description' => 'Facebook Profile Link',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'instagram_link', [
        'type' => 'string',
        'description' => 'Instagram Profile Link',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'telegram_link', [
        'type' => 'string',
        'description' => 'Telegram Profile Link',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'youtube_link', [
        'type' => 'string',
        'description' => 'YouTube Channel Link',
        'single' => true,
        'show_in_rest' => true,
    ]);
    register_meta('post', 'sum_topics', [
        'type' => 'integer',
        'description' => 'Sum of Topics',
        'single' => true,
        'show_in_rest' => true,
    ]);
});


add_action('add_meta_boxes', function () {
    add_meta_box(
        'author_details',
        'Author Details',
        'render_author_meta_box',
        'author', // Post type
        'normal',
        'high'
    );
});

function render_author_meta_box($post)
{
    // Use nonce for verification
    wp_nonce_field('save_author_details', 'author_meta_nonce');

    // Retrieve current values
    $location = get_post_meta($post->ID, 'location', true);
    $job = get_post_meta($post->ID, 'job', true);
    $sum_topics = get_post_meta($post->ID, 'sum_topics', true);
    $age = get_post_meta($post->ID, 'age', true);
    $facebook_link = get_post_meta($post->ID, 'facebook_link', true);
    $instagram_link = get_post_meta($post->ID, 'instagram_link', true);
    $telegram_link = get_post_meta($post->ID, 'telegram_link', true);
    $youtube_link = get_post_meta($post->ID, 'youtube_link', true);

    // Display fields
    ?>
    <p>
        <label for="author_location">Location:</label><br>
        <input type="text" name="author_location" id="author_location" value="<?php echo esc_attr($location); ?>"
               class="widefat">
    </p>
    <p>
        <label for="author_job">Job:</label><br>
        <input type="text" name="author_job" id="author_job" value="<?php echo esc_attr($job); ?>" class="widefat">
    </p>
    <p>
        <label for="author_sum_topics">Sum of Topics:</label><br>
        <input type="number" name="author_sum_topics" id="author_sum_topics"
               value="<?php echo esc_attr($sum_topics); ?>" class="widefat">
    </p>
    <p>
        <label for="author_age">Age:</label><br>
        <input type="number" name="author_age" id="author_age" value="<?php echo esc_attr($age); ?>" class="widefat">
    </p>
    <p>
        <label for="author_facebook_link">Facebook Link:</label><br>
        <input type="url" name="author_facebook_link" id="author_facebook_link"
               value="<?php echo esc_attr($facebook_link); ?>" class="widefat">
    </p>
    <p>
        <label for="author_instagram_link">Instagram Link:</label><br>
        <input type="url" name="author_instagram_link" id="author_instagram_link"
               value="<?php echo esc_attr($instagram_link); ?>" class="widefat">
    </p>
    <p>
        <label for="author_telegram_link">Telegram Link:</label><br>
        <input type="url" name="author_telegram_link" id="author_telegram_link"
               value="<?php echo esc_attr($telegram_link); ?>" class="widefat">
    </p>
    <p>
        <label for="author_youtube_link">YouTube Link:</label><br>
        <input type="url" name="author_youtube_link" id="author_youtube_link"
               value="<?php echo esc_attr($youtube_link); ?>" class="widefat">
    </p>
    <?php
}

// Save custom fields
add_action('save_post', function ($post_id) {
    // Verify nonce
    if (!isset($_POST['author_meta_nonce']) || !wp_verify_nonce($_POST['author_meta_nonce'], 'save_author_details')) {
        return $post_id;
    }

    // Prevent autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // Prevent save if user lacks permission
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Save fields
    update_post_meta($post_id, 'location', sanitize_text_field($_POST['author_location']));
    update_post_meta($post_id, 'job', sanitize_text_field($_POST['author_job']));
    update_post_meta($post_id, 'sum_topics', intval($_POST['author_sum_topics']));
    update_post_meta($post_id, 'age', intval($_POST['author_age']));
    update_post_meta($post_id, 'facebook_link', esc_url_raw($_POST['author_facebook_link']));
    update_post_meta($post_id, 'instagram_link', esc_url_raw($_POST['author_instagram_link']));
    update_post_meta($post_id, 'telegram_link', esc_url_raw($_POST['author_telegram_link']));
    update_post_meta($post_id, 'youtube_link', esc_url_raw($_POST['author_youtube_link']));
});
