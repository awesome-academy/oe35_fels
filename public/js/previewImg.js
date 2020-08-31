function loadPreview(input, id) {
    // default value if argument id is not set
    id = id || '#preview_img';
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(id).attr('src', e.target.result);
            $(id).css({
                display: "block"
            });

        };
        reader.readAsDataURL(input.files[0]);
    }
};
