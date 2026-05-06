<?php
if(!isset($_SESSION)){
    session_start();
}
include('config.php');
include('variableAndFunctions.php');

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute
    $stmt = $dbconnect->prepare("SELECT * FROM userdata WHERE email=?");
		$stmt->execute([$email]); 
		$user = $stmt->fetch();

    if ($user) {
        $db_password = $user['password'];

        if (password_verify($password, $db_password)) {
            $message = "Login successful";
            $toastClass = "success";
            $_SESSION['email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            $message = "Incorrect password";
            $toastClass = "error";
        }
    } else {
        $message = "Email not found";
        $toastClass = "warning";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=
"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
		<link href="output.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="favicon.png">
    <title>Login</title>
</head>

<body>
	<div class="navbar shadow-sm">
    <div class="navbar-start">
      <a class="btn btn-ghost text-xl" href="index.php">╚(•⌂•)╝</a>
    </div>
    <div class="navbar-end">
      <a class="btn btn-ghost text-xl" href="register.php">Register</a>
      <a class="btn btn-active text-xl">Login</a>
      <?php
      if(array_key_exists('email', $_SESSION)) {
        echo '<a class="btn btn-warning text-xl" href="logout.php">Logout</a>';
      }
      ?>
    </div>
	</div>
	
    <div class="xs:w-auto sm:w-2/3 md:w-1/2 lg:w-5/12 xl:w-1/3 2xl:w-1/4 mx-auto">
      <h1 class="text-4xl text-center my-8">Login</h1>
        <?php if ($message): ?>
        <div class="toast">
          <div class="alert alert-<?php echo $toastClass; ?>">
            <span><?php echo $message; ?></span>
          </div>
        </div>
        <?php endif; ?>
        <form action="" method="post">
            
            <div class="text-center">
                <i class="fa fa-user-circle-o fa-3x mt-1 mb-2"></i>
                <h5 class="text-center p-4">Login Into Your Account</h5>
            </div>
            <fieldset class="fieldset">
                <legend class="fieldset-legend"><i class="fa fa-envelope"></i> Email</legend>
                <input type="text" name="email" id="email" class="input w-full" required>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend"><i class="fa fa-lock"></i> Password</legend>
                <input type="password" name="password" id="password" class="input w-full" required>
            </fieldset>
            <div class="mb-3 mt-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div>
                <p class="text-center">
                  <a href="./register.php" >Create Account</a> OR <a href="./resetpassword.php">Forgot Password</a>
                </p>
            </div>
        </form>
    </div>
    <script>
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 3000 });
        });
        toastList.forEach(toast => toast.show());
    </script>
</body>

</html>
