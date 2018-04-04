<div id="modif_room" class='h-0vh pt-80px'>

    <div id="creation_container" class="container mw-900">

        <div class='container border rounded p-4 text-center bg-light'>

            <h2>Modifier la salle</h2>

            <hr>
            <br>

            <div class="container">

                <label class="resp-label-572">Nom de la salle</label>
                <div class="input-group mb-3 resp-572-rounded">
                    <div class="input-group-prepend">
                        <span class="input-group-text resp-label-572-hd" id="basic-addon1" style="width: 180px;">Nom de la salle</span>
                    </div>
                    <input type="text" id="name" class="form-control" maxlength="30" placeholder="random things"/>
                </div>

                <label class="resp-label-572">Nom d'Utilisateur</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend resp-572-rounded">
                        <span class="input-group-text resp-label-572-hd" id="basic-addon2" style="width: 180px;">Recherche d'utilisateur</span>
                    </div>
                    <input id="search" type="text" class="form-control" placeholder="Pseudo" onkeyup="search_db(this.value)"/>
                </div>

                <div id="search_result" class="p-2 border text-left mb-1" style="display: none">
                    <div id="search_result_title">Résultats de la recherche<hr></div>
                    <div id="search_element"></div>
                </div>

                <div id="invited_users" class="container p-3 w-100 border text-left">
                    <div id="nobody_added" style="display: block">Vous n'avez ajouté personne dans votre salle.</div>
                </div>

                <a role="button" class="btn btn-secondary mr-3 mt-3" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>">Annuler</a>
                <button type="button" onclick="send_creation()" class="btn btn-primary mt-3">Créer</button>

            </div>

        </div>

    </div>

    <script src="/javascript/search.js"></script>

</div>