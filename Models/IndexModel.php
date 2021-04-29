<?php

class IndexModel extends Model {
    
    public static function getAllDocuments() {
        $db = Db::getConnection();
        $sql = "SELECT documents.id,documents.filename, documents.type, documents.path, documents.uploaded_date, 
                (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote > 0) AS 'likes', 
                (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote = 0) AS 'dislikes' FROM documents 
                ORDER BY documents.id DESC";
        $result = $db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getNewDocuments() {
        $db = Db::getConnection();
        $sql = "SELECT documents.id,documents.filename, documents.type, documents.path, documents.uploaded_date,
                (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote > 0) AS 'likes', 
                (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote = 0) AS 'dislikes' FROM documents 
                WHERE (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote > 0) = 0 AND 
                    (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote = 0) = 0";
        $result = $db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getDocumentInProcess() {
        $db = Db::getConnection();
        $sql = "SELECT documents.id,documents.filename, documents.type, documents.path, documents.uploaded_date, 
                (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote > 0) AS 'likes', 
                (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote = 0) AS 'dislikes' FROM documents 
                WHERE (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote > 0) > 0 OR 
                    (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote = 0) > 0";
        $result = $db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCompletedDocuments() {
        $db = Db::getConnection();
        $sql = "SELECT document_id, documents.id, documents.filename, documents.type, documents.path, documents.uploaded_date, (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote > 0) AS 'likes', 
        (SELECT COUNT(*) FROM likes WHERE likes.document_id = documents.id AND likes.vote = 0) AS 'dislikes',  COUNT(*) AS `users_voted` FROM likes JOIN documents ON documents.id = likes.document_id GROUP BY likes.document_id HAVING users_voted = (SELECT COUNT(*) from users)";
        $result = $db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

}