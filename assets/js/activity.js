

$(document).on('change','#project_action', function() {
    let $field = $(this)
    console.log($field.val())
    let $form = $field.closest('form')
    console.log($form)
    let data = {}
    data[$field.attr('name')] = $field.val()
    $.post($form.attr('action'), data).then(function (data){
        debugger
        let $input = $(data).find('#project_activities')
        $('#project_activities').replaceWith($input)
    })

})