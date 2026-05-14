<?php
$conect = new PDO("mysql:host=localhost;dbname=projeto_PW", "root", "");
$conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
