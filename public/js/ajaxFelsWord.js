var SITEURL = window.location.origin;

/* Initial AJAX setup header when document is ready*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});
/* submit word which user has remembered*/
function submitWordLearn(id) {
    $.ajax({
        url: SITEURL + '/remember-word/' + id,
        type: 'post',
        dataType: 'json',
        contentType: 'application/json',
        success: function (data) {
            $('#wordNotLearnText-' + id).prop("hidden", true);
            $('#wordNotLearnBtn-' + id).prop("hidden", true);
            $('#wordLearned-' + id).prop("hidden", false);
            $('#wordLearnedIcon-' + id).prop("hidden", false);
        },
        error: function (data) {
            alert('Error! Not remember yet.');
        },
    });
}
