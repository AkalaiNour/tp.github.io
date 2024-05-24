<?php
session_start(); // Start the session

require_once 'connexion.php'; // Include your database connection file

// Check if the form is submitted
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $prenom = $_POST['prenom'];
    $adress = $_POST['adress'];
    $tele = $_POST['tele'];
    $id_s = $_POST['id_s']; // Get the selected ID_S from the form

    // Check if the department name is not empty
    if (!empty($name)) {
        // Prepare the SQL statement
        $sqlStat = $pdo->prepare("INSERT INTO admin (NOM, PRENOM, ADRESSE, TELE, ID_S) VALUES (?, ?, ?, ?, ?)");
        // Execute the statement with the provided values
        $sqlStat->execute([$name, $prenom, $adress, $tele, $id_s]);

        // Set a success message in session
        $_SESSION['success_message'] = 'Admin added successfully!';
        // Redirect to the desired page
        header('Location: departement.php');
        exit(); // Terminate script execution
    } else {
        $error_message = 'Enter the admin name'; // Set an error message
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 10px;
        }
        input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Admin</h1>
        <?php if (isset($error_message)): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="name">NOM:</label>
            <input type="text" name="name" required>
            <label for="prenom">Prenom:</label>
            <input type="text" name="prenom" required>
            <label for="adress">Adresse:</label>
            <input type="text" name="adress" required>
            <label for="tele">Tele:</label>
            <input type="text" name="tele" required>
            <label for="id_s">ID_S:</label>
            <select name="id_s" required>
                <?php
                $sql = "SELECT ID_S FROM salle";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $salles = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($salles as $salle) {
                    echo "<option value='" . $salle['ID_S'] . "'>" . $salle['ID_S'] . "</option>";
                }
                ?>
            </select>
            <button type="submit" name="add">Add</button>
        </form> 
    </div>
</body>
</html>
