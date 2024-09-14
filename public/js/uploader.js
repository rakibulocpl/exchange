// uploader.js

function ImageUploader(inputSelector, messageSelector, loaderSelector, imagePathSelector, previewSelector, maxSizeMB, allowedTypes) {
    this.input = $(inputSelector);
    this.message = $(messageSelector);
    this.loader = $(loaderSelector);
    this.imagePathInput = $(imagePathSelector);
    this.preview = $(previewSelector);
    this.maxSizeMB = maxSizeMB; // Maximum size in MB
    this.allowedTypes = allowedTypes; // Array of allowed MIME types

    // Bind the event listener
    this.input.on('change', () => {
        this.validateAndUploadImage();
    });
}

ImageUploader.prototype.validateAndUploadImage = function() {
    const file = this.input[0].files[0];

    // Check if a file is selected
    if (!file) {
        this.message.text('Please select an image.');
        return;
    }

    // Check file type
    if (!this.allowedTypes.includes(file.type)) {
        this.message.text('Only ' + this.allowedTypes.join(', ') + ' image types are allowed.');
        return;
    }

    // Check file size
    if (file.size > this.maxSizeMB * 1024 * 1024) {
        this.message.text('Maximum file size exceeded (' + this.maxSizeMB + ' MB).');
        return;
    }

    // If all checks pass, proceed with upload
    this.uploadImage();
};

ImageUploader.prototype.uploadImage = function() {
    this.loader.show();

    var formData = new FormData();
    formData.append('image', this.input[0].files[0]);

    $.ajax({
        type: 'POST',
        url: "/upload-image", // Update the route as needed
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        cache: false,
        contentType: false,
        processData: false,
        success: (data) => {
            toastr.success(data.success, 'Success');
            this.loader.hide();

            // Store the image path in the input field
            this.imagePathInput.val(data.image_path);

            // Preview the image
            this.preview.attr('src', data.image_path);
            this.preview.show();

            // Clear the file input
            this.input.val('');
            this.input.removeAttr('required');
            this.input.next("label").removeClass("error");
        },
        error: (data) => {
            this.message.text(data.responseJSON.error);
            this.loader.hide();
        }
    });
};
