<?php

// Not that's going to use it, but it's part of the exercise.  ¯\_(ツ)_/¯
// For productionised DB access though, you will definitely need to enforce a memory limit to induce a timeout.
ini_set('memory_limit', '128M');

require 'User.php';
require 'UserRepository.php';
require 'AnonymizeService.php';

$pdo = new PDO('sqlite:./database.sqlite');
$userRepository = new UserRepository($pdo);
$anonymizeService = new AnonymizeService();

switch ($argv[1]) {
    case 'migrate':
        migrate($pdo);
        echo "Migration done.\n";
        break;
    case 'seed':
        seed($pdo);
        echo "Seeding done.\n";
        break;
    case 'get-users':
        $users = $userRepository->getAllUsers();
        foreach ($users as $user) {
            $anonymizeService->anonymizeEmail($user);
            echo "{$user->getName()}: {$user->getEmail()}\n";
        }
        break;
    default:
        echo "Unknown command.\n";
}

function migrate($pdo) {
    $sql = "CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT, email TEXT)";
    $pdo->exec($sql);
}

function seed($pdo) {
    $users = [
        ['name' => 'Ryu', 'email' => 'ryu@hadoukenmail.com'],
        ['name' => 'Chun-Li', 'email' => 'chun.li@spinningbird.org'],
        ['name' => 'Ken Masters', 'email' => 'ken.masters@shoryuken.net'],
        ['name' => 'Dhalsim', 'email' => 'dhalsim@yogamail.net'],
        ['name' => 'Blanka', 'email' => 'blanka@electricweb.co'],
        ['name' => 'E. Honda', 'email' => 'e.honda@sumowrestler.co'],
        ['name' => 'Guile', 'email' => 'guile@sonicboommail.com'],
        ['name' => 'M. Bison', 'email' => 'm.bison@psycho-power.net'],
        ['name' => 'Zangief', 'email' => 'zangief@redcyclone.org'],
        ['name' => 'Vega', 'email' => 'vega@masked.clawfighter.org']
    ];

    foreach ($users as $user) {
        $sql = "INSERT INTO users (name, email) VALUES ('{$user['name']}', '{$user['email']}')";
        $pdo->exec($sql);
    }
}

