<!-- Create/Update Modal -->
<div class="modal fade" id="bootstrapModalWord" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitleWord"></h4>
            </div>
            <form id="formModalWord" name="formModal" class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show">
                        <div id="alert_msgWord" role="alert"></div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">@lang('messages.modal.form.name')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nameWord" name="name" data-rule-required="true" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mean" class="col-sm-2 control-label">@lang('messages.modal.form.mean')</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="meanWord" name="mean" />
                        </div>
                    </div>
                    <input type="hidden" name="course_id" id="course_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="btn_finishWord">@lang('messages.modal.button.finish')</button>
                    <button type="submit" type="button" class="btn btn-primary" id="btn_saveWord" value="create">@lang('messages.modal.button.save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
