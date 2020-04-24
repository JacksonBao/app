var locationURL = "/post/location";
function log(res) {
  console.log(res);
}

// product checker
function checkAll(e, n) {
	var checkboxes = document.getElementsByName(n);
	for (var i = checkboxes.length - 1; i >= 0; i--) {
		// if(i == 0 || i == checkboxes.length - 1){ continue;}
		var checkbox = checkboxes[i];
		if(e.checked == true && checkbox.checked == false){ checkbox.checked = true; } else if(e.checked == false) { checkbox.checked = false; }
	}
}


// manage register responsive
function manageResponse(res) {
  log(res);
  try{
    var json = JSON.parse(res);
    if(json.status == 200){
      snackBar(json.response, 'success');
      return json;
    } else if(json.id.length > 0 && json.phase > 0) {
      phaser(json.phase);
      formErr(json.id, json.response);
      return false;
    } else if(json.id.length > 0) {
      formErr(json.id, json.response);
      snackBar(json.response, 'danger');
      return false;
    } else {
      snackBar(json.response, 'danger');
      return false;
    }
  } catch(e) {
  return false;
  }
}


   $(document).ready(function () {

        $('#dismiss, .overlay').on('click', function () {
            // hide sidebar
            $('#sidebar').removeClass('active');
            // hide overlay
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function () {
            // open sidebar
            $('#sidebar').addClass('active');
            // fade in the overlay
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });



    // auto complet function
    function inputAutocomplete(inp, arr) {

      /*the autocomplete function takes two arguments,
      the text field element and an array of possible autocompleted values:*/
      var currentFocus;
      /*execute a function when someone writes in the text field:*/
      inp.addEventListener("input", function(e) {
          var a, b, i, val = this.value;
          /*close any already open lists of autocompleted values*/
          closeAllLists();
          if (!val) { return false;}
          currentFocus = -1;
          /*create a DIV element that will contain the items (values):*/
          a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.setAttribute("class", "autocomplete-items");
          /*append the DIV element as a child of the autocomplete container:*/
          this.parentNode.appendChild(a);
          /*for each item in the array...*/
          // check to see if this item has data-autocomplete-list objec
          if(this.getAttribute('data-autocomplete-list')){
            arr =JSON.parse(this.getAttribute('data-autocomplete-list'));
          }
          for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              /*create a DIV element for each matching element:*/
              b = document.createElement("DIV");
              /*make the matching letters bold:*/
              b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML += arr[i].substr(val.length);
              /*insert a input field that will hold the current array item's value:*/
              b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
              /*execute a function when someone clicks on the item value (DIV element):*/
                  b.addEventListener("click", function(e) {
                  /*insert the value for the autocomplete text field:*/
                  inp.value = this.getElementsByTagName("input")[0].value;
                  /*close the list of autocompleted values,
                  (or any other open lists of autocompleted values:*/
                  closeAllLists();
              });
              a.appendChild(b);
            }
          }
      });
      /*execute a function presses a key on the keyboard:*/
      inp.addEventListener("keydown", function(e) {
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) x = x.getElementsByTagName("div");
          if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
          } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
          } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
              /*and simulate a click on the "active" item:*/
              if (x) x[currentFocus].click();
            }
          }
      });
      function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
      }
      function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
          x[i].classList.remove("autocomplete-active");
        }
      }
      function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
          if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
    }

    // end auto complete

    // drop down naviation
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */

    function inputFilterDropdown(e) {

      var input, filter, ul, li, a, i;
      if(_(''+e+'_wrap').style.display == 'none'){
      $('#'+e+'_wrap').slideToggle();
        }
      input = document.getElementById(e);
      filter = input.value.toUpperCase();
      div = document.getElementById(e+'_container');

      a = div.getElementsByTagName("a");
      for (i = 0; i < a.length; i++) {
        if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
          a[i].style.display = "";
        } else {
          a[i].style.display = "none";
        }
      }
    }

    function inputFilterSelect(e, i){
        $('#'+e).val($(i).html());
        $('#'+e+'_wrap').slideToggle();

    }

    // end drop


// return id
function _(x) {
  return document.getElementById(x);
}

// function for content form error
function formErr(id, err){
  $('#' + id).addClass('is-invalid');
  _(id).parentNode.scrollIntoView();

// scroll to your element
_(id).scrollIntoView(true);

// now account for fixed header
var scrolledY = window.scrollY;
if(scrolledY){
  window.scroll(0, scrolledY - 90);
}

  $('#'+ id + 'Status').html('<small class="w3-text-red">' + err + '</small>');

  setTimeout(function (){
    $('#' + id).removeClass('is-invalid');
    $('#'+ id + 'Status').html('');
    }, 5000);
}
// sncak bar functions
function snackBar(msg, cls) {
  var x = _("snackbar");
  // add success or danger classes
  if(cls){
    $('#snackbar').addClass('snackbar-' + cls + ' ' + cls);
  }
  // add success or danger classes
  $('#snackbar').addClass('show');
  x.innerHTML = msg;
  setTimeout(function(){ $('#snackbar').attr('class', " "); }, 5000);
}
// sncak bar functions


//location navigation
function getLocationList(func, inp) {// f = func, c = id of input of parent, e.g to get state you send id of country
    var elle = $('#' + inp).val();
    if(elle.length > 0){
        $.post(locationURL, {
            func, elle
        }, function (resp) {
            var data = JSON.parse(resp);
            if(data.status == 200){
              $('#' + inp).setAttribute('data-autocomplete-list', data.response);
            } else {
              snackBar(data.response, 'danger');
            }
        });
    }
}
