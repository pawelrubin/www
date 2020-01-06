<?php
if (!isset($_COOKIE["counter"])) {
  setcookie("counter", 1, time() + (10 * 365 * 24 * 60 * 60));
  setcookie("visited", "visited", mktime(24,0,0));
} else {
  if (!isset($_COOKIE["visited"])) {
    setcookie("counter", ++$_COOKIE["counter"], time() + (10 * 365 * 24 * 60 * 60));
    setcookie("visited", "visited", mktime(24,0,0));
  }
}
?>
