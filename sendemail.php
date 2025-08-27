<?php
require_once 'connection.php';
if (
    isset($_POST['name']) && !empty($_POST['name'])
    && isset($_POST['toemail']) && !empty($_POST['toemail'])
    && isset($_POST['message']) && !empty($_POST['message'])
    && isset($_POST['fromemail']) && !empty($_POST['fromemail'])


) {
    $from = $_POST['fromemail'];
    $name = $_POST['name'];
    $email = $_POST['toemail'];
    $message = $_POST['message'];

    $fr = $from;
    $to = $email;
    $subject = "Contact Form Submission";
    $body = " From: $fr\n First Name: $name\nEmail: $email\nMessage: $message";

    mail($fr, $to, $subject, $body);
    echo "Email sent successfully!";
    header("location:client.php");
}

?>