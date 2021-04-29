<?php

class UserModel extends Model {

    public static function registration($username,$pwd) {
        $db = Db::getConnection();
        $sql = "INSERT INTO `users` (username,password) 
                VALUES (:username, :pwd)";
        $result = $db->prepare($sql);
        $result->execute(
            [
            'username' => $username,
            'pwd' => $pwd,
            ]
        );
        return $result;
    }

    public static function checkUserData($username, $pwd) {
        $db = Db::getConnection();
        $sql = "SELECT users.id, users.username, role.role AS 'role' FROM users JOIN role ON users.role_id = role.id WHERE username=:username AND password=:pwd";
        $result = $db->prepare($sql);
        $result->execute([
            'username' => $username,
            'pwd' => $pwd
            ]);

        if ($result->rowCount() != 0) {
            return $result->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public static function setUserSession($user) {
        // session_start();
        $_SESSION['user'] = $user;
    }

    public static function addUserFile($filename,$type,$path) {
        $db = Db::getConnection();
        $sql = "INSERT INTO `documents`(`filename`, `type`, `path`) VALUES (:filename, :type, :path)";
        $result = $db->prepare($sql);
        $result->execute([
            'filename' => $filename,
            'type' => $type,
            'path' => $path
        ]);

        return $db->lastInsertId();
    }

    // История загрузки файлов
    public static function addHostoryData($documentId, $userId, $filename) {
        $db = Db::getConnection();
        $sql = "INSERT INTO `documents_history`(`document_id`, `user_id`, `filename`) VALUES (:documentId, :userId, :filename)";
        $result = $db->prepare($sql);
        $result->execute([
            'documentId' => $documentId,
            'userId' => $userId,
            'filename' => $filename
        ]);

        return $result;
    }

    // Проверка авторизации пользователя
    public static function checkLoggined()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        } else {
            header("Location: /user/login/");
        }
    }

}