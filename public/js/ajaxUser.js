var SITEURL = window.location.origin;
var jq = new jQuery();
/* dataTable AJAX */
(function () {
    $.fn.data_table = function (string = "") {
        $("#datatable_record").DataTable({
            autoWidth: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: SITEURL + "/admin/users/index",
                type: "GET",
            },
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex"
                }, // 0
                {
                    data: "name",
                    name: "name",
                    render: function (data, type, row, meta) {
                        if (row.name == null) {
                            name = '<i class="fas fa-question"></i>';
                        } else {
                            name = row.name;
                        }
                        return name;
                    },
                },
                {
                    data: "email",
                    name: "email",
                },
                {
                    data: "role",
                    name: "role_id",
                    render: function (data, type, row, meta) {
                        if (row.role_id == '1' || row.role_id == '2') {
                            roleName = '<span>Admin</span>';
                        } else {
                            roleName = '<span>User</span>';
                        }
                        return roleName;
                    },
                },
                {
                    data: "status",
                    name: "deleted_at",
                    render: function (data, type, row, meta) {
                        if (row.deleted_at != null) {
                            btn = '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
                        } else {
                            btn = '<span class="badge badge-primary"><i class="fas fa-check-circle"></i> Active</span>';
                        }
                        return btn;
                    },
                },
                {
                    data: "created_at",
                    name: "created_at",
                },
                {
                    data: "updated_at",
                    name: "updated_at",
                },
                {
                    data: "action",
                    name: "action",
                    render: function (data, type, row, meta) {
                        if (row.deleted_at == null) {
                            btn = '&nbsp;<a href="javascript:void(0);" id="delete_record" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Delete" class="btn btn-icon btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        } else {
                            btn = '<a href="javascript:void(0);" id="restore_record" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Restore" class="btn btn-icon btn-warning"><i class="fa fa-undo" aria-hidden="true"></i></a>';
                        }
                        return btn;
                    },
                }, // 7
            ],
            columnDefs: [{
                    orderable: false,
                    targets: [0, 7]
                },
                {
                    searchable: false,
                    targets: [0, 7]
                }
            ],
            order: [
                [0, "desc"]
            ],
        });
    };
})(jQuery);

/* Initial dataTable AJAX when document is ready*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    jq.data_table();
});

/* Show confirm modal */
$("body").on("click", "#delete_record, #restore_record", function () {
    record_id = $(this).data("id");
    url_delete = $(this).attr("id");
    switch (url_delete) {
        case "restore_record":
            $("#confirmModalTitle").html("Are you sure you want to restore this data?");
            break;
        default:
            break;
    }
    $("#confirmModal").modal("show");
});

/* Confirmation related to delete or restore category */
$("#btn_ok").click(function () {
    var url_action = "";
    var url_type = "DELETE";
    var msg = "Deleting...";
    switch (url_delete) {
        case "restore_record":
            url_action = "restore/";
            url_type = "PATCH";
            msg = "Restoring...";
            break;
        default:
            url_action = "delete/";
            break;
    }
    $.ajax({
        type: url_type,
        url: SITEURL + "/admin/users/" + url_action + record_id,
        beforeSend: function () {
            $("#btn_ok").text(msg);
        },
        success: function (data) {
            if (data.errors) {
                $("#alert_msg").empty();
                $.each(data.errors, function (key, value) {
                    $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                    $(".alert-warning").show();
                });
            } else {
                $("#datatable_record").dataTable().fnDraw(false);
                setTimeout(function () {
                    $(".alert-warning").hide();
                    $("#confirmModal").modal("hide");
                    $("#btn_ok").html("OK");
                    $.msgNotification("success", data.success);
                }, 1000);
            }
        },
    });
});

/* Capitalize first letter for Toast Nofitication*/
$(function () {
    $.jsUcFirst = function (string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    };
});

// toastr settings
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

/* Toast Nofitication*/
$(function () {
    $.msgNotification = function (msgType, msgText) {
        toastr[msgType]($.jsUcFirst(msgText));
    };
});
