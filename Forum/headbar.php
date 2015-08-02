<?php

require_once 'dbaccess.php';
require_once 'dblogin.php';

session_start();

// Check Login Button.
if(isset($_GET['login'])){
  $username = $_GET['username'];
  $password = crypt($_GET['password'], BY_CRYPT);

  // Check to see if the user exists in the databse;
  $userDb = new DbAcess($host, $user, $password, $database);

  // Build the select query.
  $fields = ['username'];
  $where = "email = '{$username}' and password = '{$password}'";
  $result = $userDb->selectDB('users', $where, $fields);

  if (!$result) {
    die("Insertion failed: " . $db->db_connection->error);
  } else {
    $num_rows = $result->num_rows;
    if ($num_rows === 0) {
    } else {
      $result->data_seek($row_index);
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $_SESSION['username'] = $row['username'];
      header('Location: homepage.php');
    }
  }
}

function generateHeadbar(){

  $headbar = "";

  # If the user is logged in.
  if(isset($_SESSION['username'])){

    $username = $_SESSION['username'];

    $headbar = <<<LABEL

    <div class="headbar">
      <div class="dropdown">
        <button type="button" name="userpage" id="usernameDropdown"
        class="btn btn-primary dropdown-toggle"
        aria-haspopup="true" aria-expanded="true" data-toggle="dropdown">
        $username <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
        <li><a href="homepage.php">Homepage</a></li>
        <li><a href="userpage.php?=username=$username">Userpage</a></li>
        <li class="newForum"><a href="#" data-toggle="modal" data-target=".forum-modal-sm">
          New Topic</a></li>
        </ul>
      </div>
    </div>

    <div class="modal fade forum-modal-sm" tabindex="-1" role="dialog"
      aria-labelledby="myLargeModalLabel">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"
              aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">New Topic</h4>
          </div>

          <div class="modal-body">
            <form id="submitForum" action="submitForum.php" method="post">
              <div class="form-group">
                <label for="Forum Title">Title</label>
                <input type="text" class="form-control" name="title"
                id="title" placeholder="Forum Title" required>
              </div>
              <hr>
              <div class="form-group">
                <label for="Forum Text">Text</label>
                <textarea form="submitForum" rows="10" cols="35" name="forumText">Enter text here..</textarea>
              </div>

            </form>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" form="submitForum" class="btn btn-primary" name="submit">Submit</button>
          </div>
        </div>
      </div>
    </div>

LABEL;

  } else {
    $headbar = <<<LABEL
      <div class="headbar">
        Welcome to the Sample Forum.
        <button type="button" name="login" id="login" class="btn btn-primary"
          data-toggle="modal" data-target=".login-modal-sm"> Log in </button>
        <button type="button" name="signup" id="signup" class="btn btn-primary"
          data-toggle="modal" data-target=".signup-modal-sm"> Sign up </button>
      </div>

      <div class="modal fade login-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
              <form id="loginForm" action="login.php" method="post">
                <div class="form-group">
                  <label for="loginUsername">Email</label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Exampler" required>
                </div>
                <div class="form-group">
                  <label for="loginPassword">Password</label>
                  <input type="password" class="form-control" name="password" id="password" placeholder="Abc.. 123.." required>
                </div>
              </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" form="loginForm" class="btn btn-primary" name="login">Login</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade signup-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Sign up!</h4>
            </div>
            <div class="modal-body">
              <form action="signup.php" id="signupForm" method="post">
                <div class="form-group">
                  <label for="signupUsername" id="Username" >Username :</label>
                  <input type="text" class="form-control" name="username"
                    id="username" placeholder="Username"
                    onkeyup="validateUser(this.value)" required>
                </div>

                <div class="form-group">
                  <label for="signupEmail">Email :</label>
                  <input type="text" class="form-control" name="email"
                    id="email" placeholder="Example@example.com" required>
                </div>

                <div class="form-group">
                  <label for="signupPassword">Password :</label>
                  <input type="text" class="form-control" name="password" id="password" placeholder="Abc.. 123.." required>
                </div>

                <div class="form-group">
                  <label for="signupVerify">Verify password :</label>
                  <input type="text" class="form-control" name="verify" id="verify" placeholder="Abc.. 123.." required>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" form="signupForm" class="btn btn-primary">Sign Up</button>
                </div>
              </form>
            </div>
            <script type="text/javascript">
              var usernameValidation = "";
              $('#signupForm').submit(function (evt) {

                  var formValidation = "";
                  if(evt.target[0].value.length > 30 || evt.target[0].value.length < 5){
                    formValidation += "Username must be between 5 and 30 characters.\\n";
                  }

                  // Password
                  if(evt.target[2].value.length > 30 || evt.target[2].value.length < 7){
                    formValidation += "Password must be between 8 and 30 characters.\\n";
                  }

                  // Verify password
                  if(evt.target[2].value != evt.target[3].value){
                    formValidation += "Password and verification do not match."
                  }
                  // Form Validation check.

                  if(formValidation != ""){
                    alert(formValidation);
                    evt.preventDefault();
                  }else if (usernameValidation != "") {
                    alert("Username already exists.");
                    evt.preventDefault();
                  }

              });
              function validateUser(str) {
                var xmlhttp=new XMLHttpRequest();
                xmlhttp.onreadystatechange = new function() {
                  xmlhttp.open("GET", "verification.php?username=" + str, false);
                  xmlhttp.send();
                  if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var usernameValidation = xmlhttp.responseText;
                    document.getElementById("Username").innerHTML = xmlhttp.responseText;
                    if(usernameValidation == "<span class=\"validUser\">Username : Valid </span>"){
                      usernameValidation = "";
                    }
                  }
                }
              }
            </script>
          </div>
        </div>
      </div>

LABEL;
  }

  return $headbar;
}
?>
