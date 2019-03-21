<?php 
    try {
        $connect = mysqli_connect("localhost", "root", "", "test");
    }
    catch(PDOEXCEPTION $e) {
        echo $e->getMessage();
    }
?>