

<div class="container mt-5">
    <h1 class="text-center mb-5">Mes Réservations</h1>
    <table class="table table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th>Numéro de Réservation</th>
                <th>Date de Début</th>
                <th>Date de Fin</th>
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
