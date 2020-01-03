<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST["username"];
  $password = hash("sha256", $_POST["password"]);

  $db = new SQLite3("database.db");

  $stmt = $db->prepare("INSERT INTO USERS VALUES (:usr, :psw)");
  $stmt->bindValue(":usr", $username, SQLITE3_TEXT);
  $stmt->bindValue(":psw", $password, SQLITE3_TEXT);
  
  if ($stmt->execute()) {
    setcookie("username", $username, time() + 60*5);
  }
}
?>

<form method="post" action="registration.php">
  <div class="input-group">
    <label>Username</label>
    <input type="text" name="username">
  </div>
  <div class="input-group">
    <label>Password</label>
    <input type="password" name="password">
  </div>
  <div class="input-group">
    <button type="submit" class="btn">Register</button>
  </div>
  <p>
    Already a member? <a href="login.php">Sign in</a>
  </p>
</form>
