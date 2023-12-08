<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddtp1";
$message = ''; // Initialisez une variable pour stocker le message
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Requête pour récupérer l'utilisateur par son email depuis la base de données
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        // Vérification du mot de passe
        if (password_verify($password, $user['mdp'])) {
            // Mot de passe correct, rediriger en fonction du rôle
            if ($user['role'] == 'User') {
                header("Location: RechBultain.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            // Mot de passe incorrect
            $message = "Mot de passe incorrect. Veuillez réessayer.";
        }
    } else {
        // Utilisateur inexistant, message pour inciter à l'inscription
        $message = "Cet utilisateur n'existe pas. Veuillez vous inscrire.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <?php if (!empty($message)) { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
        <form method="post" >
            <h2>Connexion</h2>
            <input type="email" id ="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" name="submitType" value="valider" formaction="valider.php">
            <input  type="submit" onclick="showUserTypeForm()" value ="Inscription" formaction="inscription.php">
            <div id="userTypeForm" style="display: none;">
    <select name="role" onchange="updateUserType()">
        <option value="Admin">Admin</option>
        <option value="User">User</option>
    </select>
</div>


        </form>
    </div>

    <script>
        function showUserTypeForm() {
            document.getElementById('userTypeForm').style.display = 'block';
        }

        function updateUserType() {
    var selectedRole = document.querySelector('select[name="roleSelection"]').value;
    document.getElementById('userType').value = selectedRole;
    document.querySelector('form').submit(); // Soumettre le formulaire
}

    </script>
</body>
</html>
