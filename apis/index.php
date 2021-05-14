<?php
header("Content-Type: JSON");
echo json_encode(json_decode(file_get_contents("wallpaper.json")), JSON_PRETTY_PRINT);