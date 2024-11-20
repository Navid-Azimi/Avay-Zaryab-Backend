<?php

function render_podcast_meta_box($post)
{
    $host_name = get_post_meta($post->ID, 'host_name', true);
    $guest_name = get_post_meta($post->ID, 'guest_name', true);
    $audio_file = get_post_meta($post->ID, 'audio_file', true);
    $podcast_date_shamsi = get_post_meta($post->ID, 'podcast_date_shamsi', true);
    $podcast_duration = get_post_meta($post->ID, 'podcast_duration', true);

    wp_nonce_field('save_podcast_meta', 'podcast_meta_nonce');
    ?>
    <p>
        <label for="host_name">Host Name:</label>
        <input type="text" name="host_name" id="host_name" value="<?php echo esc_attr($host_name); ?>" class="widefat">
    </p>
    <p>
        <label for="guest_name">Guest Name:</label>
        <input type="text" name="guest_name" id="guest_name" value="<?php echo esc_attr($guest_name); ?>"
               class="widefat">
    </p>
    <p>
        <label for="audio_file">Podcast Audio (.mp3):</label>
        <input type="text" name="audio_file" id="audio_file" value="<?php echo esc_attr($audio_file); ?>"
               class="widefat">
        <button type="button" class="button podcast-audio-upload-button">Select .mp3</button>
    </p>
    <p>
        <label for="podcast_date_shamsi">Date (Shamsi):</label>
        <input type="text" name="podcast_date_shamsi" id="podcast_date_shamsi"
               value="<?php echo esc_attr($podcast_date_shamsi); ?>" class="widefat">
    </p>
    <p>
        <label for="podcast_duration">Duration (HH:MM:SS):</label>
        <input type="text" name="podcast_duration" id="podcast_duration"
               value="<?php echo esc_attr($podcast_duration); ?>" class="widefat">
    </p>
    <script>
        jQuery(document).ready(function ($) {
            // Handle media uploader for audio file
            $('.podcast-audio-upload-button').on('click', function (e) {
                e.preventDefault();
                var button = $(this);
                var file_frame = wp.media({
                    title: 'Select Podcast Audio',
                    library: {
                        type: 'audio'
                    },
                    button: {
                        text: 'Use this audio'
                    },
                    multiple: false
                });
                file_frame.on('select', function () {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    if (attachment.url.endsWith('.mp3')) {
                        button.prev('input').val(attachment.url);
                    } else {
                        alert('Please select a .mp3 file.');
                    }
                });
                file_frame.open();
            });
        });
    </script>
    <?php
}

