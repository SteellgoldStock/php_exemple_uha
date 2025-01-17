<?php
    require_once './utils/db.php';

    $error = '';
    $success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = trim($_POST['email']);
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);
        $password = trim($_POST['password']);

        if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {
            $conn = getDbConnection();

            $stmt = $conn->prepare('SELECT * FROM users WHERE email = :email');
            $stmt->execute(['email' => $email]);
            if ($stmt->fetch()) {
                $error = 'Un utilisateur avec cet email existe déjà.';
                exit;
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare('INSERT INTO users (
                first_name,
                last_name,
                email,
                password
            ) VALUES (:first_name, :last_name, :email, :password)');

            $stmt->execute([
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email,
                'password' => $hashedPassword,
            ]);

            header('Location: login.php');
        } else {
            $error = 'Veuillez remplir tous les champs.';
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once 'partials/header.php'; ?>

    <body class="h-full w-full flex flex-col items-center justify-center p-3">
        <?php if (!empty($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative flex flex-col items-center mt-2">
                <span class="block sm:inline"><?php echo $success; ?></span>
            </div>
        <?php elseif (!empty($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative flex flex-col items-center mt-2">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <div class="flex flex-col gap-0.5">
            <h1 class="text-3xl font-bold text-clifford">
                Inscription
            </h1>
        </div>

        <form method="POST" action="" class="flex flex-col gap-1 mt-2">
            <div class="flex flex-row gap-1">
                <input type="text" name="firstname" placeholder="Prénom" class="border border-gray-300 px-4 py-2 w-full" required>
                <input type="text" name="lastname" placeholder="Nom" class="border border-gray-300 px-4 py-2 w-full" required>
            </div>

            <input type="email" name="email" placeholder="Email" class="border border-gray-300 px-4 py-2 w-full" required>

            <input type="password" name="password" placeholder="Mot de passe" class="border border-gray-300 px-4 py-2 w-full" required>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mt-3">
                S'inscrire
            </button>
        </form>
    </body>
</html>
