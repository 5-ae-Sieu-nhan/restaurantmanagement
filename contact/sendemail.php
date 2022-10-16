<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';

$mail = new PHPMailer(true);

$alert = '';

if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $talkabout= $_POST['talkabout'];
  $message = $_POST['message'];

  $conn = mysqli_connect("localhost", "root", "", "database_form") or die("connection failed");
$sql = "INSERT INTO database_table(Name, Email, Talkabout, Message) VALUES ('{$name}','{$email}','{$talkabout}','{$message}' )";
$result = mysqli_query($conn, $sql) or die("Query Failed!");
header("location: http://localhost/contact/");
mysqli_close($conn);
  try{
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'anhndhth2110002@fpt.edu.vn'; 
    $mail->Password = 'hoanganh1201'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = '587';

    $mail->setFrom('anhndhth2110002@fpt.edu.vn'); 
    $mail->addAddress('anhndhth2110002@fpt.edu.vn'); 

    $mail->isHTML(true);
    $mail->Subject = 'Message Received (Contact Page)';
    $mail->Body = "<h3>Name : $name <br>Email: $email <br>TalkAbout: $talkabout <br>Message : $message</h3>";

    $mail->send();
    $alert = '<div class="alert-success">
                 <span>Message Sent! Thank you for contacting us.</span>
                </div>';
  } catch (Exception $e){
    $alert = '<div class="alert-error">
                <span>'.$e->getMessage().'</span>
              </div>';
  }
}
?>
