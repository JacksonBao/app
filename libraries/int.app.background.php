<?php 

$response = ['success' => true, 'message' => 'Background transaction initiated successfully.', 'list' => ''];

ob_end_clean();
header("Connection: close");
ignore_user_abort(true); // just to be safe
ob_start();
echo json_encode($response);
$size = ob_get_length();
header("Content-Length: $size");
ob_end_flush(); // Strange behaviour, will not work
flush(); // Unless both are called !
// // Do processing here 
ini_set('max_execution_time', 0);
session_write_close();
