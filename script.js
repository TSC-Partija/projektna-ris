// Create a "close" button and append it to each list item
var myNodelist = document.getElementsByTagName("LI");
var i;
for (i = 0; i < myNodelist.length; i++) {
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  myNodelist[i].appendChild(span);
}

// Click on a close button to hide the current list item
var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}

// Add a "checked" symbol when clicking on a list item
var list = document.querySelector('ul');
list.addEventListener('click', function(ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);

// Create a new list item when clicking on the "Add" button
function newElement() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("todo").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("You must write something!");
  } else {
    //document.getElementById("myUL").appendChild(li);
    var dropdown = document.getElementById("groups");
    var selectedGroup = dropdown.value;
    var dateInput = document.getElementById("date");
    var dateValue = dateInput.value;
    let data = {
      toDo: inputValue,
      groupId: selectedGroup,
      deadline: dateValue
    }
    
    // Create a new XMLHttpRequest object
    let xhr = new XMLHttpRequest();

    // Set the request URL and method
    xhr.open("POST", "add.php");

    // Set the request header to indicate the data type
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

    // Define a callback function to handle the server's response
    xhr.onload = function() {
        if (xhr.status === 200) {
            location.reload();
        }
    };

    // Convert the data to a JSON string and send it to the server
    xhr.send(JSON.stringify(data));
  }
  document.getElementById("todo").value = "";

  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }
}