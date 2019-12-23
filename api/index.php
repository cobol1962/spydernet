<?php
  session_start();

/*  if (!isset($_SERVER["HTTP_REFERER"])) {
    header('HTTP/1.0 403 Forbidden', true, 403);
    die;
  }
  if (!strpos($_SERVER["HTTP_REFERER"], $_SERVER['HTTP_HOST'])) {
    header('HTTP/1.0 403 Forbidden', true, 403);
    die;
  }*/
  include "../config/database.php";
  include_once '../libs/simple_html_dom.php';
  header('Content-Type: application/json');
  $action = $_GET["request"];
  $r = $action($_POST, $mysqli);
  echo json_encode($r);
  exit;
  function getPage($post, $mysqli) {
    $html = file_get_html($post["url"]);
    foreach ($html->find('img') as $element) {
      if (!url_exists($element->src)) {
        $element->src = $post["host"] . $element->src;
      }
    }
    foreach ($html->find('link') as $element) {
      if (!url_exists($element->href)) {
        $element->href = $post["host"] . $element->href;
      }
    }

    foreach ($html->find('a') as $element) {
      if (!url_exists($element->href)) {
        $element->href = $post["host"] . $element->href;
      }
    }
    $n = time() . ".html";
    $html->save("../temp/" . $n);
    return ["status" => "ok", "src" => "/temp/" . $n];
  }
  function url_exists($url) {
    $file = $url;
    $file_headers = @get_headers($file);
    if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        $exists = false;
    }
    else {
        $exists = true;
    }
    if (begnWith($url, "//")) {
      $exists = true;
    }
    return $exists;
  }
  function begnWith($str, $begnString) {
    $len = strlen($begnString);
    return (substr($str, 0, $len) === $begnString);
  }
  function getTags($post, $mysqli) {
    $res = [$post["tag"]];
    $sql = "select * from `tags` where `text`='" .  $post["tag"] . "' LIMIT 1";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 0) {
      $sql = "insert into `tags` (`text`,`name`,`parent_id`) values ('" . $post["tag"] . "','" . $post["tag"] . "','1')";
      $mysqli->query($sql);
      return $res;
    }
    while ($row = mysqli_fetch_assoc($result)) {
       if ($row["parent_id"] == "1") {
           $s = "select * from `tags` where `parent_id`='" .  $row["id"] . "'";
           $r = $mysqli->query($s);
           while ($r1 = mysqli_fetch_assoc($r)) { 
             $res[] = $r1["text"];
           }
       }
    }
    return $res;
  }
?>
