<?php

include_once "Database.php";

 $stmt = $conn->query("SELECT * FROM users");

 $users = $stmt->fetchAll();

