<?php

namespace App;

class Helper
{
    static public function getDir() {
        return __DIR__ . DIRECTORY_SEPARATOR . '..';
    }

    static public function redirect($url)
    {
        header('Location: ' . $url);
        exit;
    }

    static public function isRequestMethodGet()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) == 'GET';
    }

    static public function isRequestMethodPost()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) == 'POST';
    }

    static public function getRequestData()
    {
        return $_REQUEST;
    }

    static public function addToCache($key, $value)
    {
        $_SESSION['cache'][$key] = $value;
    }

    static public function getFromCache($key)
    {
        return $_SESSION['cache'][$key];
    }

    static public function dropCache()
    {
        unset($_SESSION['cache']);
    }

    static public function validate($data, $parameters)
    {
        $errors = [];
        foreach ($parameters as $key => $parameter) {
            if ($parameter == 'isset') {
                if (!isset($data[$key]) || $data[$key] == "") {
                    $errors[$key] = "Заполните поле";
                }
            }
        }
        return $errors;
    }

    static public function getPagination($pageCount, $curPage)
    {
        $prev = 0;
        $next = 0;
        $range = [];
        if ($curPage - 1 > 0) {
            $range[] = $curPage - 1;
            $prev = $curPage - 1;
        }
        $range[] = $curPage;
        if ($curPage < $pageCount) {
            $range[] = $curPage + 1;
            $next = $curPage + 1;
        }
        return [
            'count' => $pageCount,
            'cur' => $curPage,
            'prev' => $prev,
            'next' => $next,
            'range' => $range,
        ];
    }

    static public function getPaginationCurPage()
    {
        $requestData = Helper::getRequestData();
        return $requestData['page'] ? $requestData['page'] : 1;
    }

    static public function getPaginationRowsPerPage()
    {
        $requestData = Helper::getRequestData();
        return $requestData['limit'] ? $requestData['limit'] : 3;
    }

    static public function getSortField()
    {
        $requestData = Helper::getRequestData();
        return $requestData['sort'] ? $requestData['sort'] : '';
    }

    static public function getSortOrder()
    {
        $requestData = Helper::getRequestData();
        return $requestData['order'] ? $requestData['order'] : '';
    }

    static public function drawView($template, $data = null)
    {
        $curDir = __DIR__ . DIRECTORY_SEPARATOR . '..';
        if (is_array($data)) {
            extract($data);
        }
        include $curDir . '/view/' . $template . '.php';
    }

}