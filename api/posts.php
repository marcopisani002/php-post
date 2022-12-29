<?php
// leggo i dati dal DB
/**
 * @var string
 */
$data = file_get_contents("../post.json");

// informo il browser che gli sto inviando un json
header("Content-Type: application/json");

// stampo la stringa contente il json
echo $data;