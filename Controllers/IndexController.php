<?php


class IndexController extends Controller {

    public function __construct()
    {
        $this->model = new IndexModel();
        $this->view = new View();
    }

    public function index() {
        if (isset($_GET['newDoc'])) {
            $newDocuments = $this->model::getNewDocuments();
            $this->pageData['documents'] = $newDocuments;
            $this->pageData['style']['nav__newDoc'] = 'active';
            $this->view->render('/Views/main.tpl.php', $this->pageData);
        } else if (isset($_GET['processDoc'])) {
            $processDocuments = $this->model::getDocumentInProcess();
            $this->pageData['documents'] = $processDocuments;
            $this->pageData['style']['nav__processDoc'] = 'active';
            $this->view->render('/Views/main.tpl.php', $this->pageData);
        } else if (isset($_GET['completeDoc'])) {
            $completedDocuments = $this->model::getCompletedDocuments();
            $this->pageData['style']['nav__completeDoc'] = 'active';
            $this->pageData['documents'] = $completedDocuments;
            $this->view->render('/Views/main.tpl.php', $this->pageData);
        }

        $documents = IndexModel::getAllDocuments();
        $this->pageData['documents'] = $documents;
        $this->pageData['style']['nav__allDoc'] = 'active';
        $this->view->render('/Views/main.tpl.php', $this->pageData);
    }

}