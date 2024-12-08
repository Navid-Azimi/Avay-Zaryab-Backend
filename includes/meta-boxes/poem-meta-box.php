<?php

$authors = zariab_get_authors();
// Add Poem Meta Boxes
function add_poem_meta_boxes()
{
    add_meta_box(
        'poem_details',
        'Poem Details',
        'render_poem_meta_box',
        'poem',
        'normal',
        'high'
    );
}

add_action('add_meta_boxes', 'add_poem_meta_boxes');

function render_poem_meta_box($post)
{
    // Retrieve saved meta values
    $publish_date = get_post_meta($post->ID, '_publish_date', true);
    $read_time = get_post_meta($post->ID, '_read_time', true);
    $author = get_post_meta($post->ID, '_poem_author', true);

    // Call the global variable to get authors which is in line 3
    global $authors;

    ?>
    <p>
        <label for="publish_date">Publish Date (Hijri Shamsi):</label>
        <input type="text" id="publish_date" name="publish_date" value="<?php echo esc_attr($publish_date); ?>" />
    </p>
    <p>
        <label for="read_time">Time to Read (Minutes):</label>
        <input type="number" id="read_time" name="read_time" value="<?php echo esc_attr($read_time); ?>" />
    </p>
    <p>
        <label for="poem_author">Author:</label>
        <select id="poem_author" name="poem_author">
            <option value="">Select an Author</option>
            <?php if (!empty($authors)): ?>
                <?php foreach ($authors as $author_post): ?>
                    <option value="<?php echo esc_attr($author_post->ID); ?>" <?php selected($author, $author_post->ID); ?>>
                        <?php echo esc_html($author_post->post_title); ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="" disabled>No authors available</option>
            <?php endif; ?>
        </select>
    </p>
    <?php
}




// Save Poem Meta Box Data
function save_poem_meta_box_data($post_id)
{
    if (array_key_exists('publish_date', $_POST)) {
        update_post_meta($post_id, '_publish_date', sanitize_text_field($_POST['publish_date']));
    }

    if (array_key_exists('read_time', $_POST)) {
        update_post_meta($post_id, '_read_time', intval($_POST['read_time']));
    }

    if (array_key_exists('poem_author', $_POST)) {
        update_post_meta($post_id, '_poem_author', intval($_POST['poem_author']));
    }
}

add_action('save_post', 'save_poem_meta_box_data');
