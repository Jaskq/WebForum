<?php
  require_once 'headbar.php';
  function generatePage($body, $title="Sample Forum") {
    $head = generateHeadbar();
    $page = <<<PAGE
      <!doctype html>
      <html>
          <head>
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
              <title>$title</title>
              <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
              <link rel="stylesheet" href="./forum.css" media="screen" title="no title" charset="utf-8">
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
              <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
          </head>
          <body class = "body">
          <div class="container">
            <header>
              $head
              <h1>$title</h1>
            </header>
            <div class="col-md-12">
              $body
            </div>
            <script type="text/javascript">
              $('header h1').click(function(){
                window.location.href = "homepage.php";
              });

              $('h3').click(function(){
                var title = $(this).text();
                var location = "forum.php?title=" + title;
                window.location.href = location;
              });

              $('div h5').click(function(){
                var title = $(this).text();
                var location = "userpage.php?poster=" + title;
                window.location.href = location;
              });

              $(document).ready(function(){
                var comment = "";
                var commentId = "";

                $('span#edit').on("click", function(){
                  comment = $(this).parent().parent().children(".comment");
                  commentId = $(this).parent().parent().children(".hidden");
                  commentId = commentId.text().trim();
                  var commentText = comment.text().trim();

                  $('#replyModal').on('show.bs.modal', function (event) {
                    var modal = $(this);
                     $('#replyModal .modal-dialog .modal-content .modal-body #editable').text(commentText);
                  });
                  $('#replyModal').modal();
                });

                $('#replyModal .modal-dialog .modal-content .modal-footer #commentSave').on('click', function(){
                  var text = $('#replyModal .modal-dialog .modal-content .modal-body #editable').val();
                  comment.text(text);

                  var http=new XMLHttpRequest();
                  var url = "editReply.php";
                  var parameters = "mode=edit&comment="+text+"&id="+commentId;

                  http.open("POST", url, false);
                  http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                  http.setRequestHeader("Content-length", parameters.length);
                  http.setRequestHeader("Connection", "close");
                  http.onreadystatechange = function() {
	                  if(http.readyState == 4 && http.status == 200) {
		                  //alert(http.responseText);
	                  }
                  }
                  http.send(parameters);
                });
              });



            </script>
          </body>
      </html>
PAGE;
    return $page;
  }
?>
