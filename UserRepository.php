<?php

require 'UserRepositoryInterface.php';

class UserRepository implements UserRepositoryInterface {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAllUsers(): array {
        $stmt = $this->pdo->query('SELECT * FROM users');

        return $stmt->fetchAll(PDO::FETCH_FUNC, function(int $id, string $name, string $email) {
            return new User($id, $name, $email);
        });
    }
}
