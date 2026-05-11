<?php
$conect = new PDO("mysql:host=localhost;dbname=crud", "root", "");
$conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
