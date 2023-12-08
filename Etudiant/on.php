<?php
// Connexion à la base de données (assurez-vous d'avoir défini les informations de connexion correctes)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddtp1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les informations de la note depuis la table "notes" avec jointure sur la table "module"
$sql_notes = "SELECT formulaire_data.numero AS Num_Etudiant, 
                     formulaire_data.Nom, 
                     formulaire_data.Prenom, 
                     module.DesignationModule, 
                     notes.Coefficient, 
                     notes.Note 
              FROM notes 
              INNER JOIN module ON notes.Code_module = module.CodeModule
              INNER JOIN formulaire_data ON notes.Num_Etudiant = formulaire_data.numero
              ORDER BY formulaire_data.numero, module.DesignationModule";
$result_notes = $conn->query($sql_notes);

if ($result_notes->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Notes de tous les étudiants</title>
        <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }

                .container {
                    max-width: 800px;
                    margin: 0 auto;
                    padding: 20px;
                }

                h1 {
                    color: #333;
                    text-align: center;
                }

                p {
                    color: #666;
                    margin-bottom: 10px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }

                th, td {
                    border: 1px solid #ddd;
                    padding: 12px;
                    text-align: left;
                }

                th {
                    background-color: #0366d6;
                    color: white;
                }

                tr:nth-child(even) {
                    background-color: #f2f2f2;
                }

                tr:hover {
                    background-color: #ddd;
                }
            </style>
    </head>
    <body>
        <h1>Notes de tous les étudiants</h1>
        <table>
            <tr>
                <th>Numéro d'étudiant</th>
                <th>Nom/Prénom</th>
                <th>Module</th>
                <th>Coefficient</th>
                <th>Note</th>
            </tr>
            <?php
            while ($row_note = $result_notes->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_note["Num_Etudiant"] . "</td>";
                echo "<td>" . $row_note["Nom"] . ' ' . $row_note["Prenom"] . "</td>";
                echo "<td>" . $row_note["DesignationModule"] . "</td>";
                echo "<td>" . $row_note["Coefficient"] . "</td>";
                echo "<td>" . ($row_note["Note"] !== null ? $row_note["Note"] : 'Note non saisie') . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </body>
    </html>
    <?php
} else {
    echo "Aucune note disponible pour les étudiants.";
}

$conn->close();
?>
