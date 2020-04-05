$(document).ready(function() {
  $("form").submit(function(event) {
    event.preventDefault();
    var username = $("#username_").val();
    var password = $("#password_").val();
    var submit = $("#submit-but").val();

    $.ajax({
                type: 'POST',
                url: "login.php",
                data: {
                  username: username,
                  password: password,
                  submit: submit,
                },
                dataType: 'json',
                success: function(data) {
                  if(data[0] == false && data[1] == false) {
                    alert(data);
                    window.location = "admin_page.php";
                  }
                  if(data[0] == true) {
                    $("#username_").addClass("input-error");
                  }
                  if(data[1] == true) {
                    $("#password_").addClass("input-error");
                  }
                  if(data[0] == true && data[1] == true) {
                    alert("No such account exist!");
                  }
                }
            });
  });
});
