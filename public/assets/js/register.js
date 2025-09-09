$(document).ready(function(){


    $('#profile_picture_input').on('change', function(e) {
        var fileNameContainer = $(this).closest('.custom-file-container').find('.file-name');
        var avatarPreview = $('#avatar-preview');

        var files = e.target.files;
        if (files && files.length > 0) {
            var file = files[0];
            var reader = new FileReader();
            
            reader.onload = function(event) {
                image.src = event.target.result; 
                modal.modal('show');
                
                fileNameContainer.text(file.name).css('color', '#495057').show();
                avatarPreview.hide(); 
            };
            
            reader.readAsDataURL(file);
        } else {
            fileNameContainer.text('No file chosen').css('color', '#6c757d').show();
            avatarPreview.hide();
            croppedImageBlob = null; 
        }
    });

    $('#crop-button').on('click', function(){
        var canvas = cropper.getCroppedCanvas({
            width: 300,  
            height: 300,
        });

        canvas.toBlob(function(blob) {
            croppedImageBlob = blob;
            var previewUrl = URL.createObjectURL(croppedImageBlob);
            
            $('#avatar-preview').attr('src', previewUrl).show();
            
            modal.modal('hide');
        }, 'image/png');
    });

    $.ajaxSetup({
        data: {
            [csrfName]: csrfHash
        }
    });

    var modal = $('#crop-modal');
    var image = document.getElementById('image-to-crop');
    var cropper;
    var croppedImageBlob = null; 

    $('#profile_picture_input').on('change', function(e){
        var files = e.target.files;
        if (files && files.length > 0) {
            var file = files[0];
            var reader = new FileReader();
            
            reader.onload = function(event) {
                image.src = event.target.result;
                modal.modal('show');
            };
            
            reader.readAsDataURL(file);
        }
    });

    modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            preview: '.preview',
        });
    }).on('hidden.bs.modal', function () {
        cropper.destroy();
        cropper = null;
    });

    $('#crop-button').on('click', function(){
        var canvas = cropper.getCroppedCanvas({
            width: 400,
            height: 400,
        });

        canvas.toBlob(function(blob) {
            croppedImageBlob = blob;
            var previewUrl = URL.createObjectURL(croppedImageBlob);
            $('#avatar-preview').attr('src', previewUrl).show();
            modal.modal('hide');
        }, 'image/png');
    });

    $('form').on('submit', function(e){
        e.preventDefault();

        var formData = new FormData(this);
        if (croppedImageBlob) {
            formData.delete('profile_picture');
            formData.append('profile_picture', croppedImageBlob, 'cropped_avatar.png');
        }

        var errorBox = $('.alert-danger.errors');
        errorBox.hide().html('');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            
            success: function(response) {
                window.location.href = baseUrl + 'login'; 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 400) {
                    var errors = jqXHR.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';
                    errorBox.html(errorHtml).show();

                    if (jqXHR.responseJSON.csrf) {
                        csrfHash = jqXHR.responseJSON.csrf;
                        $.ajaxSetup({ data: { [csrfName]: csrfHash } });
                    }

                } else {
                    alert('An unexpected error occurred. Please try again.');
                    console.error('Submission failed:', textStatus, errorThrown);
                }
            }
        });
    });
});