// variables
var input = document.querySelector('.ajax_film_title');
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
input.onfocus = function(){ console.log('onclick fieu')

  var row = $(this).closest("tr");
  row.after("<tr ><td id='test1'>blabla</td></tr>");

};

input.onkeyup = function(e) {
  input_val = this.value; // updates the variable on each ocurrence
  field_to_output = this.id;
  autocomplete_results = document.querySelector(".result");
  autocomplete_results.innerHTML = '';
  if (input_val.length > 0) {
    autocomplete_results = document.querySelector(".result");
  loadresults(input_val);
  } 
  else {
    autocomplete_results.innerHTML = '';
  }
}

$(document).on( 'click', '.result_film', function (){
  console.log($("#"+field_to_output).attr('value'));
  console.log(this.innerHTML);
  $("#"+field_to_output).attr('value',this.innerHTML);
  $("#"+field_to_output).trigger('change');
})

function loadresults(input_val) {
  if(currentRequest != null) {
    currentRequest.abort();
   }
  autocomplete_results.innerHTML = "";
  autocomplete_results.innerHTML ='loading...';
  currentRequest =  $.ajax({
        type: "POST",
        url: "http://127.0.0.1:8000/en/handleSearch/"+input_val,
        async:true,
        data: {
           query: 't'
        },
        dataType: "json",
        beforeSend: function() {
          $('#response').html("<img src='../images/ajax-loader.gif' />");
        },
        success: function(response) {
          autocomplete_results.innerHTML = "<ul class='dropdown-menu col-lg-3' >";
            for (i=0; i<Object.keys(response).length;i++){
              console.log(Object.values(response[i]));
              autocomplete_results.innerHTML += '<li ><a id="result_'+i+'" class="btn btn-success result_film" href="#">' + Object.values(response[i]) + '</li>';
            }
            autocomplete_results.innerHTML += '</ul>';
            
        }
    });

}

