<?php

class DocumentModel extends Model {
    
    public static function getDocumentById(int $documentId) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `documents` WHERE id=:id";
        $result = $db->prepare($sql);
        $result->execute([':id' => $documentId]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function getDocumentsDislike($documentId) {
        $db = Db::getConnection();
        $sql = "SELECT COUNT(likes.vote) AS 'dislike' FROM `documents` 
                JOIN likes ON documents.id = likes.document_id WHERE likes.vote = 0 AND documents.id=:documentId GROUP BY documents.id";
        $result = $db->prepare($sql);
        $result->execute([':documentId' => $documentId]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function getDocumentsLike($documentId) {
        $db = Db::getConnection();
        $sql = "SELECT COUNT(likes.vote) AS 'dislike' FROM `documents` 
                JOIN likes ON documents.id = likes.document_id WHERE likes.vote = 1 AND documents.id=:documentId GROUP BY documents.id";
        $result = $db->prepare($sql);
        $result->execute([':documentId' => $documentId]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public static function addUserVote($userId, $documentId, $vote, $textComment) {
        $db = Db::getConnection();
        $sql = "INSERT INTO `likes`(`user_id`, `document_id`, `vote`, `comment`) VALUES (:userId, :documentId, :vote, :textComment)";
        $result = $db->prepare($sql);
        $result->execute([
            'userId' => $userId,
            'documentId' => $documentId,
            'vote' => $vote,
            'textComment' => $textComment
        ]);
        return $result;
    }

    public static function getUsersComments($documentId) {
        $db = Db::getConnection();
        $sql = "SELECT likes.user_id, likes.vote, likes.comment, likes.date, users.username FROM `likes` JOIN users ON likes.user_id = users.id WHERE document_id = :documentId";
        $result = $db->prepare($sql);
        $result->execute([
            'documentId' => $documentId
        ]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDocumentHistory() {
        $db = Db::getConnection();
        $sql = "SELECT documents_history.id, documents_history.user_id, users.username AS 'username', documents_history.time, documents_history.filename FROM `documents_history` 
                JOIN users ON documents_history.user_id = users.id";
        $result = $db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Проверка на голос пользователя
    public static function checkUserVote($userId, $documentId) {
        $db = Db::getConnection();
        $sql = "SELECT * FROM likes WHERE user_id = :userId AND likes.document_id = :documentId";
        $result = $db->prepare($sql);
        $result->execute([
            "userId" => $userId,
            "documentId" => $documentId
        ]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Обновление файла
    public static function updateUsersFile($filename, $type, $path, $documentId) {
        $db = Db::getConnection();
        $sql = "UPDATE `documents` SET `filename`=:filename,`type`=:type,`path`=:path WHERE documents.id = :documentId";
        $result = $db->prepare($sql);
        return $result->execute([
            'filename' => $filename,
            'type' => $type,
            'path' => $path,
            'documentId' => $documentId
        ]);
    }
}