

function readFile(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        var validImageType = ['image/png', 'image/bmp', 'image/jpeg', 'image/jpg'];
        var htmlPreview;

        // Check if the uploaded file type is a valid image type
        if (validImageType.includes(input.files[0].type)) {
          // Generate HTML for valid image preview
          htmlPreview =
            '<img width="70%" height="300" src="' + e.target.result + '" />' +
            '<p>' + input.files[0].name + '</p>';
        } else {
          // Display message for invalid image type
          htmlPreview =
            '<p>Image preview not available</p>' +
            '<p>' + input.files[0].name + '</p>';
        }




        var wrapperZone = $(input).parent();
        var previewZone = $(input).parent().parent().find('.preview-zone');
        var boxZone = $(input).parent().parent().find('.preview-zone').find('.box').find('.box-body');

        wrapperZone.removeClass('dragover');
        previewZone.removeClass('hidden');
        boxZone.empty();
        boxZone.append(htmlPreview);
      };

      reader.readAsDataURL(input.files[0]);
    }
  }





  function reset(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
  }

  $(".dropzone").change(function() {
    readFile(this);
  });

  $('.dropzone-wrapper').on('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).addClass('dragover');
  });

  $('.dropzone-wrapper').on('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $(this).removeClass('dragover');
  });

  $('.remove-preview').on('click', function() {
    var boxZone = $(this).parents('.preview-zone').find('.box-body');
    var previewZone = $(this).parents('.preview-zone');
    var dropzone = $(this).parents('.form-group').find('.dropzone');
    boxZone.empty();
    previewZone.addClass('hidden');
    reset(dropzone);
  });
