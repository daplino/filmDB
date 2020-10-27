// variables
var input = document.querySelector('#form_query');
currentRequest = null;
var results;

// functions
function autocomplete(val) {
  var people_return = [];

  for (i = 0; i < people.length; i++) {
    if (people[i].search(val)>=3) {
      people_return.push(people[i]);
    }
  }

  return people_return;
}

// events
input.onkeyup = function(e) {
  input_val = this.value; // updates the variable on each ocurrence
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

function loadresults(input_val) {
  if(currentRequest != null) {
    currentRequest.abort();
   }
  autocomplete_results.innerHTML = "";

  currentRequest =  $.ajax({
        type: "POST",
        url: "handleSearch/"+input_val,
        async:true,
        data: {
           query: 't'
        },
        dataType: "json",
        success: function(response) {
          autocomplete_results.innerHTML = "<ul class='dropdown-menu col-lg-3' >";
            for (i=0; i<Object.keys(response).length;i++){
              autocomplete_results.innerHTML += '<li ><a class="btn btn-success" href="#">' + Object.values(response[i]) + '</li>';
            }
            autocomplete_results.innerHTML += '</ul>';
            
        }
    });

}

