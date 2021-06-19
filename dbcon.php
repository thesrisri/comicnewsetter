<?php

$server = "localhost";
$user = "id17086042_srikanth";
$password = "8>8DKU4q6KLK)<Ac";
$db = "id17086042_newsletter";

$con = mysqli_connect($server, $user, $password, $db, '3306');
if ($con) {

} else {
?>
    <script>
        alert('connection not successful');
    </script>
<?php
}

?>