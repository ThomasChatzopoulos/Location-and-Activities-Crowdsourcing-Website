$(document).ready(function() {
  $("form").submit(function(event) {
    event.preventDefault();
    var username = $("#_username_").val();
    var password = $("#_password_").val();
    var rpassword = $("#_Rpassword_").val();
    var fname = $("#_fname_").val();
    var lname = $("#_lname_").val();
    var email = $("#_email_").val();
    var submit_ = $("#_sign-but_").val();

    $.ajax({
        type: 'POST',
        url: "signUp.php",
        data: {
          username: username,
          password: password,
          rpassword: rpassword,
          fname: fname,
          lname: lname,
          email: email,
          submit_: submit_
        },
        dataType: 'json',
        error: function(xhr, status, error) {
        alert(xhr.responseText);
        },
        success: function(data) {
          if(data[0] == false && data[1] == false && data[2] == false && data[3] == false) {
            window.location = "admin_page.php";
            alert("Sign Up successful");
          }
          $(".form-message").empty();
          $("#_username_").removeClass("input-error");
          $("#_password_, #_Rpassword_").removeClass("input-error");
          if(data[3] == true) {
            $("#_username_").addClass("input-error");
            $(".form-message").append('Username already exists');
          }
          if(data[2] == true) {
            $("#_password_, #_Rpassword_").addClass("input-error");
            $(".form-message").append('Invalid password. Password must have at least an Uppercase character, a number and a special symbol and must have at least 8 lenght');
          }
          if(data[1] == true) {
            $("#_password_, #_Rpassword_").addClass("input-error");
            $(".form-message").append("Passwords don't match");
          }
          if(data[0] == true) {
            alert("Sql error");
          }
        }
    });
  });
});
