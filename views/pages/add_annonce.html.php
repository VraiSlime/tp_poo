<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="/annonces/store" method="post" enctype="multipart/form-data">
                <!-- Titre -->
                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Description"></textarea>
                </div>

                <!-- Pays, Ville, Adresse -->
                <div class="form-group">
                    <label for="pays">Pays</label>
                    <input type="text" class="form-control" id="pays" name="pays" placeholder="Pays">
                </div>
                <div class="form-group">
                    <label for="ville">Ville</label>
                    <input type="text" class="form-control" id="ville" name="ville" placeholder="Ville">
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse</label>
                    <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse">
                </div>

                <!-- Taille, Nombre de pièces, Prix par nuit, Nombre de couchages -->
                <div class="form-group">
                    <label for="taille">Taille (en m²)</label>
                    <input type="number" class="form-control" id="taille" name="taille" placeholder="Taille (en m²)">
                </div>
                <div class="form-group">
                    <label for="nbr_de_pieces">Nombre de pièces</label>
                    <input type="number" class="form-control" id="nbr_de_pieces" name="nbr_de_pieces" placeholder="Nombre de pièces">
                </div>
                <div class="form-group">
                    <label for="prix_par_nuit">Prix par nuit (en €)</label>
                    <input type="number" class="form-control" id="prix_par_nuit" name="prix_par_nuit" placeholder="Prix par nuit (en €)">
                </div>
                <div class="form-group">
                    <label for="nbr_de_couchages">Nombre de couchages</label>
                    <input type="number" class="form-control" id="nbr_de_couchages" name="nbr_de_couchages" placeholder="Nombre de couchages">
                </div>

          <!-- Upload de photos -->
          <div class="form-group">
                    <label for="photo">Upload de photos</label>
                    <div class="custom-file">
                 
                        <input type="file" class="custom-file-input btn btn-outline-info" id="photo" name="photo" accept="image/webp">
                    
                    </div>
                </div>

                <!-- Select de type de logement -->
                <div class="form-group">
                    <label for="type_de_logement_id">Type de logement</label>
                    <select class="form-control" id="type_de_logement_id" name="type_de_logement_id">
                        <?php foreach ($typesDeLogements as $type): ?>
                            <option value="<?= $type['id'] ?>"><?= $type['label'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Equipements -->
                <div class="form-group">
                    <label for="equipements">Equipements  :</label>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <?php
                                    $equipementCount = count($equipements);
                                    $halfCount = ceil($equipementCount / 2);

                                    for ($i = 0; $i < $halfCount; $i++) {
                                        $equipement = $equipements[$i];
                                        echo '<div class="form-check">';
                                        echo '<input class="form-check-input" type="checkbox" id="equipement_' . $equipement['id'] . '" name="equipements[]" value="' . $equipement['id'] . '">';
                                        echo '<label class="form-check-label" for="equipement_' . $equipement['id'] . '">' . $equipement['label'] . '</label>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                                <div class="col">
                                    <?php
                                    for ($i = $halfCount; $i < $equipementCount; $i++) {
                                        $equipement = $equipements[$i];
                                        echo '<div class="form-check">';
                                        echo '<input class="form-check-input" type="checkbox" id="equipement_' . $equipement['id'] . '" name="equipements[]" value="' . $equipement['id'] . '">';
                                        echo '<label class="form-check-label" for="equipement_' . $equipement['id'] . '">' . $equipement['label'] . '</label>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit" class="btn btn-outline-info mt-2">Ajouter</button>
       
            </form>
        </div>
    </div>
</div>
