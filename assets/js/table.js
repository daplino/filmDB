const $ = require('jquery');

var $collectionHolder;
var $addNewItem = $('<a href="#" class="btn btn-info">Add new item</a>');

$(document).ready(function ($) {

    $collectionHolder = $('#project_activities');
    $collectionHolder.append($addNewItem);
    $collectionHolder.data('index', $collectionHolder.find('tr').length);
    $collectionHolder.find('tbody>tr').each(function () {
        addRemoveButton($(this));
    });
    
    console.log($collectionHolder.find('tbody').find('tr').length);
    $addNewItem.click(function (e) {
        e.preventDefault();
        addNewForm();
    })
});


function addNewForm() {

    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index+1);
    var $panel = $('<tr></tr>').append(newForm);
    $collectionHolder.find('tbody').append($panel);
    console.log($collectionHolder.find('tbody').find('tr').length);

}

/**
 * adds a remove button to the panel that is passed in the parameter
 * @param $panel
 */
function addRemoveButton ($panel) {
    var $removeButton = $('<a class="fas fa-trash-alt" >');
    var $panelBody = $('<td style="width: 5%; padding:0 !important;"></td>').append($removeButton);
    $removeButton.click(function (e) {
        e.preventDefault();
        $(e.target).parents('tr').slideUp(1000, function () {
            $(this).remove();
        })
    });
    $panel.append($panelBody);
}

