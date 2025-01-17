<?php
    require_once 'utils/db.php';

    $conn = getDbConnection();

    $isConnected = !empty($_SESSION['user']);

    if ($isConnected) {
        $query = 'SELECT * FROM users';
        $result = $conn->query($query);
        $users = $result->fetchAll();
    }
?>

<!DOCTYPE html>
<html lang="fr">
    <?php require_once 'partials/header.php'; ?>

    <body class="h-full w-full flex flex-col items-center justify-center p-3">
        <?php
            if (!$isConnected) {
                require_once 'partials/not_connected.php';
                exit;
            }

            require_once 'partials/list_users.php';
        ?>
    </body>
</html>
