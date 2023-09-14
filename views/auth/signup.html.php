<div class="d-flex justify-content-center align-items-center"> 
    <div class="card"> 
        <div class="card-body">
            <h5 class="card-title text-center">Inscription</h5>
            
            <form action="/inscription" method="post" class="d-flex flex-column align-items-center">
                <div class="form-group custom-form-control">
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" placeholder="Nom" class="form-control" required>
                </div>

                <div class="form-group custom-form-control">
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom" placeholder="Prénom" class="form-control" required>
                </div>

                <div class="form-group custom-form-control">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" placeholder="Email" class="form-control" required>
                </div>

                <div class="form-group custom-form-control">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" placeholder="Mot de passe" class="form-control" required>
                </div>

                <div class="form-check custom-form-control">
                    <input type="checkbox" name="is_hote" value="1" id="is_hote" class="form-check-input">
                    <label class="form-check-label" for="is_hote">Compte Hôte ?</label>
                </div>

                <button type="submit" class="btn btn-primary mt-2">S'inscrire</button>
            </form>
        </div>
    </div>
</div>