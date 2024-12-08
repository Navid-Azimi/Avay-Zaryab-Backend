<?php
// Add Meta Boxes
function add_letter_meta_boxes() {
    add_meta_box(
        'letter_meta_box',
        'Letter Details',
        'render_letter_meta_box',
        'letter',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_letter_meta_boxes');

// Render Meta Box
function render_letter_meta_box($post) {
    wp_nonce_field('save_letter_meta', 'letter_meta_nonce');

    // Get existing meta values
    $letter_number = get_post_meta($post->ID, '_letter_number', true);
    $pages = get_post_meta($post->ID, '_pages', true);
    $download_link = get_post_meta($post->ID, '_download_link', true);
    ?>
    <style>
        .repeater-item {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .repeater-item input {
            margin-bottom: 5px;
        }
        .remove-repeater-item {
            color: #ff4d4f;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>

    <p>
        <label for="letter_number">Letter Number:</label>
        <input type="text" id="letter_number" name="letter_number" value="<?php echo esc_attr($letter_number); ?>" class="widefat">
    </p>
    <hr>
    <h4>Pages</h4>
    <div id="pages-repeater">
        <?php
        if (!empty($pages) && is_array($pages)) {
            foreach ($pages as $index => $page) {
                ?>
                <div class="repeater-item">
                    <label>Page Number:</label>
                    <input type="number" name="pages[<?php echo $index; ?>][page_number]" value="<?php echo esc_attr($page['page_number']); ?>" placeholder="Page Number">

                    <label>Image:</label>
                    <input type="hidden" name="pages[<?php echo $index; ?>][image]" value="<?php echo esc_url($page['image']); ?>" class="repeater-image-url">
                    <img src="<?php echo esc_url($page['image']); ?>" class="repeater-image-preview" style="max-width: 100%; height: auto; display: <?php echo $page['image'] ? 'block' : 'none'; ?>;">
                    <button type="button" class="select-image-button button">Select Image</button>
                    <button type="button" class="remove-repeater-item">Remove</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <button type="button" id="add-repeater-item" class="button">Add Page</button>
    <hr>
    <p>
        <label for="download_link">Download Link (PDF):</label>
        <input type="url" id="download_link" name="download_link" value="<?php echo esc_url($download_link); ?>" class="widefat" placeholder="Enter the PDF URL">
    </p>
    <?php
}

// Save Meta Box Data
function save_letter_meta($post_id) {
    if (!isset($_POST['letter_meta_nonce']) || !wp_verify_nonce($_POST['letter_meta_nonce'], 'save_letter_meta')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save letter number
    if (isset($_POST['letter_number'])) {
        update_post_meta($post_id, '_letter_number', sanitize_text_field($_POST['letter_number']));
    }

    // Save pages (repeater)
    if (isset($_POST['pages']) && is_array($_POST['pages'])) {
        $pages = array_map(function ($page) {
            return [
                'page_number' => intval($page['page_number']),
                'image'       => esc_url_raw($page['image']),
            ];
        }, $_POST['pages']);
        update_post_meta($post_id, '_pages', $pages);
    } else {
        delete_post_meta($post_id, '_pages');
    }

    // Save download link
    if (isset($_POST['download_link'])) {
        update_post_meta($post_id, '_download_link', esc_url_raw($_POST['download_link']));
    }
}
add_action('save_post', 'save_letter_meta');


function add_shamsi_publish_date_meta_box($post) {
    add_meta_box(
        'shamsi_publish_date',
        'Publish Date (Shamsi)',
        'render_shamsi_publish_date_meta_box',
        ['letter'], // Add your post types here
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'add_shamsi_publish_date_meta_box');

function render_shamsi_publish_date_meta_box($post) {
    $shamsi_date = get_post_meta($post->ID, '_shamsi_publish_date', true);
    ?>
    <label for="shamsi_publish_date">Shamsi Publish Date:</label>
    <input type="text" id="shamsi_publish_date" name="shamsi_publish_date"
           value="<?php echo esc_attr($shamsi_date); ?>" placeholder="1402-08-24">
    <p class="description">Enter the publish date in the Shamsi calendar (YYYY-MM-DD).</p>
    <?php
}

function save_shamsi_publish_date_meta($post_id) {
    if (isset($_POST['shamsi_publish_date'])) {
        update_post_meta($post_id, '_shamsi_publish_date', sanitize_text_field($_POST['shamsi_publish_date']));
    }
}
add_action('save_post', 'save_shamsi_publish_date_meta');
