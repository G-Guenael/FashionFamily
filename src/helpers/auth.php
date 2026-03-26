<?php
declare(strict_types=1);

function userConnected(): void
{
    if (isset($_SESSION['user']) && $_SESSION['user']['connecte'] === true) {
        header('Location: ' . BASE_PATH . '/dashbooard');
        exit;
    }
}