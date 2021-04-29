<?php

class AdminModel extends Model {
    public static function getUsersList() {
        $db = Db::getConnection();
        $sql = "SELECT users.id, users.username, users.date_created, role.role AS 'role' FROM users JOIN role ON users.role_id = role.id";
        $result = $db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function createUser($username, $pwd, $role) {
        $db = Db::getConnection();
        $sql = "INSERT INTO `users`( `username`, `password`,`role_id`) VALUES (:username, :pwd, :role)";
        $result = $db->prepare($sql);
        return $result->execute([
            'username' => $username,
            'pwd' => $pwd,
            'role' => $role
        ]);
    }

    public static function deleteUserById($userId) {
        $db = Db::getConnection();
        $sql = "DELETE FROM `users` WHERE id = :userId";
        $result = $db->prepare($sql);
        return $result->execute(['userId' => $userId]);
    }
}