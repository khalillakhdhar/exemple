<?php require 'db.php'; 

// Ajout d'utilisateur
if (isset($_POST['ajouter'])) {
    $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email) VALUES (?, ?)");
    $stmt->execute([$_POST['nom'], $_POST['email']]);
    header("Location: index.php");
}

// Suppression
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP & Temps Réel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white text-center">Ajouter un Utilisateur</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" placeholder="Ex: Jean Dupont"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="exemple@mail.com"
                                    required>
                            </div>
                            <button type="submit" name="ajouter" class="btn btn-primary w-100">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                        <span>Liste des Utilisateurs</span>
                        <input type="text" id="searchInput" class="form-control form-control-sm w-50"
                            placeholder="Recherche rapide...">
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="userTable">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const searchInput = document.getElementById('searchInput');
    const userTable = document.getElementById('userTable');

    // Fonction pour charger les données
    function loadUsers(query = '') {
        fetch('api.php?q=' + query)
            .then(response => response.text())
            .then(data => {
                userTable.innerHTML = data;
            });
    }

    // Charger au démarrage
    loadUsers();

    // Écouter la saisie clavier
    searchInput.addEventListener('keyup', () => {
        loadUsers(searchInput.value);
    });
    </script>

</body>

</html>