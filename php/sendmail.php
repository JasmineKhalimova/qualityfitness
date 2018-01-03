<?php

/* All rights reserved Web-brick design author:Jasmine Khalimova */

$to = "qualityfitnessdublin@gmail.com";
$subject = "New booking from qualityfitness.eu";
$errorMessages = array();
$name = $phone = $emailBody = $fromEmail = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    array_push($errorMessages, "Name is required.");
  }
  else {
    $name = process_form_input($_POST["name"]);
  }

  if (empty($_POST["phone"])) {
    array_push($errorMessages, "Phone number is required.");
  }
  else {
    $phone = process_form_input($_POST["phone"]);
  }

  if (empty($_POST["email"])) {
    array_push($errorMessages, "Email is required.");
  }
  else {
    $isEmailValid = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    if ($isEmailValid) {
        $fromEmail = process_form_input($_POST["email"]);
    }
    else {
        array_push($errorMessages, "Email is invalid.");
    }
  }

  if (empty($_POST["message"])) {
      array_push($errorMessages, "Message is required.");
  }
  else {
      $emailBody = process_form_input($_POST["message"]);
  }

  if (!empty($errorMessages)) {
      // Your message was not sent
      redirect("../index.html");
  }
  else {
    $headers = "From: ".$name." <".$fromEmail.">";
    $emailBody = "Name: ".$name."\nEmail: ".$fromEmail."\nPhone: ".$phone."\n\n".$emailBody;
    if (mail($to, $subject, $emailBody, $headers)) {
      redirect("../index.html");
    }
  }
}
else {
  // "Your message was not sent
  redirect("../index.html");
}

/* Generic form processing:
1. Put form input through htmlspecialchars() to prevent basic code injection attacks.
2. Strip unnecessary characters, e.g. extra spaces.*/
function process_form_input($inputValue) {
  $inputValue = trim($inputValue);
  $inputValue = htmlspecialchars($inputValue);
  return $inputValue;
}

function redirect($url) {
  header('Location: '.$url);
  exit();
}

?>