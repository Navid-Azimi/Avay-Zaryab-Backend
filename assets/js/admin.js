jQuery(document).ready(function ($) {
    // Function to initialize "Select Image" functionality
    function initializeSelectImage(button) {
        const input = button.siblings('.repeater-image-url'); // Target hidden input
        const preview = button.siblings('.repeater-image-preview'); // Target image preview

        // Open Media Library for this specific button
        const mediaUploader = wp.media({
            title: 'Select Image',
            button: {text: 'Use This Image'},
            multiple: false,
        });

        mediaUploader.on('select', function () {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            input.val(attachment.url); // Set the hidden input value
            preview.attr('src', attachment.url).show(); // Set the preview image
        });

        mediaUploader.open();
    }

    // Add Repeater Item
    $('#add-repeater-item').on('click', function () {
        const index = $('#pages-repeater .repeater-item').length;
        const newItem = `
            <div class="repeater-item">
                <label>Page Number:</label>
                <input type="number" name="pages[${index}][page_number]" placeholder="Page Number">
                
                <label>Image:</label>
                <input type="hidden" name="pages[${index}][image]" class="repeater-image-url">
                <img src="" class="repeater-image-preview" style="max-width: 100%; height: auto; display: none;">
                <button type="button" class="select-image-button button">Select Image</button>
                <button type="button" class="remove-repeater-item">Remove</button>
            </div>`;
        $('#pages-repeater').append(newItem);
    });

    // Delegate event for "Select Image" button
    $('#pages-repeater').on('click', '.select-image-button', function (e) {
        e.preventDefault();
        initializeSelectImage($(this)); // Initialize for the clicked button
    });

    // Remove Repeater Item
    $('#pages-repeater').on('click', '.remove-repeater-item', function () {
        $(this).closest('.repeater-item').remove();
    });
});
