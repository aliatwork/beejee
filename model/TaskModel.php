<?php

namespace App;

class TaskModel
{

    public function getData($rowsPerPage, $pageNumber, $sortField = '', $sortOrder = '')
    {
        return Database::getInstance()->getTasksList($sortField, $sortOrder, $rowsPerPage, ((int)$rowsPerPage * ((int)$pageNumber - 1)));
    }

    public function add($name, $email, $text)
    {
        return Database::getInstance()->addTask($name, $email, $text);
    }

    public function change($id, $text)
    {
        return Database::getInstance()->changeTaskText($id, $text) && Database::getInstance()->checkTask($id, Database::STATE_CHECKED);
    }

    public function completed($id)
    {
        return Database::getInstance()->completeTask($id, Database::STATE_COMPLETED);
    }

}