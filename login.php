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
    <title>Sign up</title>
</head>

<body>

   
    <div>
        <div class="card">
            <h1 id="heading" > <?php echo $_SESSION['msg'] ?></h1>
            
        </div>
    </div>
</body>

</html>