<?php

if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else{
    $protocol = 'http';
}

$request = $_SERVER['REQUEST_URI'];
$request = explode("/", $request);
$request_uri = $request[1];
$nome = $_POST["nome"];
$descricao = $_POST["descricao"];
$tags = $_POST["tags"];
//$upload_dir = wp_upload_dir();
$test = $_FILES;
$upload_dir = $protocol . '://'. $_SERVER['SERVER_NAME'] . '/' .$request_uri .'wp-content/uploads/images';

$target_file = $upload_dir . '/' . basename($_FILES["imageUpload"]["name"]);
move_uploaded_file($FILE["imageUpload"]["tmp_name"], $tar);
