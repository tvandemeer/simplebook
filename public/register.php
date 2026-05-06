<?php
if(!isset($_SESSION)){
    session_start();
}
include('config.php');
include('variableAndFunctions.php');

$message = "";
$toastClass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmailStmt = $dbconnect->prepare("SELECT email FROM userdata WHERE email=:email");
    $checkEmailStmt->execute(['email' => $email]);
    $checkUsernameStmt = $dbconnect->prepare("SELECT username FROM userdata WHERE username=:username");
    $checkUsernameStmt->execute(['username' => $username]);

    if ($checkEmailStmt->rowCount() > 0) {
        $message = "Email ID already exists";
        $toastClass = "warning";
    } elseif ($checkUsernameStmt->rowCount() > 0) {
        $message = "Username ID already exists";
        $toastClass = "warning";
    } else {
        // Prepare and bind
        $data = array($username, $email, $hashedPassword);
        $stmt = $dbconnect->prepare("INSERT INTO userdata (username, email, password) VALUES (?, ?, ?)");

        if ($stmt->execute($data)) {
            $message = "Account created successfully";
            $toastClass = "success";
        } else {
            $message = "Error: " . $stmt->error;
            $toastClass = "error";
        }

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
    <title>Registration</title>
</head>

<body>
	<div class="navbar shadow-sm">
    <div class="navbar-start">
      <a class="btn btn-ghost text-xl" href="index.php">╚(•⌂•)╝</a>
    </div>
    <div class="navbar-end">
      <a class="btn btn-active text-xl">Register</a>
      <a class="btn btn-ghost text-xl" href="login.php">Login</a>
      <?php
      if(array_key_exists('email', $_SESSION)) {
        echo '<a class="btn btn-warning text-xl" href="logout.php">Logout</a>';
      }
      ?>
    </div>
	</div>
	
    <div class="xs:w-auto sm:w-2/3 md:w-1/2 lg:w-5/12 xl:w-1/3 2xl:w-1/4 mx-auto">
			<h1 class="text-4xl text-center my-8">Registration</h1>
			
        <?php if ($message): ?>
   
            <div class="toast">
							<div class="alert alert-<?php echo $toastClass; ?>">
								<span><?php echo $message; ?></span>
							</div>
						</div>
						
        <?php endif; ?>
        
        <form method="post">
            <div class="text-center">
                <i class="fa fa-user-circle-o fa-3x mt-1 mb-2"></i>
                <h5 class="p-4">Create Your Account</h5>
            </div>
            <fieldset class="fieldset">
                <legend class="fieldset-legend"><i class="fa fa-user"></i> User Name</legend>
                <input type="text" name="username" id="username" class="input w-full" required>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend"><i class="fa fa-envelope"></i> Email</legend>
                <input type="text" name="email" id="email" class="input w-full" required>
            </fieldset>
            <fieldset class="fieldset">
                <legend class="fieldset-legend"><i class="fa fa-lock"></i> Password</legend>
                <input type="password" name="password" id="password" class="input w-full" required>
            </fieldset>
            <div class="mb-2 mt-3">
                <button type="submit" 
                  class="btn btn-primary">Create
                    Account</button>
            </div>
            <div class="mb-2 mt-4">
                <p class="text-center">I have an Account <a href="./login.php"
                        style="text-decoration: none;">Login</a></p>
            </div>
        </form>
    </div>

    <script>
        let toastElList = [].slice.call(document.querySelectorAll('.toast'))
        let toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl, { delay: 3000 });
        });
        toastList.forEach(toast => toast.show());
    </script>
</body>

</html>
