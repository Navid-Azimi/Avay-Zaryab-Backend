<?php
function enqueue_podcast_meta_scripts($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media(); // Enqueue WordPress media uploader
    }
}
add_action('admin_enqueue_scripts', 'enqueue_podcast_meta_scripts');
