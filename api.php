<?php
// On inclut la connexion à la base de données
require 'db.php';

// On récupère la valeur de recherche 'q' envoyée par le JavaScript
// Si 'q' n'existe pas, on utilise une chaîne vide
$search = isset($_GET['q']) ? $_GET['q'] : '';

try {
    // On prépare la requête avec LIKE pour chercher une correspondance partielle
    // %$search% signifie "qui contient le texte"
    $query = "SELECT * FROM utilisateurs WHERE nom LIKE :search OR email LIKE :search ORDER BY id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['search' => "%$search%"]);
    $utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si la liste est vide
    if (count($utilisateurs) === 0) {
        echo '<tr><td colspan="4" class="text-center text-muted">Aucun utilisateur trouvé</td></tr>';
    } else {
        // On génère le HTML des lignes du tableau
        foreach ($utilisateurs as $user) {
            ?>
<tr>
    <td><?= $user['id'] ?></td>
    <td><?= htmlspecialchars($user['nom']) ?></td>
    <td><?= htmlspecialchars($user['email']) ?></td>
    <td>
        <a href="index.php?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm"
            onclick="return confirm('Supprimer cet utilisateur ?')">
            Supprimer
        </a>
    </td>
</tr>
<?php
        }
    }
} catch (PDOException $e) {
    echo "<tr><td colspan='4' class='text-danger'>Erreur : " . $e->getMessage() . "</td></tr>";
}
?>