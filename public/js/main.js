function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imageUploadPreview').attr('src', e.target.result).removeClass('hide');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

var $inputFile = $("#inputFile");
if ($inputFile.length) {
    $inputFile.change(function () {
        readURL(this);
    });
}

$('[data-change-target]').change(function() {
    var target = $(this).data('changeTarget');

    if ($(target).length) {
        $(target).text($(this).val());
    }
});
