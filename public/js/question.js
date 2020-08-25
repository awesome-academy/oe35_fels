var question = {} || question;

question.table;

function messenger(_text){
    $.toast({
        heading: 'Message',
        text: _text,
        hideAfter: 2000,
        position: 'top-center',
        showHideTransition: 'slide',
        icon: 'success'
    })
}

//get option correct for each question
function optionCorrect(options){
    for(let i =0; i<= 3; i++){
        if(options[i].is_correct==1){
            return options[i].name;
        }
    }
}
question.showData = () =>
{
    question.table = $('#tbQuestion').DataTable({
        ajax: {
            url : "/admin/questions/list",
            dataSrc: function(jsons){
                console.log(jsons);
                return jsons.map(obj=>{
                    return {
                        id: obj.id,
                        name: obj.name,
                        created_at: obj.created_at,
                        optionCorrect: optionCorrect(obj.options),
                        action: 
                            `
                                <a href="javascript:;" onclick="question.showEditQuestionModal(${obj.id})" class="text-warning mx-auto btn"><i class="fa fa-edit"></i>edit</a>
                                <a href="javascript:;" onclick="question.deleteQuestion(${obj.id})" class="text-danger mx-auto btn"><i class="fa fa-trash"></i>delete</a>
                            `
                    }
                })
            }
        },
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'optionCorrect'},
            {data: 'created_at'},
            {data: 'action'}
        ]
    });
}

question.getAllLesson = () => 
{   
    $.ajax({
        type: "GET",
        url: "/admin/questions/all-lesson",
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            if(!data){
                $("#lessonId").append(
                    `<option value="">No item</option>`
                );
            }else{
                $("#lessonId").empty();
                $.each(data, function(i,v){
                    // console.log(`id: ${v.id}, val: ${v.name}`);
                    $("#lessonId").append(
                        `
                            <option value="${v.id}">${v.name}</option>
                        `
                    );
                });  
            }    
        }
    });
}

question.showAddQuestionModal = () =>
{   
    $('.sml-er').empty();
    question.resetForm();
    $('#questionAddModal').modal({
        show: true,
        backdrop: "static",
        keyboard: false,
    });
}

question.showEditQuestionModal = (id) =>
{   
    question.getDetailQuestion(id); 
    $('.sml-er').empty();
    $('#questionEditModal').modal({
        show: true,
        backdrop: "static",
        keyboard: false,
    });
}

question.getDetailQuestion = (id) =>
{
    $.ajax({
        type: "GET",
        url: "/admin/question/"+ id +"/edit",
        dataType: "json",
        success: function (data) {
            console.log(data);
            $('#e_name').data('questionId', data.question.id);
            $('#e_optionA').data('optionIdA', data.options[0].id);
            $('#e_optionB').data('optionIdB', data.options[1].id);
            $('#e_optionC').data('optionIdC', data.options[2].id);
            $('#e_optionD').data('optionIdD', data.options[3].id);
            $('#e_name').val(data.question.name);
            $('#e_optionA').val(data.options[0].name);
            $('#e_optionB').val(data.options[1].name);
            $('#e_optionC').val(data.options[2].name);
            $('#e_optionD').val(data.options[3].name);
            $('#e_aIsCorrect').prop('checked', data.options[0].is_correct);
            $('#e_bIsCorrect').prop('checked', data.options[1].is_correct);
            $('#e_cIsCorrect').prop('checked', data.options[2].is_correct);
            $('#e_dIsCorrect').prop('checked', data.options[3].is_correct);

            $.each(data.lessonList, function(i,v){
                // console.log(`id: ${v.id}, val: ${v.name}`);
                $("#e_lessonId").append(
                    `
                        <option value="${v.id}">${v.name}</option>
                    `
                );
            }); 
            //select lesson selected for question 
            $(`#e_lessonId option[value='${data.question.lesson_id}']`).prop('selected', true);
        }
    });
}

