import $ from 'jquery';
var $collectionHolder;
var $addNewItem = $('<a href="#" class="btn btn-info">Add new item</a>');
var sumVal;

// when the page is loaded and ready
$(document).ready(function ($) {
    // get the collectionHolder, initilize the var by getting the list;
    $collectionHolder = $('#crew_list_table');
    // append the add new item link to the collectionHolder
    $collectionHolder.append($addNewItem);
    // add an index property to the collectionHolder which helps track the count of forms we have in the list
    $collectionHolder.data('index', $collectionHolder.find('tr').length)
    // finds all the panels in the list and foreach one of them we add a remove button to it
    // add remove button to existing items
    $collectionHolder.find('tbody>tr').each(function () {
        // $(this) means the current panel that we are at
        // which means we pass the panel to the addRemoveButton function
        // inside the function we create a footer and remove link and append them to the panel
        // more informations in the function inside
        addRemoveButton($(this));
        calcTotal();
        
    });
    // handle the click event for addNewItem
    $addNewItem.click(function (e) {
        // preventDefault() is your  homework if you don't know what it is
        // also look up preventPropagation both are usefull
        e.preventDefault();
        // create a new form and append it to the collectionHolder
        // and by form we mean a new panel which contains the form
        addNewForm();
    })

    $('.points').change(function() {
       
        calcTotal();
    });
});



/*
 * creates a new form and appends it to the collectionHolder
 */
function addNewForm() {
    // getting the prototype
    // the prototype is the form itself, plain html
    var prototype = $collectionHolder.data('prototype');
    // get the index
    // this is the index we set when the document was ready, look above for more info
    var index = $collectionHolder.data('index');
    // create the form
    var newForm = prototype;
    // replace the __name__ string in the html using a regular expression with the index value
    newForm = newForm.replace(/__name__/g, index);
    // incrementing the index data and setting it again to the collectionHolder
    $collectionHolder.data('index', index+1);
    // create the panel
    // this is the panel that will be appending to the collectionHolder
    var $panel = $('<tr></tr>').append(newForm);
    // create the panel-body and append the form to it
    //var $panelBody = $('<td></td>').append(newForm);
    // append the removebutton to the new panel
    //addRemoveButton($panelBody);
    // append the body to the panel
    //$panel.append($panelBody);
    addRemoveButton($panel);
    $collectionHolder.find('tbody').append($panel);
    // append the panel to the addNewItem
    // we are doing it this way to that the link is always at the bottom of the collectionHolder
    //$addNewItem.before($panel);
}

/**
 * adds a remove button to the panel that is passed in the parameter
 * @param $panel
 */
function addRemoveButton ($panel) {
    // create remove button
    var $removeButton = $('<span style="color: Tomato;"><a href="#"><i class="fas fa-trash-alt " style="color: Tomato;"></i></span>');
    // appending the removebutton to the panel footer
    var $panelBody = $('<td style="width: 5%; padding:0 !important;"></td>').append($removeButton);
    // handle the click event of the remove button
    $removeButton.click(function (e) {
        e.preventDefault();
        // gets the parent of the button that we clicked on "the panel" and animates it
        // after the animation is done the element (the panel) is removed from the html
        $(e.target).parents('tr').slideUp(1000, function () {
            $(this).remove();
        })
    });
    // append the footer to the panel
    $panel.append($panelBody);
}
/*
 * calculate total
 */
function calcTotal() {
var table = document.getElementById("crew_list_table"),
        sumVal = 0;
        console.log("test"+table.rows.length); 
      for (var i = 1; i < table.rows.length; i++) {
        sumVal = sumVal + parseFloat(table.rows[i].cells[6].children[0].value);
        console.log("test"+table.rows[i].cells[6].children[0].value); 
      };
      
      document.getElementById("val").innerHTML = "Total = " + sumVal;
      console.log(sumVal);
    }