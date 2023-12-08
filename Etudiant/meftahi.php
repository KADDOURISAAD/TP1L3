<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bddtp1";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "
    SELECT n.Num_Etudiant, e.nom, e.prenom,
    SUM(n.Note * n.Coefficient) / SUM(n.Coefficient) AS Moyenne_Ponderee
    FROM notes n
    INNER JOIN formulaire_data e ON n.Num_Etudiant = e.numero
    GROUP BY n.Num_Etudiant
    ";

    $stmt = $conn->query($query);
    $studentAverages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ... (styles CSS)
    echo "<style>
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
</style>";

    echo "<table border='1'>
        <tr>
            <th>Numéro Étudiant</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Moyenne Pondérée</th>
        </tr>";

    $totalAverage = 0;
    $count = count($studentAverages);
    $minAverage = PHP_INT_MAX;
    $maxAverage = -PHP_INT_MAX;

    foreach ($studentAverages as $average) {
        $formattedAverage = number_format($average['Moyenne_Ponderee'], 2);

        echo "<tr>
                <td>" . $average['Num_Etudiant'] . "</td>
                <td>" . $average['nom'] . "</td>
                <td>" . $average['prenom'] . "</td>
                <td>" . $formattedAverage . "</td>
            </tr>";

        $totalAverage += $average['Moyenne_Ponderee'];
        $minAverage = min($minAverage, $average['Moyenne_Ponderee']);
        $maxAverage = max($maxAverage, $average['Moyenne_Ponderee']);
    }

    echo "</table>";

    $formattedTotalAverage = number_format($totalAverage / $count, 2);
    $formattedMinAverage = number_format($minAverage, 2);
    $formattedMaxAverage = number_format($maxAverage, 2);

    echo "<p>Moyenne : " . $formattedTotalAverage . "</p>";
    echo "<p>Moyenne Minimale: " . $formattedMinAverage . "</p>";
    echo "<p>Moyenne Maximale: " . $formattedMaxAverage . "</p>";

} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
