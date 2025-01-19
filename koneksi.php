<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'akademik';

$conn = NEW mysqli($host, $user, $password, $database);
if ($conn-> connect_error){
    die('koneksi gagal:' .$conn-> connect_error);
}
?>