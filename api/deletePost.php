<?php

// Controllo che sia stato provveduto un postId
// Se manca, blocco tutto e lancio un errore
if (empty($_POST["postId"])) {
  // Invio come codice HTTP il 400 -> BAD REQUEST solitamente utilizzato 
  // per indicare che l'utente ha inviato i dati sbagliati.
  http_response_code(400);

  exit("Id del post da cancellare mancante");
}

// leggo i dati dal DATABASE
$postsList = file_get_contents("../post.json");
$postsList = json_decode($postsList, true);

// devo recuperare l'indice dell'elemento 
// che ha come id quello ricevuto tramite $_POST["postId"]
$indice;

foreach($postsList as $i => $post){
  // per ogni elemento della lista, controllo se il suo id
  // corrisponde a quello del post.
  // Se si, mi salvo l'indice corrente.  
  if($post["id"] === $_POST["postId"]){
    $indice = $i;
  }
}

// sapendo l'indice, ora posso cancellare l'elemento
array_splice($postsList, $indice, 1);

// riconverto l'array in json
$jsonString = json_encode($postsList, JSON_PRETTY_PRINT);

// salvo il json nel database / file
file_put_contents("../post.json", $jsonString);