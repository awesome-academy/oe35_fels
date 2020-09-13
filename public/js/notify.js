var SITEURL = window.location.origin;

/* Initial AJAX setup header when document is ready*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

$(function () {
    $.reloadNotify = function () {
        $("#notify-data").load(location.href + " #notify-data");
        $("#notify-count").load(location.href + " #notify-count");
        $("#notify-content").load(location.href + " #notify-content");
        $("#notify-footer").load(location.href + " #notify-footer");

        return true;
    };
});

/* mark all as read notify*/
function markAllReadNotify(id) {
    $.ajax({
        url: SITEURL + '/admin/notify/read-all/' + id,
        type: 'post',
        dataType: 'json',
        contentType: 'application/json',
        success: function (data) {
            $.reloadNotify();
        },
    });
}
