<div class="container mt-5">
    <h1 class="text-center mb-5">Réservations de mes Annonces</h1>
    <table class="table table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th>ID Réservation</th>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Nombre de Personnes</th>
            
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
            <tr class="text-center">
                <td><?= $reservation['id'] ?></td>
                <td><?= $reservation['date_debut'] ?></td>
                <td><?= $reservation['date_fin'] ?></td>
                <td><?= $reservation['nbr_de_personne'] ?></td>
              
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>