<?php
    session_start()
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <title>Document</title>
</head>
<body>
    <?php
        include 'dbcon.php';

        if(isset($_GET['token'])){
            $token = $_GET['token'];
            $uquery = "update signup set active='true' where token='$token'";
            $setactive = mysqli_query($con,$uquery);
            if($setactive){
                if(isset($_SESSION['msg'])){
                    $_SESSION['msg'] = "Email Verification Successful 🎉,";
                }
               
            } else{
                $_SESSION['msg'] = "Email Verification not successful";
                header('location: index.php');  
            }
        }
        
    ?>
    <div>
        <div class="card">
            <h1 id="heading" ><?php echo $_SESSION['msg'] ?></h1>
            <h3>You are now subscribed to Comic newsletter</h3>
            
        </div>
    </div>
    
</body>
</html>