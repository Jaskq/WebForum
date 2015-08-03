<?php

  include_once 'dbaccess.php';

  class Thread {

    private $titles;
    private $posters;
    private $comments;
    private $host;
    private $user;
    private $password;
    private $database;
    private $ids;

    function __construct($where){

      $this->titles = array();
      $this->posters = array();
      $this->comments = array();
      $this->ids = array();
      $this->host = 'localhost';
      $this->user = 'forumUser';
      $this->password = '';
      $this->database = 'forumDB';

      $order = "'id'";
      $db = new DbAccess($this->host, $this->user, $this->password, $this->database);
      $result = $db->selectDB("threads", $where, '', $order);
      if($result){
        $rows = $result->num_rows;
        for ($i = 0; $i < $rows; $i++) {
          $result->data_seek($i);
          $row = $result->fetch_array(MYSQLI_ASSOC);
          array_push($this->titles, $row['title']);
          array_push($this->posters, $row['poster']);
          array_push($this->comments, $row['comment']);
          array_push($this->ids, $row['id']);
        }
      }
    }

    function commentModifiers($username="", $poster){
      $output = "<h6>";
      if($username == $poster){
        $output .= <<<PAGE
          <span id="edit"><u>edit</u></span>
PAGE;
      }
      if($username != ""){
        $output .=<<<PAGE
          <span id="reply"><u>reply</u></span>
          </h6>
PAGE;
      }
      $output .=<<<PAGE
        <div class="modal fade" id="replyModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit your comment</h4>
              </div>
                <div class="modal-body">
                  <textarea id="editable" rows="8" cols="78"></textarea>
                </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="commentSave">Save changes</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="replyModal">
          <div class="modal-dialog">
            <div class="model-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Reply</h4>
              </div>
              <div class="modal-body">
                <div class="repliableComment"></div>
                <textarea class="repliable" rows="8" cols="78"></textarea>
              </div>
              <div class ="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="commentSave">Save changes</button>
              </div>
            </div>
          </div>
        </div>
PAGE;
      return $output;
    }

    function displayThread($username=""){
      $output = "";
      $size = count($this->titles);
      for($i = 0; $i < $size; $i++){
        $title = $this->titles[$i];
        $comment = $this->comments[$i];
        $poster = $this->posters[$i];
        $id = $this->ids[$i];
        $output .=<<<PAGE
        <div class="row">
          <p hidden>$id</p>
          <h3>$title</h3>
          <div>
            <p class="comment">
            $comment
            </p>
            <p class="hidden" hidden>$id</p>
          <h5 class="username">by : $poster</h5>
PAGE;
        $output .= $this->commentModifiers($username, $poster);
        $output .= <<<PAGE
          </div>
          <hr>
          </div>
PAGE;
      }
      return $output;
    }
  }

?>
