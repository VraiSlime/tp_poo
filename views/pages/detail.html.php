<div class="card m-2 col-lg-7 mx-auto">
    <div class="row no-gutters">

        <!-- Image en haut -->
        <div class="col-12">
            <?php if ($photo): ?>
                <img src="/<?= $photo->image_path ?>" alt="Photo de <?= $annonce->titre ?>" style="width: 100%; height: auto; display: block;">
            <?php endif; ?>
        </div>

        <!-- Contenu en dessous de l'image -->
        <div class="col-12">
            <div class="card-body" style="background-color: rgba(0, 123, 255, 0.05); border: 1px solid rgba(0, 123, 255, 0.25);">
                <h1 class="card-title"><?= $annonce->titre ?></h1>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Description:</strong> <?= $annonce->description ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Prix par nuit:</strong> <?= $annonce->prix_par_nuit ?> €</p>
                    </div>
                </div> 
                
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Taille:</strong> <?= $annonce->taille ?>m2</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Adresse</strong> <?= $annonce->adresse ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Ville:</strong> <?= $annonce->ville ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Pays:</strong> <?= $annonce->pays ?></p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nombre de pièce:</strong> <?= $annonce->nbr_de_pieces ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Couchage:</strong> <?= $annonce->nbr_de_couchages ?></p>
                    </div>
                </div>

                <!-- Équipements -->
                <h2 class="mt-4">Équipements</h2>
                <div class="row">
                    <div class="col-md-6">
                        <ul>
                            <?php 
                            $half = ceil(count($equipements) / 2);
                            for ($i = 0; $i < $half; $i++): ?>
                                <li><?= $equipements[$i]['label'] ?></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul>
                            <?php 
                            for ($i = $half; $i < count($equipements); $i++): ?>
                                <li><?= $equipements[$i]['label'] ?></li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Champs de sélection de dates -->
<div class="col-lg-7 mx-auto mt-3">
    <?php
    use App\Controller\AuthController;
    if (AuthController::isAuth() && !AuthController::isHote()) {
        ?>
        <h2 class="text-center">Réserver cette location</h2>
        <form action="/reservations/create" method="post" class="p-4 rounded shadow" style="background-color: rgba(0, 123, 255, 0.05); border: 1px solid rgba(0, 123, 255, 0.25);">

            <div class="form-group row">
                <label for="date_debut" class="col-sm-4 col-form-label text-right">Date de début :</label>
                <div class="col-sm-8">
                    <input type="date" id="date_debut" name="date_debut" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="date_fin" class="col-sm-4 col-form-label text-right">Date de fin :</label>
                <div class="col-sm-8">
                    <input type="date" id="date_fin" name="date_fin" class="form-control" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="nbr_de_personne" class="col-sm-4 col-form-label text-right">Nombre de personnes :</label>
                <div class="col-sm-8">
                    <input type="number" id="nbr_de_personne" name="nbr_de_personne" class="form-control" required min="1">
                </div>
            </div>

            <input type="hidden" name="annonce_id" value="<?= $annonce->id ?>">
            <div class="text-center">
                <button type="submit" class="btn btn-info mt-2">Réserver</button>
            </div>
        </form>
    <?php } ?>
</div>

