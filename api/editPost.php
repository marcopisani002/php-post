<?php
// Controllo che sia title che content vengano inviati. 
// Se manca anche un solo dato, blocco tutto e lancio un errore
if (empty($_POST["title"]) || empty($_POST["content"]) || empty($_POST["id"])) {
  // Invio come codice HTTP il 400 -> BAD REQUEST solitamente utilizzato 
  // per indicare che l'utente ha inviato i dati sbagliati.
  http_response_code(400);

  exit("Dati non validi");
}

// leggo i dati dal DATABASE
$postsList = file_get_contents("../post.json");
$postsList = json_decode($postsList, true);

// devo recuperare l'indice dell'elemento 
// che ha come id quello ricevuto tramite $_POST["postId"]
$indice;

foreach ($postsList as $i => $post) {
  // per ogni elemento della lista, controllo se il suo id
  // corrisponde a quello del post.
  // Se si, mi salvo l'indice corrente.  
  if ($post["id"] === $_POST["id"]) {
    $indice = $i;
  }
}

$postsList[$indice]["title"] = $_POST["title"];
$postsList[$indice]["content"] = $_POST["content"];
$postsList[$indice]["updatedAt"] = date('Y-m-d H:i:s');

// riconverto l'array in json
$jsonString = json_encode($postsList, JSON_PRETTY_PRINT);

// salvo il json nel database / file
file_put_contents("../post.json", $jsonString);

header("Content-Type: application/json");

echo json_encode($postsList[$indice]);