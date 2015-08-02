<?php

require_once 'dblogin.php';
require_once 'dbaccess.php';
require_once 'headbar.php';
require_once 'generator.php';

$body = "";
$title = $_GET['title'];
$db = new dbAccess($host, $user, $password, $database);
$where = "title = '$title'";
$order = "'id'";

$result = $db->selectDB('threads', $where, '', $order);
if(!$result){

  //This thread does not exists.

} else {
  $rows = $result->num_rows;
  for ($i = 0; $i < $rows; $i++) {
    $result->data_seek($i);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $body.= comment($row['poster'], $row['comment']);
  }
}

$body .= <<<SCRIPT

  $('#row').submit(function (evt) {
      if()
  }
SCRIPT;


$page = generatePage($body, $title);
echo $page;

function comment($poster, $comment){

  $temp = <<<LABEL

    <div class="row">
      <h6>$poster :</h6>
      <p>$comment</p>
      <hr>
    </div>
LABEL;

  return $temp;
}
?>
