require('./bootstrap');

try {
    // toastr notifications
    window.toastr = require('admin-lte/plugins/toastr/toastr.min.js');

    // jquery-validation
    require('admin-lte/plugins/jquery-validation/jquery.validate.min.js');

    // dataTables
    require('admin-lte/plugins/datatables/jquery.dataTables.min.js');
    require('admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');
    require('admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js');
    require('admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js');

    // adminLTE
    require('admin-lte/dist/js/adminlte.js');
} catch (e) {}
