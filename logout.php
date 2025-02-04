<?php
require_once 'includes/auth.php';

$auth = Auth::getInstance();
$auth->signOut();

header('Location: /');
exit;
?>