<?php

  // $name    = (isset($_POST['name'])) ? $_POST['name'] : '';
  // $email   = (isset($_POST['email'])) ? $_POST['email'] : '';
  // $tel   = (isset($_POST['tel'])) ? $_POST['tel'] : '';
  // $message = (isset($_POST['message'])) ? $_POST['message'] : '';
  // $subject = (isset($_POST['subject'])) ? $_POST['subject'] : '';

  $_POST = json_decode(file_get_contents("php://input"), true);

  $method = $_SERVER['REQUEST_METHOD'];
  $c = true;

  $project_name = trim($_POST["project_name"]);
  $admin_email  = trim($_POST["admin_email"]);
  $form_subject = trim($_POST["form_subject"]);

  // header('Content-Type: application/json');
  // if ($name === '') {
  //   $response =  json_encode(array(
  //     'message' => 'Поле имени не может быть пустым',
  //     'code' => 0
  //   ));
  //   die($response);
  // }
  // if ($tel === '') {
  //   $response =  json_encode(array(
  //     'message' => 'Поле телефона не может быть пустым',
  //     'code' => 0
  //   ));
  //   die($response);
  // }
  // if ($email === '') {
  //   $response =  json_encode(array(
  //     'message' => 'Поле email не может быть пустым',
  //     'code' => 0
  //   ));
  //   die($response);  
  // } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  //   $response =  json_encode(array(
  //     'message' => 'Проверьте правильность ввода email',
  //     'code' => 0
  //   ));
  //   die($response);
  // }
  // if ($subject === '') {
  //   $response =  json_encode(array(
  //     'message' => 'Поле не может быть пустым',
  //     'code' => 0
  //   ));
  //   die($response);
  // }
  // if ($message === '') {
  //   $response =  json_encode(array(
  //     'message' => 'Напишите чем мы можем вам помочь',
  //     'code' => 0
  //   ));
  //   die($response);
  // }

  foreach ( $_POST as $key => $value ) {
    if ( is_array($value) ) {
      $value = implode(", ", $value);
    }
    if ( $value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject" ) {
      $message .= "
      " . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
        <td style='padding: 10px; border: #e2dddd 1px solid;'><b>$key</b></td>
        <td style='padding: 10px; border: #e2dddd 1px solid;'>$value</td>
      </tr>
      ";
    }
  }

  $message = "<table style='width: 100%;'>$message</table>";

  function adopt($text) {
      return '=?UTF-8?B?'.Base64_encode($text).'?=';
  }

  $headers = "MIME-Version: 1.0" . PHP_EOL .
  "Content-Type: text/html; charset=utf-8" . PHP_EOL .
  'From: '.adopt($project_name).' <'.$admin_email.'>' . PHP_EOL .
  'Reply-To: '.$admin_email.'' . PHP_EOL;

  if (mail($admin_email, adopt($form_subject), $message, $headers )) {
      http_response_code(200);
      echo "Данные отправлены.";
  } else {
      http_response_code(400);
      echo "Ошибка. Данные не отправлены.";
  };


  // $content    = "Получен новый запрос на обратный звонок с сайта $url \n Имя: $name \n Email: $email \n Телефон: $email \n Сообщение: $message";
  // $recipient  = "dotikdeveloper@gmail.com";

  // $mailheader = array(
  //   'From' => $email,
  //   'Content-Type' => 'text/html;charset=UTF-8',
  // );
  // mail($recipient, $subject, $content, $mailheader) or die("Error!");
  // $response =  json_encode(array(
  //   'message' => 'Мы получили ваш запрос и в ближайшее время с вами свяжемся',
  //   'code' => 1
  // ));
  // die($response);
?>