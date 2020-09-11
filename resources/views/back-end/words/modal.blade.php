<!-- Create/Update Modal -->
<div class="modal fade" id="bootstrapModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formModal" name="formModal" class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show">
                        <button type="button" class="close" data-hide="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div id="alert_msg" role="alert"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">@lang('messages.modal.form.name')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" data-rule-required="true" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mean" class="col-sm-2 control-label">@lang('messages.modal.form.mean')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="mean" name="mean" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">@lang('messages.modal.form.course')</label>
                        <div class="col-sm-12">
                            <select name="course_id" id="course_id" class="form-control">
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="record_id" id="record_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.modal.button.close')</button>
                    <button type="submit" type="button" class="btn btn-primary" id="btn_save" value="create">@lang('messages.modal.button.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('messages.modal.msg.label')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h4 style="margin: 0;" id="confirmModalTitle">@lang('messages.modal.msg.title')</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('messages.modal.button.cancel')</button>
                <button type="button" name="btn_ok" id="btn_ok" class="btn btn-danger">@lang('messages.modal.button.ok')</button>
            </div>
        </div>
    </div>
</div>