question.addQuestionAndOptions = () => 
{
    if($('#formSaveQuestion').valid())
    {
        var objAdd = {};
            
        objAdd.lessonId         = $('#lessonId').val();
        objAdd.name             = $('#name').val();
        objAdd.optionA          = $('#optionA').val();
        objAdd.optionB          = $('#optionB').val();
        objAdd.optionC          = $('#optionC').val();
        objAdd.optionD          = $('#optionD').val();

        objAdd.aIsCorrect       = $('#aIsCorrect').prop('checked');
        objAdd.bIsCorrect       = $('#bIsCorrect').prop('checked');
        objAdd.cIsCorrect       = $('#cIsCorrect').prop('checked');
        objAdd.dIsCorrect       = $('#dIsCorrect').prop('checked');
        console.log(objAdd);
        $.ajax({
            url: "/admin/question",
            type: "POST",
            dataType: "JSON",
            data: JSON.stringify(objAdd),
            contentType: 'application/json',
            success: function (data) {
                console.log(data);
                $('#questionAddModal').modal('hide');
                question.table.ajax.reload(null,false);
                messenger(data.success);
            },
            error: function(data){
                console.log(data);
                $('.sml-er').empty();
                $.each(data.responseJSON.errors, function(key, val) {
                    $(`.errors-${key}`).text(val);
                });
            }
        });
    }
}

question.updateQuestionAndOptions = () =>
{
    bootbox.confirm({
        message: "Update now?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if(result)
            {
                var objEdit = {};

                objEdit.questionId       = $('#e_name').data('questionId');
                //get id options
                objEdit.optionIdA        = $('#e_optionA').data('optionIdA');
                objEdit.optionIdB        = $('#e_optionB').data('optionIdB');
                objEdit.optionIdC        = $('#e_optionC').data('optionIdC');
                objEdit.optionIdD        = $('#e_optionD').data('optionIdD');
                //get val details question
                objEdit.lessonId         = $('#e_lessonId').val();
                objEdit.name             = $('#e_name').val();
                objEdit.optionA          = $('#e_optionA').val();
                objEdit.optionB          = $('#e_optionB').val();
                objEdit.optionC          = $('#e_optionC').val();
                objEdit.optionD          = $('#e_optionD').val();
                //get is_correct
                objEdit.aIsCorrect       = $('#e_aIsCorrect').prop('checked');
                objEdit.bIsCorrect       = $('#e_bIsCorrect').prop('checked');
                objEdit.cIsCorrect       = $('#e_cIsCorrect').prop('checked');
                objEdit.dIsCorrect       = $('#e_dIsCorrect').prop('checked');
                console.log('optionIdA:' + objEdit.questionId);
                $.ajax({
                    url: "/admin/question/" + objEdit.questionId,
                    method: "PUT",
                    dataType: "JSON",
                    contentType: 'application/json',
                    data: JSON.stringify(objEdit),
                    success: function (data) {
                        console.log(data);
                        $('#questionEditModal').modal('hide');
                        question.table.ajax.reload(null,false);
                        messenger(data.success);
                    },
                    error: function(data){
                        console.log(data);
                        $.each(data.responseJSON.errors, function(key, val) {
                            $(`.errors-${key}`).text(val);
                        });
                    }

                });
            }
        }
    });
}

question.deleteQuestion = (id) => 
{ 
    bootbox.confirm({
        message: "Delete now?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
            if (result) {
                $.ajax({
                    url: "/admin/question/" + id,
                    method: "DELETE",
                    dataType: "json",
                    contentType: 'application/json',
                    success: function (data) {
                        console.log(data);
                        question.table.ajax.reload(null,false);
                        messenger(data);
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            }
        }
    });
}


question.resetForm = () => 
{
    $('#modalSaveQuestion').on('hidden.bs.modal', function () {
        $('#modalSaveQuestion form')[0].reset();
    });
}

question.init = () => 
{
    question.showData();
    question.getAllLesson();
}


$(document).ready( () => {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    question.init();
});

