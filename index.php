<?php
session_start()
?>
<?php require 'PHPMailer/PHPMailerAutoload.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <title>Sign up</title>
</head>

<body>

    <?php
    include 'dbcon.php';

    function Redirect_to($New_Location)
    {
        header("Location:" . $New_Location);
        exit;
    }
    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $token = bin2hex(random_bytes(15));
        $date = date("Y-m-d");
        $emailquery = "select * from signup where email='$email' And active='true'";
        $query = mysqli_query($con, $emailquery);

        $emailcount = mysqli_num_rows($query);
        if (!($emailcount > 0)) {

            $insertquery = "insert into signup (name,email,subscription,token,active, date)values('$name','$email','true','$token','false', '$date')";
            $insert = mysqli_query($con, $insertquery);



            if ($insert) {
                $name = $_POST["name"];
                $email = $_POST["email"];

                // Email Functionality

                date_default_timezone_set('Etc/UTC');

                $mail = new PHPMailer();
                $mail->SMTPDebug  = 3;
                $mail->IsSMTP(); 
                $mail->SMTPAuth = true; 
                $mail->SMTPSecure = 'tls'; 
                $mail->Host = "smtp.gmail.com";
                $mail->Port = 587; 
                $mail->IsHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Username = "sridharamsrikanth@gmail.com";
                $mail->Password = "$@!sri2810";
                $mail->setFrom('sridharamsrikanth@gmail.com');
                $mail->addAddress($_POST['email']);

                // The subject of the message.
                $mail->Subject = 'Received Message From Comic newsletter';

                $message = '<html><body>';
                $message .= "Hi, $name. <br> <br> Click here to verify your email https://localhost/php/signup/emailverify.php?token=$token  <br>";
                $message .= "</body></html>";

                $mail->Body = $message;

                $mail->isHTML(true);

                if ($mail->send()) {
                    $_SESSION['msg'] =  "verification email sent to $email 📩";
                    Redirect_to("login.php");
                } else {
                    Redirect_to("index.php");
                }
            } else {
    ?>
                <script>
                    alert('connection not successful');
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                alert("email already exist");
            </script>
    <?php

        }
    }
    ?>
    <div>
        <div class="card">
            <h1 id="heading"> Subscribe to comic newsletter</h1>

            <form class="formStyle" <?php echo htmlentities($_SERVER['PHP_SELF']); ?>action="" method="POST">
                <input name="name" placeholder="Enter your name" type="text" required> <br>
                <br>
                <input name="email" placeholder="Enter your email" type="email" required> <br>
                <button type="submit" name="submit">Subscribe</button>
            </form>
        </div>
    </div>
</body>

</html>


<?php

// $to_email = $email;
// $subject = "Simple Email test via PHP";
// $body = "Hi, $name. <br> Click here to verify your email https://localhost/php/signup/emailverify.php?token=$token  <br>
//     ";
// $headers = "From: srikanthkumarrr@gmail.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

// if(mail($to_email, $subject, $body, $headers)){
//     $_SESSION['msg'] =  "verification email sent to $email 📩";
//     header('location: login.php');
// }

?>