const $ = require('jquery');
var action = document.querySelector('#project_action');
var $collectionHolder;
var $addNewItem = $('<a href="#" class="btn btn-info">Add new item</a>');

$(document).ready(function ($) {

    $collectionHolder = $('#project_activities');
    $collectionHolder.append($addNewItem);
    $collectionHolder.data('index', $collectionHolder.find('tr').length)
    $collectionHolder.find('tbody>tr').each(function () {
        addRemoveButton($(this));
    });
    
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
    addRemoveButton($panel);
    $collectionHolder.find('tbody').append($panel);

}

/**
 * adds a remove button to the panel that is passed in the parameter
 * @param $panel
 */
function addRemoveButton ($panel) {
    var $removeButton = $('<span style="color: Tomato;"><a href="#"><i class="fas fa-trash-alt " style="color: Tomato;"></i></span>');
    var $panelBody = $('<td style="width: 5%; padding:0 !important;"></td>').append($removeButton);
    $removeButton.click(function (e) {
        e.preventDefault();
        $(e.target).parents('tr').slideUp(1000, function () {
            $(this).remove();
        })
    });
    $panel.append($panelBody);
}

/*action.onchange = function() {
    $collectionHolder.find('tbody').html("");
    action_val = this.value;
    loadconfig(action_val);
    /*input_val = this.value; // updates the variable on each ocurrence
    autocomplete_results = document.querySelector("#form_result");
    autocomplete_results.innerHTML = '';
    if (input_val.length > 0) {
      autocomplete_results = document.querySelector("#form_result");
    loadresults(input_val);
    } 
    else {
      autocomplete_results.innerHTML = '';
    }
  }

function loadconfig(input_val) {
    $collectionHolder.find('tbody').html('loading...');
  
    currentRequest =  $.ajax({
          type: "POST",
          url: "http://127.0.0.1:8000/en/handleAction/"+input_val,
          async:true,
          data: {
             query: 't'
          },
          dataType: "json",
          
          success: function(response) {
            $collectionHolder.find('tbody').html('');
              for (i=0; i<Object.keys(response).length;i++){
                console.log(response[i].activityType);
                for(j=0; j<response[i].minNbActivities;j++){
                    addNewForm();
                    $('#project_activities_'+(j+1)+'_type').attr('value',response[j].activityType); 
                    console.log('#project_activities_'+(j+1)+'type')

                }
              }
             
          }
      });
  
  }*/
  