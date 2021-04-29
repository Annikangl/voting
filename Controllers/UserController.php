<?php

class UserController extends Controller
{

    public $pageData = [];

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new View();
    }


    public function login() {
        $username = '';
        $pwd = '';

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $pwd = $_POST['pwd'];

            $pwd = hash('md5', $pwd);
            $user = UserModel::checkUserData($username, $pwd);

            if ($user) {
                UserModel::setUserSession($user);
                if ($user['role'] == 'admin') {
                    header("Location: ../admin/");
                } else {
                    header("Location: /");
                }
            } else {
                $this->pageData['error'] = 'Ошибка авторизации';
            }
        }
        $this->view->render('Views/user/login.php', $this->pageData);
    }

    // либо залогиниться либо render(login.tpl.php)

    // public function registration() {
    //     $username = '';
    //     $pwd1 = '';
    //     $pwd2 = '';

    //     if (isset($_POST['submit'])) {
    //         $username = $_POST['username'];
    //         $pwd1 = $_POST['pwd1'];
    //         $pwd2 = $_POST['pwd2'];


    //         if ($pwd1 != $pwd2) {
    //             $this->pageData['error'] = "Пароли не совпадают";
    //         }

    //         if (!isset($this->pageData['error'])) {
    //             $pwd1 = hash('md5', $pwd1);
    //             $registration = UserModel::registration($username, $pwd1);

    //             if ($registration) {
    //                 header("Location: ../voting");
    //             }
    //         }
    //     }

    //     $this->view->render('/views/user/registr.php', $this->pageData);
    // }

    public function logout() {
        // session_start();
        session_destroy();
        unset($_SESSION);
        header("Location: login");
    }

    public function addFiles() {
        UserModel::checkLoggined();
        $userId = $_SESSION['user']['id'];


        if (isset($_FILES['inputFile'])) {
            $filename = $_FILES['inputFile']['name'];
            $type = $_FILES['inputFile']['type'];
            $destination_dir = ROOT . '/uploads/';

            // Проверка есть ли директория
            if (is_dir($destination_dir)) {
                // Проверка на тип
                if ($_FILES['inputFile']['type'] == 'text/plain' || $_FILES['inputFile']['type'] == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                    if (move_uploaded_file($_FILES['inputFile']['tmp_name'], $destination_dir . $filename)) {
                        $path = $destination_dir . $filename;
                        $result = UserModel::addUserFile($filename, $type, $path);

                        if ($result) {
                            $documentId = intval($result); // result - последний ID загруженного документа
                            UserModel::addHostoryData($documentId, $userId, $filename);
                            header("Location: " . $_SERVER['HTTP_REFERER']);
                            $this->pageData['message'] = 'Файл успешно загружен';
                            
                        } else {
                            $this->pageData['message'] = 'Неподдерживаемый тип или ошибка загрузки';
                        }
                    }
                } else {
                    $this->pageData['message'] = 'Неподдерживаемый тип или ошибка загрузки';
                }
            }
        }
        $this->view->render('Views/user/uploadPage.tpl.php', $this->pageData);
    }



}
