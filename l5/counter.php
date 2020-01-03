<?php
if (!isset($_COOKIE["counter"])) {
  setcookie("counter", 1);
  setcookie("visited", "visited", mktime(24,0,0));
} else {
  if (!isset($_COOKIE["visited"])) {
    setcookie("counter", ++$_COOKIE["counter"]);
    setcookie("visited", "visited", mktime(24,0,0));
  }
}
?>
