<?php

// Controllo che sia title che content vengano inviati. 
// Se manca anche un solo dato, blocco tutto e lancio un errore
if (empty($_POST["title"]) || empty($_POST["content"])) {
  // Invio come codice HTTP il 400 -> BAD REQUEST solitamente utilizzato 
  // per indicare che l'utente ha inviato i dati sbagliati.
  http_response_code(400);

  exit("Dati non validi");
}

// leggo i dati dal DATABASE
$postsList = file_get_contents("../post.json");
$postsList = json_decode($postsList, true);

// leggo i dati ricevuti in $_POST e li aggiungo alla lista dei post esistenti
$newPost = [
  // usiamo lo spread per aggiungere tutti i dati dell'array.
  // questo non è consigliato visto che non posso escludere chiavi potenzialmente pericolose.
  //...$_POST,
  "title" => $_POST["title"],
  "content" => $_POST["content"],
  "category" => "generic",
  "createdAt" => date('Y-m-d H:i:s'),
  "updatedAt" => "",
  "id" => uniqid()
];

$postsList[] = $newPost;

// ricodifichiamo in json
$jsonString = json_encode($postsList, JSON_PRETTY_PRINT);

// salviamo del database il nuovo array
file_put_contents("../post.json", $jsonString);

header("Content-Type: application/json");

// ritorno l'ultimo elemento dell'array
// echo json_encode($postsList[count($postsList) - 1]);

echo json_encode($newPost);
