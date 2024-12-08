<?php
function enqueue_podcast_meta_scripts($hook) {
    if ($hook === 'post.php' || $hook === 'post-new.php') {
        wp_enqueue_media(); // Enqueue WordPress media uploader
    }
}
add_action('admin_enqueue_scripts', 'enqueue_podcast_meta_scripts');

function enqueue_admin_scripts() {
    wp_enqueue_media(); // Enqueue Media Library scripts
    wp_enqueue_script('letter-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');
