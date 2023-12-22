<?php
    $conn = new mysqli ('localhost', 'root', '', 'cadastro');
    if ($conn->connect_errno){
        echo "<p>Ops! :) Encontrei um erro $conn->errno--$conn->connect_error</p>";
        die();
    }

    $conn->query("SET NAMES 'UTF8'");
    $conn->query("SET character_set_connection=utf8");
    $conn->query("SET character_set_client=utf8");
    $conn->query("SET character_set_results=utf8");