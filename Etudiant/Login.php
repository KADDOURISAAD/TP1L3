<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="styles.css">
  
</head>
<body>
    <div class="login-container">
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p>User Inexistant. Inscrivez-vous.</p>";
        }
        ?>
        <form  method="post" >
            <h2>Login</h2>
            <input type="email" id ="email" name="email" placeholder="Adresse e-mail" required>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
           
            <input type="submit" name="submitType" value="Valider" formaction="valider.php">
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
