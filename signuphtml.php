<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Sign Up</h2>
    <form action="register.php" method="POST">
      <div class="form-group">
        <label for="first-name">First Name:</label>
        <input type="text" id="first-name" name="first-name" required>
      </div>
      <div class="form-group">
        <label for="middle-initial">Middle Initial:</label>
        <input type="text" id="middle-initial" name="middle-initial" maxlength="1">
      </div>
      <div class="form-group">
        <label for="last-name">Last Name:</label>
        <input type="text" id="last-name" name="last-name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>
      </div>
      <div class="form-group">
        <label for="repeat-password">Confirm Password:</label>
        <input type="password" id="repeat-password" name="repeat-password" required>
      </div>
      <button type="submit" name="submit">Sign Up</button> <!-- Added name attribute to the submit button -->
    </form>
  </div>
</body>
</html>
