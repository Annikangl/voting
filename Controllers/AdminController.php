<?php

class AdminController extends Controller {

    public $pageData = [];
    
    public function __construct() {
        $this->model = new AdminModel();
        $this->view = new View();
    }

    public function index() {
        self::checkAdmin();
        $this->view->render("Views/admin/index.tpl.php", null);
    }

    public function userList() {
        self::checkAdmin();
        $userList = $this->model::getUsersList();
        $this->pageData['usersList'] = $userList;
        $this->view->render("Views/admin/userList.tpl.php", $this->pageData);
    }

    public function addUser() {
        if (isset($_POST)) {
            $username = $_POST['username'];
            $pwd = $_POST['pwd'];
            $role = $_POST['role'];

            $pwd = hash('md5', $pwd);
            $role == 'admin' ? $role = 1 : $role = 2;
            $result = $this->model::createUser($username, $pwd, $role);
        }
    }

    public function deleteUser() {
        if (isset($_POST)) {
            $userId = $_POST['userId'];
            $result = $this->model::deleteUserById($userId);
        }
    }

    // Проверка является ли пользователь админом
    private static function checkAdmin() {
        if ($_SESSION['user']['role'] != 'admin') {
            header("Location: ../");
        }
    }
}