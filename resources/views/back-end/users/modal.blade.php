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
