<?php
// Your php code here
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Php Posts | Index</title>

    <!-- Third party libraries -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Custom css -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div id="app">
        <main class="container pb-5">
            <h1 class="my-5 text-white">Php Posts | Index</h1>

            <p class="lead text-white">
                <em>Una pagina che mostra una lista di post salvati in un pseudo-database.
                    Su questa pagina, tramite VUE, stamperemo questa lista.
                    Tramite un pulsante potremmo aggiungere un altro post.
                    Per ogni post lo potremo modificare o cancellare.</em>
            </p>

            <div class="d-flex justify-content-center py-4">
                <button class="btn btn-primary" @click="showForm = true">
                    <i class="fas fa-plus"></i>
                    Nuovo post
                </button>
            </div>

            <!-- Lista dei post esistenti a DB -->
            <ul class="list-group mb-5">
                <li class="list-group-item d-flex" v-for="post in postsList">
                    <div class="flex-fill">
                        <h5>{{post.title}}</h5>
                        <p>{{post.content}}</p>
                        <div>
                            id: {{post.id}} -
                            data: {{ post.createdAt }}
                        </div>
                    </div>

                    <!-- pulsanti delle azioni -->
                    <div class="d-flex gap-2 align-items-start">
                        <button class="btn btn-danger" @click="deletePost(post.id)"><i class="fas fa-trash"></i></button>
                        <button class="btn btn-info" @click="editPost(post)"><i class="fas fa-pencil"></i></button>
                    </div>
                </li>
            </ul>

            <!-- Form Creazione -->
            <div class="card" v-if="showForm">
                <div class="card-body">

                    <!-- Siccome i dati del form verranno inviati tramite VUE,
                non serve indicare nel form, l'action ed il method -->
                    <form @submit.prevent="onFormSubmit">
                        <div class="mb-3">
                            <label class="form-label">Titolo</label>
                            <input type="text" class="form-control" placeholder="aggiungi titolo" v-model="newPostData.title">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contenuto</label>
                            <textarea class="form-control" placeholder="aggiungi contenuto" v-model="newPostData.content"></textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-danger" @click="resetForm">Annulla</button>
                            <button class="btn btn-success">Crea</button>
                        </div>
                    </form>

                </div>
            </div>

        </main>
    </div>



    <script src="js/main.js"></script>
</body>

</html>