<div class="modal fade" id="questionEditModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Edit Question</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formEditQuestion" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Lesson</label>
                        <div class="col-sm-12">
                            <select type="text" class="form-control" id="e_lessonId" name="e_lessonId" data-rule-required="true">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Question</label>
                        <div class="col-sm-12">
                            <textarea type="text" class="form-control" data-questionId="" id="e_name" data-rule-required="true"></textarea>
                            <small class="errors-name sml-er"></small>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Option A
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" data-aIsOptionCorrect="" id="e_optionA" data-rule-required="true">
                                <small class="errors-e_optionA sml-er"></small>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="e_isCorrect" value="" id="e_aIsCorrect" checked>
                                    <label class="custom-control-label" for="e_aIsCorrect">
                                        Is Correct
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Option B
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" data-bIsOptionCorrect="" id="e_optionB" data-rule-required="true">
                                <small class="errors-e_optionB sml-er"></small>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="e_isCorrect" value="" id="e_bIsCorrect">
                                    <label class="custom-control-label" for="e_bIsCorrect">
                                        Is Correct
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Option C
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" data-cIsOptionCorrect="" id="e_optionC" data-rule-required="true">
                                <small class="errors-e_optionC sml-er"></small>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="e_isCorrect" value="" id="e_cIsCorrect">
                                    <label class="custom-control-label" for="e_cIsCorrect">
                                        Is Correct
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Option D
                        </div>  
                        <div class="card-body">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" data-dIsOptionCorrect="" id="e_optionD" data-rule-required="true">
                                <small class="errors-e_optionD sml-er"></small>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="e_isCorrect" value="" id="e_dIsCorrect">
                                    <label class="custom-control-label" for="e_dIsCorrect">
                                        Is Correct
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.modal.button.close')</button>
                    <a href="javascript:;" onclick="question.updateQuestionAndOptions()" type="button" class="btn btn-primary" id="btn_save" value="create">@lang('messages.modal.button.save')</a>
                </div>
            </form>
        </div>
    </div>
</div>