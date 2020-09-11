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
                url: SITEURL + '/admin/' + string,
                type: "GET",
            },
            columns: [{
                    data: "DT_RowIndex",
                    name: "DT_RowIndex"
                }, // 0
                {
                    data: "name",
                    name: "name"
                },
                {
                    data: "mean",
                    name: "mean"
                },
                {
                    data: "course.name",
                    name: "course_id"
                },
                {
                    data: "created_at",
                    name: "created_at"
                },
                {
                    data: "action",
                    name: "action",
                    render: function (data, type, row, meta) {
                        btn = '<a href="javascript:void(0);" id="edit_record" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Edit" class="btn btn-icon btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                        btn += '&nbsp;<a href="javascript:void(0);" id="delete_record" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Delete" class="btn btn-icon btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                        return btn;
                    }
                }, // 4
            ],
            columnDefs: [{
                    orderable: false,
                    targets: [0, 5]
                },
                {
                    searchable: false,
                    targets: [0, 5]
                }
            ],
            order: [
                [4, "desc"]
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
    jq.data_table('words');
});

/* Show Edit/Create Modal */
$("body").on("click", "#edit_record, #create_new_record", function () {
    $("#alert_msg").empty();
    $(".alert-warning").hide();
    modal_type = $(this).attr("id");
    if (modal_type == "create_new_record") {
        $.get(SITEURL + '/admin/courses-list', function (data) {
            if (data.data.length == 0) {
                $('#bootstrapModal').modal({
                    show: false
                });
                $.msgNotification('error', 'Create a new course first!');
            } else {
                $("#course_id").empty();
                $.each(data.data, function (key, value) {
                    $("#course_id").append(`<option value="${value.id}">${value.name}</option>`);
                });
                $("#record_id").val("");
                $("#formModal").trigger("reset");
                $("#modalTitle").html("Add New Record");
                $("#btn_save").html("Create");
                $("#bootstrapModal").modal({
                    show: true,
                    backdrop: "static",
                    keyboard: false,
                });
            }
        });
    } else {
        // Get detail record form server
        var record_id = $(this).data("id");
        $.get(SITEURL + '/admin/words/' + record_id + '/edit', function (value) {
            $("#course_id").empty();
            $("#modalTitle").html("Edit Record");
            $("#btn_save").html("Update");
            $("#record_id").val(value.data.id);
            $("#name").val(value.data.name);
            $("#mean").val(value.data.mean);
            $("#course_id").append(`<option value="${value.data.course_id}" checked>${value.data.course_name}</option>`);
        });
        $.get(SITEURL + '/admin/courses-list', function (data) {
            $.each(data.data, function (key, value) {
                $("#course_id").append(`<option value="${value.id}">${value.name}</option>`);
            });
        });
        $("#bootstrapModal").modal({
            show: true,
            backdrop: "static",
            keyboard: false,
        });
    }
});

/* Show confirm modal */
$("body").on("click", "#delete_record", function () {
    record_id = $(this).data("id");
    $("#confirmModal").modal("show");
});

/* Confirmation related to delete or restore record */
$("#btn_ok").click(function () {
    var url_action = '/admin/words/';
    var url_type = "DELETE";
    var msg = "Deleting...";
    $.ajax({
        type: url_type,
        url: SITEURL + url_action + record_id,
        contentType: 'application/json',
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

/* Validate input data + send form to updateOrCreate */
$("#btn_save").click(function () {
    $("#formModal").validate({
        rules: {
            name: {
                required: true,
                minlength: 1,
                maxlength: 255,
            },
            mean: {
                maxlength: 255,
            },
        },
        messages: {
            name: {
                required: "Name is required!",
                minlength: "Minimum length is 1!",
                maxlength: "Maximum length is 255!",
            },
            mean: {
                maxlength: "Maximum length is 255!",
            },
        },
        submitHandler: function () {
            $("#btn_save").html("Saving..");
            $.ajax({
                data: $("#formModal").serialize(),
                url: SITEURL + '/admin/words',
                type: "POST",
                dataType: "json",
                success: function (data) {
                    $(".alert-warning").hide();
                    if (data.errors) {
                        $("#alert_msg").empty();
                        $.each(data.errors, function (key, value) {
                            $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                            $(".alert-warning").show();
                        });
                        $("#btn_save").html("Save Changes");
                    } else {
                        $("#datatable_record").DataTable().ajax.reload();
                        setTimeout(function () {
                            $("#formModal").trigger("reset");
                            $("#bootstrapModal").modal("hide");
                            $("#btn_save").html("Save Changes");
                            $.msgNotification("success", data.success);
                        }, 1000);
                    }
                },
                error: function (data) {
                    var validateErrors = data.responseJSON.errors;
                    $("#alert_msg").empty();
                    $.each(validateErrors, function (key, value) {
                        $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                        $(".alert-warning").show();
                    });
                    $("#btn_save").html("Save Changes");
                },
            });
        },
    });
});

/* Remove validate error */
(function () {
    $.resetValidate = function () {
        var validator = $("#formModal").validate();
        validator.resetForm();
    };
})(jQuery);

/* Hide errors showed on modal when click close button*/
$(function () {
    $("[data-hide]").on("click", function () {
        $(this).closest("." + $(this).attr("data-hide")).hide();
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

/* abort javascript */
$(function () {
    $.abort = function (msg = null) {
        throw new Error(msg);
    };
});

function abort(msg = null) {
    throw new Error(msg);
}
