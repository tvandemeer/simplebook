<?php
if(!isset($_SESSION)){
    session_start();
}
include('config.php');
include('variableAndFunctions.php');

if (isset($_POST['action']) and $_POST['action'] == 'sendmessage') {
    $name = $_POST['name'];
    $message = $_POST['message'];
    $verification = ($_POST['verification']);
    $timedate = date("Y-m-d H:i:s");

    if (empty($name)) {
        $_SESSION['msg'] = "Input fields cannot be empty!";
        redirect('/index.php');
    } elseif (empty($message)) {
        $_SESSION['msg'] = "Input fields cannot be empty!";
        redirect('/index.php');
    } elseif (empty($verification)) {
        $_SESSION['msg'] = "Input fields cannot be empty!";
        redirect('/index.php');
    } else {
        if ($previousSumRandNum == $verification) {
            $messageQuery = "INSERT INTO entries (name, message, date) VALUES (?,?,?)";
            $stmt = $dbconnect->prepare($messageQuery);
            $sendMessage = $stmt->execute([$name,$message,$timedate]);
            
            if ($sendMessage) {
                $_SESSION['msg'] = "Message Added!";
                unset($_SESSION['sumRandNum']);
                redirect('/index.php');
            } else {
                $_SESSION['msg'] = "Failed adding your message!";
                unset($_SESSION['sumRandNum']);
                redirect('/index.php');
                exit;
            }
        } else {
            $_SESSION['msg'] = "Verification failed!";
            unset($_SESSION['sumRandNum']);
            redirect('/index.php');
            exit;
        }
    }
} else {
    unset($_SESSION['sumRandNum']);
    redirect('/index.php');
}
