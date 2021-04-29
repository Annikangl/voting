<?php

class DocumentController extends Controller {

    public $pageData = [];

    public function __construct() {
        $this->model = new DocumentModel();
        $this->view = new View();
    }

    public function index() {
        self::checkLoggined();
        if (isset($_GET['id'])) {
            $documentId = $_GET['id'];
        }

        // Добавление комментария
        if (isset($_POST['submit'])) {
            $userId = $_SESSION['user']['id'];
            $vote = $_POST['like'];
            $textComment = $_POST['textComment'];
            
            $vote == 'like' ? $vote = 1 : $vote = 0;
            $result = $this->model::addUserVote($userId, $documentId, $vote, $textComment);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }

        // Загрузка обновленного файла
        if (isset($_FILES['inputFile'])) {
            $filename = $_FILES['inputFile']['name'];
            $type = $_FILES['inputFile']['type'];
            $destination_dir = ROOT . 'uploads/';

            if (move_uploaded_file($_FILES['inputFile']['tmp_name'], $destination_dir . $filename)) {
                $path = $destination_dir . $filename;
                $result = $this->model::updateUsersFile($filename, $type, $path, $documentId);

                if ($result) {
                    var_dump($destination_dir);
                    $this->pageData['message'] = 'Файл успешно загружен';
                }
            }
        } else {
            $this->pageData['message'] = 'Неподдерживаемый тип или ошибка загрузки';
        }



        // Получение документа по ID
        $document = $this->model::getDocumentById($documentId);
        // Лайки - Дизлайки
        $likes = $this->model::getDocumentsLike($documentId);
        $dislikes = $this->model::getDocumentsDislike($documentId);

        // Чтение документа WORD
        $documentPath = $document['path'];
        $documentText = $this->readWordDocument($documentPath);
        $this->pageData['documentTextPreview'] = $documentText;

        // Загрузка файла
        if (isset($_POST['submitDownload'])) {
            $this->file_force_download($documentPath);
        }

        // Проверка голосовал ли
        !empty(self::hasVote()) ? $this->pageData['hasVote'] = 1 : '';
        
        // Получение списка комментов
        $comments = $this->userComments($documentId);

        // сохранение состояния документа
        if (isset($_POST['saveState'])) {
             $_SESSION['text'] = $documentText;
        }


        $this->pageData['document'] = $document;
        $this->pageData['dislike'] = $dislikes;
        $this->pageData['like'] = $likes;
        $this->pageData['comments'] = $comments;
        $this->view->render("Views/documents/doc.tpl.php", $this->pageData);
    }


    public function history() {
        $history = $this->model::getDocumentHistory();
        $this->pageData['history'] = $history;
        $this->view->render("Views/documents/history.tpl.php", $this->pageData);
    }

    // Метод для чтения документов WORD
    public function readWordDocument($documentPath) {
        $path = $documentPath;
        $objReader = \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        // Чтение документа
        $phpWord = $objReader->load($path);
        $documentData = '';
        // Получение секций документа
        foreach($phpWord->getSections() as $section) {
            $elementsArray = $section->getElements();
            foreach($elementsArray as $element) {
                if (get_class($element) === 'PhpOffice\PhpWord\Element\TextRun') {
                    foreach($element->getElements() as $text) {
                        $text->getText(); // Текст документа
                        $font = $text->getFontStyle(); // Стили шрифта
                        $fontWeight  = $font->isBold() ? '700' : ''; // Определяем жирность шрифта

                        $documentData .= '<span>' . $text->getText() . '</span>';
                        
                    }
                } else if (get_class($element) === 'PhpOffice\PhpWord\Element\TextBreak') {
                    $documentData .=  '<br/>';
                }
            }

        }
        return $documentData;
    }

    public static function checkLoggined() {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        } else {
            header("Location: /user/login");
        }
    }

    // Загрузка файлов с сервера
    public function file_force_download($file) {
        if (file_exists($file)) {
          // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
          // если этого не сделать файл будет читаться в память полностью!
          if (ob_get_level()) {
            ob_end_clean();
          }
          // заставляем браузер показать окно сохранения файла
          header('Content-Description: File Transfer');
          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename=' . basename($file));
          header('Content-Transfer-Encoding: binary');
          header('Expires: 0');
          header('Cache-Control: must-revalidate');
          header('Pragma: public');
          header('Content-Length: ' . filesize($file));
          // читаем файл и отправляем его пользователю
          readfile($file);
          exit;
        }
      }

    // Комментарии пользователей
    public function userComments($documentId) {
        $result = $this->model::getUsersComments($documentId);
        return $result;
    }

    //   Проверка голоса пользователя
    private static function hasVote() {
        $userId = $_SESSION['user']['id'];
        $documentId = $_GET['id'];
        return DocumentModel::checkUserVote($userId, $documentId);
    }
}