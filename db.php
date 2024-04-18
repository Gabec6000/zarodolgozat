<?php

$pdo = new PDO("mysql:host=localhost;dbname=gabor", 'root', '');
$pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
