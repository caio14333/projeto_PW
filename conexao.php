<?php
$conect = new PDO("mysql:host=localhost;dbname=projeto_pw", "root", "");
$conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
