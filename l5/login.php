<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST["username"];
  $password = hash("sha256", $_POST["password"]);

  $db = new SQLite3("database.db");

  $stmt = $db->prepare("SELECT password FROM USERS WHERE username=:usr");
  $stmt->bindValue(":usr", $username, SQLITE3_TEXT);

  $returned_set = $stmt->execute();

  while($result = $returned_set->fetchArray(SQLITE3_ASSOC)) {
    if ($result["password"] == $password) {
      setcookie("username", $username, time() + 5*60);
      header("Location: /index.php");
    }
  }
  echo "login error.";
}
?>

<form method="post" action="login.php">
  <div class="input-group">
    <label>Username</label>
    <input type="text" name="username">
  </div>
  <div class="input-group">
    <label>Password</label>
    <input type="password" name="password">
  </div>
  <div class="input-group">
    <button type="submit" class="btn">Login</button>
  </div>
  <p>
    Does not have account? <a href="registration.php">Sign up</a>
  </p>
</form>
