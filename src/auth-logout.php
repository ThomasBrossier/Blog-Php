<?php
$pdo = require_once "database/database.php";
$AuthDB = require_once 'database/AuthDB.php';
$AuthDB->logout();
header('Location: /src/auth-login.php');
