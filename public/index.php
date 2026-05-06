<?php
if(!isset($_SESSION)){
    session_start();
} 

if(!array_key_exists('email', $_SESSION)) {
  header('Location: login.php');
}

include('config.php');
include('variableAndFunctions.php');
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="icon" type="image/x-icon" href="favicon.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href=
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link href="output.css" rel="stylesheet">
</head>
<body>
	<div class="navbar shadow-sm">
    <div class="navbar-start">
      <a class="btn btn-active text-xl">╚(•⌂•)╝</a>
    </div>
    <div class="navbar-end">
      <a class="btn btn-ghost text-xl" href="register.php">Register</a>
      <a class="btn btn-ghost text-xl" href="login.php">Login</a>
      <?php
      if(array_key_exists('email', $_SESSION)) {
        echo '<a class="btn btn-warning text-xl" href="logout.php">Logout</a>';
      }
      ?>
    </div>
	</div>

  <div class="xs:w-auto sm:w-2/3 md:w-1/2 lg:w-5/12 xl:w-1/3 2xl:w-1/4 mx-auto">
		<h1 class="text-4xl text-center my-8"><?= $title ?></h1>
    <form action="message.php" method="post" class="mb-8">
      <fieldset class="fieldset">
        <legend class="fieldset-legend">Name</legend>
        <input type="text" name="name" maxlength="60" placeholder="Your name" class="input w-full" />
      </fieldset>
      <fieldset class="fieldset">
        <legend class="fieldset-legend">Message</legend>
        <textarea class="textarea w-full" name="message" rows="3" maxlength="600" placeholder="Your message"></textarea>
      </fieldset>
      <fieldset class="fieldset mb-8">
        <legend class="fieldset-legend">Verification</legend>
        <div class="grid grid-cols-2">
          <div class="text-base"><?= $randNum1 ?> + <?= $randNum2 ?> is equal to:</div>
          <div><input type="text" class="input" name="verification" id="verification" maxlength="3" placeholder="Your Answer"></div>
        </div>
      </fieldset>

        <button type="submit" class="btn btn-primary">Send</button>
        <input type="hidden" name="action" value="sendmessage">
        
    </form>
    
    <?php
    if(isset($_SESSION['msg'])) {
			echo '<div role="alert" class="alert alert-info mb-4">';
			echo '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">';
			echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>';
			echo '</svg><p>' . $_SESSION['msg'] . '</p></div>';
			unset ($_SESSION['msg']);
		}

    $stmt = $dbconnect->query("SELECT * FROM entries ORDER BY id DESC");
			while ($row = $stmt->fetch()) {
				echo '<div class="entry"><div class="flex justify-between bg-amber-600 text-slate-800 p-2 rounded-t-lg">';
				echo '<div class="font-bold">' . $row['name'] . '</div>';
				echo '<div class="font-light text-xs">' . $row['date'] . '&nbsp;(UTC)</div>';
				echo '</div>';
				echo '<div class="bg-amber-100 text-slate-800 mb-4 p-2 rounded-b-lg text-lg">' . $row['message'] . '</div></div>';
		}
		?>
    
  </div>

</body>
</html>
