<?php
function add_episode_meta_box() {
    add_meta_box(
        'episode_details',  // Meta Box ID
        'Episode Details',  // Title in Admin
        'episode_meta_box_callback',  // Callback to Render Fields
        'episode',  // Applies to Episode Post Type
        'normal',  // Position on Page
        'high'  // Priority
    );
}

add_action('add_meta_boxes', 'add_episode_meta_box');

function episode_meta_box_callback($post) {
    $episode_number = get_post_meta($post->ID, 'episode_number', true);
    $parent_story = get_post_meta($post->ID, 'parent_story', true);

    // Use WP_Query to fetch stories explicitly
    $stories_query = new WP_Query(array(
        'post_type' => 'story',
        'posts_per_page' => -1,
        // 'post_status' => array('publish', 'draft')
    ));

    ?>
    <label for="episode_number">Episode Number:</label>
    <input type="number" id="episode_number" name="episode_number" value="<?php echo esc_attr($episode_number); ?>" />

    <label for="parent_story">Parent Story Collection:</label>
    <select id="parent_story" name="parent_story">
        <option value="">Select a Story</option>
        <?php 
        if ($stories_query->have_posts()) {
            while ($stories_query->have_posts()) {
                $stories_query->the_post();
                ?>
                <option value="<?php echo get_the_ID(); ?>" <?php selected($parent_story, get_the_ID()); ?>>
                    <?php echo esc_html(get_the_title()); ?>
                </option>
                <?php
            }
        } else { ?>
            <option value="">No stories found</option>
        <?php } ?>
    </select>
    <?php
    // Reset post data to avoid conflicts
    wp_reset_postdata();
}

function save_episode_meta($post_id) {
    if (isset($_POST['episode_number'])) {
        update_post_meta($post_id, 'episode_number', sanitize_text_field($_POST['episode_number']));
    }
    if (isset($_POST['parent_story'])) {
        update_post_meta($post_id, 'parent_story', sanitize_text_field($_POST['parent_story']));
    }
}
add_action('save_post', 'save_episode_meta');

