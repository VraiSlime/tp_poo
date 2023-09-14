<?php use App\Controller\AuthController; ?>

<h1 class="p-5"><?= $list_title ?></h1>
<!-- Filtre par type de logement -->
<form action="" method="post" class="mb-4 text-center d-flex justify-content-center align-items-center">
    <div class="mb-3 d-inline-block mr-15" style="margin-right: 20px;">
        <label for="type_de_logement_id" class="form-label d-block">Filtrer par type de logement:</label>
        <select name="type_de_logement_id" class="form-select w-100 d-block mx-auto">
            <option value="">-- Sélectionner --</option>
            <option value="0">Toutes les annonces</option>
            <option value="1">Appartement</option>
            <option value="2">Maison</option>
            <option value="3">Studio</option>
            <option value="4">Chambre</option>
            <option value="5">Maison de campagne</option>
            <option value="6">Riadh</option>
            <option value="7">Camping</option>
            <option value="8">Villa</option>
            <option value="9">Cottage</option>
            <option value="10">Cabane</option>
            <option value="11">Bungalow</option>
            <option value="12">Loft</option>
            <option value="13">Péniche</option>
            <option value="14">Chalet</option>
            <option value="15">Manoir</option>
            <option value="16">Château</option>
            <option value="17">Ferme</option>
            <option value="18">Igloo</option>
            <option value="19">Dortoir</option>
        </select>
    </div>
    <input type="submit" value="Filtrer" class="btn btn-info mt-3">
</form>


<?php
if (empty($annonces)) : ?>
    <p>Aucunne annonce en ce moment</p>
<?php else : ?>
    <div class="d-flex flex-row flex-wrap justify-content-center">
        <?php
      foreach ($annonces as $annonce) : ?>
        <div class="card m-2" style="width: 18rem; background-color: rgba(0, 123, 255, 0.05); border: 1px solid rgba(0, 123, 255, 0.25);">
            <?php if ($annonce->photo): ?>
                <img src="<?= $annonce->photo->image_path ?>" class="card-img-top" alt="Photo de <?= $annonce->titre ?>">
            <?php endif; ?>
            <div class="card-body">
                <h3 class="card-title"><?= $annonce->titre ?></h3>
                <p class="card-text"><?= $annonce-> ville ?> </p>
                <p class="card-text"><?= $annonce-> prix_par_nuit ?> € </p>
                <a href="/annonce/<?= $annonce->id ?>/detail" class="btn btn-secondary mt-2">Voir les détails</a>
        <?php if (AuthController::isHote()): ?>
        <a href="/annonce/<?= $annonce->id ?>/delete" class="btn btn-danger mt-2">Supprimer</a>
        <?php endif; ?>

            </div>
        </div>
    <?php endforeach; ?>
    
    </div>
<?php endif; ?>
