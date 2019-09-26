// adds an event listener, executed after document is fully loaded
document.addEventListener("DOMContentLoaded", function(){
  // this variable is created to shorten further statements
  let form = document.forms["sendForm"];
  
  // adds an event listener/a function to the submition of the form
  form.addEventListener("submit", sending);
  
  // prevents the form from default actions
  // prevents submiting to the file stated in the action attribute
  function sending(e) {
    e.preventDefault();
    
    // checks the input not to be empty
    if( !(form["message"].value == "")) {
      let msg = form["message"].value;
      
      // AJAX starts from here
      // creates a XMLHttpRequest object
      let xhr = new XMLHttpRequest();
      
      xhr.onreadystatechange = function() {
        // checks the connection and the response to be successful
        if(this.readyState == 4 && this.status == 200) {
          //console.log(this.responseText);
          document.getElementById("output").innerHTML += this.responseText +"<br>";
        }
      }
      
      // configure the connection to be via post method and be asynchronous
      xhr.open("POST", "sending.php", true);
      
      // sets the header to be able to send via GET & POST
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      
      // builds the massage to be sent
      let params = "msg=" + msg;
      
      // starts the connection
      // sends the message to the php file
      xhr.send(params);
      // AJAX ends here
    } else {
      // outputs an error message
      document.getElementById("output").innerHTML += "<strong style='color=red;'>Input is empty</strong><br>";
    }
  }
});//end of document.addEventListener("DOMContentLoaded"...