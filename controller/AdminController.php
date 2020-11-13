<?php

namespace App;

class AdminController
{

    public function login()
    {
        if (!Auth::getInstance()->isAdmin()) {
            $errors = [];
            $data = [];
            if (Helper::isRequestMethodPost()) {
                $data = Helper::getRequestData();
                $errors = Helper::validate($data, [
                    'name' => 'isset',
                    'password' => 'isset',
                ]);
                if (!Auth::getInstance()->verify($data['name'], $data['password'])) {
                    $errors['name'] = 'Имя или пароль введены не правильно';
                }
                if (count($errors) == 0) {
                    Auth::getInstance()->adminOnline();
                    Helper::redirect('/admin');
                }
            }
            Helper::drawView('login', ['data' => $data, 'errors' => $errors]);
            exit;
        }
        Helper::redirect('/admin');
    }

    public function logout()
    {
        Auth::getInstance()->checkAdmin();
        Auth::getInstance()->adminOffline();
        Helper::redirect('/');
    }

    public function index()
    {
        Auth::getInstance()->checkAdmin();
        $model = new TaskModel();
        $rowsPerPage = Helper::getPaginationRowsPerPage();
        $pageNumber = Helper::getPaginationCurPage();
        $sortField = Helper::getSortField();
        $sortOrder = Helper::getSortOrder();
        $pagination = Helper::getPagination(Database::getInstance()->getTasksCount() / Helper::getPaginationRowsPerPage(), Helper::getPaginationCurPage());

        Helper::drawView('admin', [
            'data' => $model->getData($rowsPerPage, $pageNumber, $sortField, $sortOrder),
            'pagination' => $pagination,
            'sort' => $sortField,
            'order' => $sortOrder,
        ]);


    }

    public function postChange()
    {
        Auth::getInstance()->checkAdmin();
        $model = new TaskModel();
        if (Helper::isRequestMethodPost()) {
            $data = Helper::getRequestData();
            $errors = Helper::validate($data, [
                'id' => 'isset',
                'text' => 'isset',
            ]);
            if (count($errors) == 0) {
                if ($model->change($data['id'], $data['text'])) {
                    Helper::redirect('/admin');
                }
            }
        }
        Helper::redirect('/admin');
    }

    public function postCompleted()
    {
        Auth::getInstance()->checkAdmin();
        $model = new TaskModel();
        $data = Helper::getRequestData();
        $errors = Helper::validate($data, [
            'id' => 'isset',
        ]);
        if (count($errors) == 0) {
            if ($model->completed($data['id'])) {
                Helper::redirect('/admin');
            }
        }
        Helper::redirect('/admin');
    }

}