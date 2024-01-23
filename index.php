<?php
$servername = "localhost"; // Adresse du serveur MySQL (peut être localhost)
$username = "root"; // Nom d'utilisateur MySQL (par défaut, root pour XAMPP)
$password = ""; // Mot de passe MySQL (celui que vous avez défini)
$dbname = "projet php"; // Nom de votre base de données

// Créer une connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";

// Exemple de requête
$sql = "SELECT IDuser, Nom, Email FROM USERS";
$result = mysqli_query($conn, $sql);

// Vérifier si la requête a réussi
if ($result) {
    // Parcourir les résultats
    while ($row = mysqli_fetch_assoc($result)) {
        echo "\nID: " . $row["IDuser"] . " - Nom: " . $row["Nom"] . " - Email: " . $row["Email"] . "\n";
    }
} else {
    echo "Erreur de requête: " . mysqli_error($conn);
}

?>
