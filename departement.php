<?php


require_once 'connexion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion DES ADMINISTARATEUR
    </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #009879;
            color: black;
            font-family: "georgia";
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: Transparent;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #ffffff;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #ffffff;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: red;
            text-decoration: none;
            cursor: pointer;
        }
        button {
            flex-direction: column;
            padding: 6px 14px;
            font-family: -apple-system, BlinkMacSystemFont, 'Roboto', sans-serif;
            border-radius: 6px;
            border: none;
            color: #fff;
            background: #009879;
            background-origin: border-box;
            box-shadow: 0px 0.5px 1.5px rgba(54, 122, 246, 0.25), inset 0px 0.8px 0px -0.25px rgba(255, 255, 255, 0.2);
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            cursor: pointer;
        }
        button:focus {
            box-shadow: inset 0px 0.8px 0px -0.25px rgba(255, 255, 255, 0.2), 0px 0.5px 1.5px rgba(54, 122, 246, 0.25), 0px 0px 0px 3.5px rgba(58, 108, 217, 0.5);
            outline: 0;
        }
        h2 {
            font-family: 'georgia';
            color: #009879;
        }
        input {
            box-sizing: border-box;
            font-family: inherit;
            font-size: 14px;
            vertical-align: baseline;
            font-weight: 100;
            line-height: 1.29;
            letter-spacing: .16px;
            border-radius: 0;
            outline: 2px solid transparent;
            outline-offset: -2px;
            width: 50%;
            height: 40px;
            border: none;
            border-bottom: 1px solid #8d8d8d;
            background-color: #f4f4f4;
            padding: 0 16px;
            color: #161616;
            transition: background-color 70ms cubic-bezier(.2,0,.38,.9), outline 70ms cubic-bezier(.2,0,.38,.9);
        }
        input:focus {
            outline: 2px solid #0f62fe;
            outline-offset: -2px;
        }
        .logout {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 20px;
        }
        .logout a {
            text-decoration: none;
        }
        .btn {
            text-decoration: none;
            color: black;
            transition: 0.5s;
            cursor: pointer;
        }
        .btn:hover {
            background-color: darkgreen;
        }
        #addDepartmentBtn {
            margin: 10px;
        }
        nav {
            padding: 10px;
            text-align: center;
            position: fixed;
            top: 27px;
            width: 100%;
            right: 37%;
        }
        nav ul {
            list-style-type: none;
            margin-left: 100px;
            padding: 0;
        }
        nav ul li {
            display: inline;
        }
        nav ul li a {
            color: black;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: #009879;
        }
        nav ul li a:hover {
            background-color: darkgreen;
        }
        .container {
            margin-top: 50px;
        }
        .icon-button {
            background: none;
            border: none;
            color: black;
            cursor: pointer;
            font-size: 20px;
        }
        .icon-button:hover {
            color: darkgreen;
        }
        .success-message {
            display: block;
            width: 50%;
            padding: 10px;
            margin: 10px 200px;
            border: 1px solid green;
            background-color: lightgreen;
            color: darkgreen;
            text-align: center;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="success-message" id="successMessage">
                <?php
                    echo $_SESSION['success_message'];
                    unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>

        <h1>Gestion des admines</h1>
        <a href="Add.php"><button id="addDepartmentBtn" class="btn"><i class="fas fa-plus"></i> Ajouter Admin</button></a>
        <table id="Admin">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Adresse</th>
                    <th>Telephone</th>
                    <th>Id salle</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $admins = $pdo->query('SELECT * FROM admin')->fetchAll(PDO::FETCH_ASSOC);
                foreach ($admins as $admin) {
                ?> 
                    <tr>
                        <td><?php echo $admin['ID_ADMIN'] ?></td>
                        <td><?php echo $admin['NOM'] ?></td>
                        <td><?php echo $admin['PRENOM'] ?></td>
                        <td><?php echo $admin['ADRESSE'] ?></td>
                        <td><?php echo $admin['TELE'] ?></td>
                        <td><?php echo $admin['ID_S'] ?></td>
                        
                        <td>
                        <a href="EditDepartment.php?Id_Admin=<?php echo $admin['ID_ADMIN'] ?>"><button class="icon-button"><i class="fas fa-edit"></i></button></a>
                        <a href="DeleteDepartment.php?ID=<?php echo $admin['ID_ADMIN'] ?>" onclick="return confirm('Are you sure you want to delete this admin?')">
    <button class="icon-button"><i class="fas fa-trash"></i></button>
</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.display = 'none';
                }, 1000); 
            }
        };
    </script>
</body>
</html>
