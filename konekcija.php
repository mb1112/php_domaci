<?php
     $conn = new mysqli('localhost', 'root', '');
    
     if(!$conn) {
         die('Niste se povezali na server!');
     }
 
     if(!mysqli_select_db($conn, 'itehdomaci')) {
         echo 'Nepostojeća baza podataka!';
     }
?>