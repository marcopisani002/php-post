const { createApp } = Vue;

const app = createApp({
    data() {
        return {
            postsList: [],
            newPostData: {
                title: "",
                content: "",
            },
            showForm: false,
        };
    },
    methods: {
        //esegue una chiamata API in GET x recuperare la lista dei post  e salvarli
        //nella variabile locale postsList (riga 6)

        fetchData() {
            axios.get("api/posts.php").then((resp) => {
                this.postsList = resp.data;
            });
        },

        //al reset svuotiamo i campi del form e impostiamo a FALSE
        // la variabile showForm in modo che nil form venga nascosto

        resetForm() {
            this.newPostData.title = "";
            this.newPostData.content = "";
            this.showForm = false;
        },
        resetEditForm() {
            this.showEditForm = false;
            this.editPostData = null;
        },
        //prende i dati dal form ,
        // invia essi all'API tramite POST
        // se tutto è andato a buon fine, nasconde il form 
        // aggiorna la lista dei post visibili invocanndo il this.fetchData


        onFormSubmit() {
            axios.post("api/createPosts.php", this.newPostData, {
                headers: { "Content-Type": "multipart/form-data" },
            })
                .then((resp) => {
                    // se finiamo nel then, significa che tutto è andato a buon fine.

                    // riscarico i dati
                    this.fetchData();

                    // resetto il form e lo nascondo
                    this.resetForm();
                })
                .catch((er) => {
                    // er.response.status = codice inviato dal server 400 o 404 o altro
                    console.log(er);
                });
        },

        /**
       * Partendo dall' id di un post, tramite una chiamata API, lo cancella
             * @param {string} postId
         */
        deletePost(postId) {
            axios.post("api/deletePost.php",
                { postId },
                {
                    headers: { "Content-Type": "multipart/form-data" },
                }
            )
                .then((resp) => {
                    // riscarico i dati
                    this.fetchData();
                });
        },

        editPost(post) {
            this.showEditForm = true;
            // Usiamo lo spread operator per evitare che editPostData 
            // rimanga collegato al post e quindi venga modificato dal form tramite v-mode
            this.editPostData = { ...post };
        },

        onEditFormSubmit() {
            axios
                .post("api/editPost.php", this.editPostData, {
                    headers: { "Content-Type": "multipart/form-data" },
                })
                .then((resp) => {
                    // se finiamo nel then, significa che tutto è andato a buon fine.

                    // riscarico i dati
                    this.fetchData();

                    // resetto il form e lo nascondo
                    this.resetEditForm();
                })
                .catch((er) => {
                    // er.response.status = codice inviato dal server 400 o 404 o altro
                    console.log(er);
                });
        },
    },
    mounted() {
        this.fetchData();
    },
}).mount("#app");