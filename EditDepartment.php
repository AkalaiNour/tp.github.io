<?php
require_once 'connexion.php';

$Id_admin = $_GET['Id_Admin'];

// Check if the form is submitted
if(isset($_POST['edit'])) {
    $name = $_POST['name'];
    $prenom = $_POST['prenom'];
    $adress = $_POST['adress'];
    $tele = $_POST['tele'];
    $id_s = $_POST['id_s'];

    // Ensure the name is not empty
    if (!empty($name)) {
        $sqlStat = $pdo->prepare("UPDATE admin SET NOM=?, PRENOM=?, ADRESSE=?, TELE=?, ID_S=? WHERE ID_ADMIN=?");
        $sqlStat->execute([$name, $prenom, $adress, $tele, $id_s, $Id_admin]);
        $_SESSION['success_message'] = 'Admin updated successfully!';
        header('location: departement.php');
        exit(); // Terminate script execution after redirection
    } else {
        $error_message = 'Enter the admin name';
    }
}

// Fetch admin details for pre-populating the form
$sqlStat = $pdo->prepare('SELECT * FROM admin WHERE ID_ADMIN=?');
$sqlStat->execute([$Id_admin]);
$admin = $sqlStat->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "poppins", sans-serif;
            text-align: center;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: var(--grey);
            background-size: cover;
            background-position: center;
        }
        .container {
            width: 900px;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(10px);
            color: black;
            border-radius: 12px;
            padding: 30px 40px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }
        h1 {
            font-family: "georgia";
            color: black;
        }
        input[type="text"], select {
            width: 50%;
            height: 50px;
            background: transparent;
            border: none;
            outline: none;
            border: 2px solid black;
            border-radius: 40px;
            font-size: 16px;
            color: black;
            padding: 10px 45px 20px 20px;
            margin-bottom: 20px;
        }
        button {
            background-color: green;
            padding: 10px;
            margin: 15px;
            width: 90px;
            border-radius: 10px;
            border: none;
            transition: 0.5s;
        }
        button:hover {
            background-color: darkgreen;
        }
        .alert {
            display: flex;
            padding: 15px;
            border: 1px solid transparent;
            border-radius: 4px;
            margin-bottom: 20px;
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            width: 30%;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }
        .icon-button {
            background: none;
            border: none;
            color: black;
            cursor: pointer;
            font-size: 20px;
            margin-left: 5px; /* Adjust margin as needed */
        }
        .icon-button:hover {
            color: darkgreen;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Edit Admin</h1>
    <?php if(isset($error_message)): ?>
        <div class="alert" role="alert"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <form method="post">
        <label for="name">NOM:</label><br>
        <input type="text" name="name" value="<?php echo $admin['NOM'] ?>" required><br>
        <label for="prenom">prenom:</label><br>
        <input type="text" name="prenom" value="<?php echo $admin['PRENOM'] ?>" required><br>
        <label for="adress">adress:</label><br>
        <input type="text" name="adress" value="<?php echo $admin['ADRESSE'] ?>" required><br>
        <label for="tele">tele:</label><br>
        <input type="text" name="tele" value="<?php echo $admin['TELE'] ?>" required><br>
        <label for="id_s">ID_S:</label><br>
        <select name="id_s" required>
            <?php
            // Fetch ID_S values from the salle table
            $sql = "SELECT ID_S FROM salle";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $salles = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Output options for the select dropdown
            foreach ($salles as $salle) {
                echo "<option value='" . $salle['ID_S'] . "' ";
                if ($salle['ID_S'] == $admin['ID_S']) {
                    echo "selected";
                }
                echo ">" . $salle['ID_S'] . "</option>";
            }
            ?>
        </select><br>
        <button type="submit" name="edit">Edit</button>
    </form>
</div>
</body>
</html>
