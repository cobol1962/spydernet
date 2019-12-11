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
  header('Content-Type: application/json');
  $action = $_GET["request"];
  $r = $action($_POST, $mysqli);
  echo json_encode($r);
  exit;
  function getPage($post, $mysqli) {
    $doc = new DOMDocument();
    $doc->loadHTMLFile($post["url"]);
    $text = "";
    $tags = $doc->getElementsByTagName('*');
    foreach ($tags as $t) {
      if (count($t->getElementsByTagName('*')) == 0) {
        if ($t->nodeName != "script" && $t->nodeName != "button" && $t->nodeName != "a" && $t->nodeName != "br" && $t->nodeName != "img"  && $t->nodeName != "ul"  && $t->nodeName != "li") {
          if ($t->parentNode->nodeName != "a" && $t->parentNode->nodeName != "button" && $t->parentNode->nodeName != "ul" && $t->parentNode->nodeName != "li") {
            $t = preg_replace('/\s+/', ' ', $t->nodeValue) . " ";
            $text .= ($t);

          }
        }
      }
    }
    return ["status" => "ok", "text" => $text];
  }

?>
