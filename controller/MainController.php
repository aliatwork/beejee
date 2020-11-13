<?php

namespace App;

class MainController
{
    public $model;

    function __construct()
    {
        $this->model = new TaskModel();
    }

    public function index()
    {
        $rowsPerPage = Helper::getPaginationRowsPerPage();
        $pageNumber = Helper::getPaginationCurPage();
        $sortField = Helper::getSortField();
        $sortOrder = Helper::getSortOrder();
        $pagination = Helper::getPagination(Database::getInstance()->getTasksCount() / Helper::getPaginationRowsPerPage(), Helper::getPaginationCurPage());
        Helper::drawView('index', [
            'data' => $this->model->getData($rowsPerPage, $pageNumber, $sortField, $sortOrder),
            'pagination' => $pagination,
            'sort' => $sortField,
            'order' => $sortOrder,
        ]);
        Helper::dropCache();
    }

    public function create()
    {
        $errors = [];
        $data = [];
        if (Helper::isRequestMethodPost()) {
            $data = Helper::getRequestData();
            $errors = Helper::validate($data, [
                'name' => 'isset',
                'email' => 'isset',
                'text' => 'isset',
            ]);
            if (count($errors) == 0) {
                $this->model->add($data['name'], $data['email'], $data['text']);
                Helper::addToCache('message', 'Задача добавлена');
                Helper::redirect('/');
            }
        }
        Helper::drawView('task-form', ['data' => $data, 'errors' => $errors]);
    }

}