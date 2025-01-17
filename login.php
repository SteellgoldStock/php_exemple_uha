<?php
    require_once './utils/db.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (!empty($email) && !empty($password)) {
            $conn = getDbConnection();

            $stmt = $conn->prepare('SELECT id, first_name, last_name, password FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                ];

                header('Location: index.php');
            } else {
                echo 'Nom d\'utilisateur ou mot de passe incorrect.';
            }
        } else {
            echo 'Veuillez remplir tous les champs.';
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once 'partials/header.php'; ?>

    <body class="h-full w-full flex flex-col items-center justify-center p-3">

        <div class="flex flex-col gap-0.5">
            <h1 class="text-3xl font-bold text-clifford">
                Connexion
            </h1>
        </div>

        <form method="POST" action="" class="flex flex-col gap-1 mt-2">
            <input type="email" name="email" placeholder="Email" class="border border-gray-300 px-4 py-2 w-full" required>
            <input type="password" name="password" placeholder="Mot de passe" class="border border-gray-300 px-4 py-2 w-full" required>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-3">
                Se connecter
            </button>
        </form>
    </body>
</html>
