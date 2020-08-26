<div class="modal fade" id="questionAddModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle">Add Question</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSaveQuestion" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Lesson</label>
                        <div class="col-sm-12">
                            <select type="text" class="form-control" id="lessonId" name="lessonId" data-rule-required="true">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Question</label>
                        <div class="col-sm-12">
                            <textarea type="text" class="form-control" id="name" name="question" data-rule-required="true"></textarea>
                            <small class="errors-name sml-er"></small>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Option A
                        </div>
                        <div class="card-body">
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="optionA" data-rule-required="true">
                                <small class="errors-name sml-er"></small>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="isCorrect" value="" id="aIsCorrect" checked>
                                    <label class="custom-control-label" for="aIsCorrect">
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
                                <input type="text" class="form-control" id="optionB" data-rule-required="true">
                                <small class="errors-optionB sml-er"></small>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="isCorrect" value="" id="bIsCorrect">
                                    <label class="custom-control-label" for="bIsCorrect">
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
                                <input type="text" class="form-control" id="optionC" data-rule-required="true">
                                <small class="errors-optionB sml-er"></small>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="isCorrect" value="" id="cIsCorrect">
                                    <label class="custom-control-label" for="cIsCorrect">
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
                                <input type="text" class="form-control" id="optionD" data-rule-required="true">
                                <small class="errors-optionB sml-er"></small>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" name="isCorrect" value="" id="dIsCorrect">
                                    <label class="custom-control-label" for="dIsCorrect">
                                        Is Correct
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.modal.button.close')</button>
                    <a href="javascript:;" onclick="question.addQuestionAndOptions()" type="button" class="btn btn-primary" id="btn_save" value="create">@lang('messages.modal.button.save')</a>
                </div>
            </form>
        </div>
    </div>
</div>
