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
    <title>Login</title>
</head>

<body>
	<div class="navbar bg-amber-950 shadow-sm">
    <div class="navbar-start">
      <a class="btn btn-ghost text-xl" href="index.php">╚(•⌂•)╝</a>
    </div>
    <div class="navbar-end">
      <a class="btn btn-ghost text-xl" href="register.php">Register</a>
      <a class="btn btn-ghost text-xl">Login</a>
    </div>
	</div>
	
    <div class="container p-5 d-flex flex-column align-items-center">
        <?php if ($message): ?>
            <div class="toast align-items-center text-white 
            <?php echo $toastClass; ?> border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $message; ?>
                    </div>
                    <button type="button" class="btn-close
                    btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <form action="" method="post" class="form-control mt-5 p-4"
            style="height:auto; width:380px; box-shadow: rgba(60, 64, 67, 0.3) 
            0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
            <div class="row">
                <i class="fa fa-user-circle-o fa-3x mt-1 mb-2"
          style="text-align: center; color: green;"></i>
                <h5 class="text-center p-4" 
          style="font-weight: 700;">Login Into Your Account</h5>
            </div>
            <div class="col-mb-3">
                <label for="email"><i 
                  class="fa fa-envelope"></i> Email</label>
                <input type="text" name="email" id="email"
                  class="form-control" required>
            </div>
            <div class="col mb-3 mt-3">
                <label for="password"><i
                  class="fa fa-lock"></i> Password</label>
                <input type="password" name="password" id="password" 
                  class="form-control" required>
            </div>
            <div class="col mb-3 mt-3">
                <button type="submit" 
                  class="btn btn-success bg-success" style="font-weight: 600;">Login</button>
            </div>
            <div class="col mb-2 mt-4">
                <p class="text-center" 
                  style="font-weight: 600; color: navy;"
                  ><a href="./register.php"
                        style="text-decoration: none;">Create Account</a> OR <a href="./resetpassword.php"
                        style="text-decoration: none;">Forgot Password</a></p>
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
