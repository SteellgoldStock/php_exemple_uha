<?php
    require_once 'utils/db.php';

    $conn = getDbConnection();

    $query = 'SELECT * FROM users';
    $result = $conn->query($query);
    $users = $result->fetchAll();

    $isConnected = !empty($_SESSION['user']);

    if (!$isConnected) {
        header('Location: login.php');
        exit;
    }
?>

<div class="flex flex-col gap-0.5">
    <h1 class="text-3xl font-bold text-clifford">
        Listes des utilisateurs
    </h1>

    <p class="text-lg text-gray-700">
        Voici la liste des utilisateurs enregistrés dans la base de données.
    </p>
</div>

<table class="w-full mt-3">
    <thead>
    <tr>
        <th class="border border-gray-300 px-4 py-2">ID</th>
        <th class="border border-gray-300 px-4 py-2">Nom</th>
        <th class="border border-gray-300 px-4 py-2">Email</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <tr>
            <td class="border border-gray-300 px-4 py-2"><?php echo $user['id']; ?></td>
            <td class="border border-gray-300 px-4 py-2">
                <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>
            </td>
            <td class="border border-gray-300 px-4 py-2"><?php echo $user['email']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>