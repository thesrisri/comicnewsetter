<?php require 'PHPMailer/PHPMailerAutoload.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <title>Send Email with comic</title>
</head>

<body>
    <?php
    function Redirect_to($New_Location)
    {
        header("Location:" . $New_Location);
        exit;
    }
    include 'dbcon.php';
    $emailquery = "select * from signup where  active='true'";
    $query = mysqli_query($con, $emailquery);

    $emailcount = mysqli_num_rows($query);
    if (!($emailcount < 0)) {

        $num = rand(0, 100);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://xkcd.com/$num/info.0.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);

        while ($row = $query->fetch_assoc()) {
            $email =  $row['email'];
            $name =  $row['name'];
            $token = $row['token'];
            $fname = "$response->img";
            if ($response) {

                // Email Functionality

                date_default_timezone_set('Etc/UTC');

                $mail = new PHPMailer();
                

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
                $mail->addAddress($email);

                // The subject of the message.
                $mail->Subject = 'Comic Email newsletter';

                $message = '<html><body>';
                $message .=  "Hi, $name. <br>
                <img src='$response->img'> 

                <br><br>
                Click here to <a href='https://localhost/php/signup/unsubscribe.php?token=$token'>unsubscribe  </a>
                ";
                $message .= "</body></html>";

                $mail->Body = $message;

                $mail->isHTML(true);
                if ($mail->send()) {
                    $_SESSION['msg'] = "Newsletter sent Successfully 🎉,";
                    Redirect_to("login.php");
                } else {
                    Redirect_to("index.php");
                }


            }
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
// $subject = "Comic Email newsletter";

// $body = "Hi, $name. <br>
//         <img src='$response->img'> 

//         <br><br>
//         Click here to <a href='https://localhost/php/signup/unsubscribe.php?token=$token'>unsubscribe  </a>
//         ";
// $body.="Content-Type: {\"application/octet-stream\"};\n" . " name=\"".$fname."\"\n" . 
// "Content-Disposition: attachment;\n" . " filename=\"$fname\"\n" . 
// "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
// $headers = "From: srikanthkumarrr@gmail.com\nMIME-Version: 1.0\nContent-Type: text/html; charset=utf-8\n";

// if (!(mail($to_email, $subject, $body, $headers))) {
//     $_SESSION['msg'] =  "email not sent to $email 📩";
//     header('location: login.php');
// }?>