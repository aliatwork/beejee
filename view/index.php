<!DOCTYPE html>
<html>
<head>
    <title>BeeJee</title>
    <link rel="stylesheet" href="/resource/bootstrap-4.5.3/css/bootstrap.css"/>
    <link rel="stylesheet" href="/resource/fontawesome-free-5.15.1-web/css/all.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/resource/bootstrap-4.5.3/js/bootstrap.min.js"></script>
</head>
<body>


<nav class="navbar navbar-light bg-light container">
    <a class="btn btn-primary" href="/login">Авторизация</a>
</nav>


<div class="container mt-5">

    <?php if (\App\Helper::getFromCache('message')) { ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Успешно!</strong> <?php echo \App\Helper::getFromCache('message') ?>
        </div>
    <?php } ?>

    <h1>Список задач</h1>

    <table class="table">
        <?php
        $params = \App\Helper::getRequestData();
        unset($params['sort']);
        unset($params['order']);
        $paramsText = '';
        foreach ($params as $key => $param) {
            $paramsText .= '&' . $key . '=' . $param;
        }
        ?>
        <tr>
            <th>
                <?php
                $sortName = 'fa-sort';
                $url = '?' . $paramsText . '&sort=name&order=' . \App\Database::ORDER_ASCEND;
                if (\App\Helper::getSortField() == 'name') {
                    if (\App\Helper::getSortOrder() == \App\Database::ORDER_ASCEND) {
                        $sortName = 'fa-sort-down';
                        $url .= '&sort=name&order=' . \App\Database::ORDER_DESCEND;
                    } else if (\App\Helper::getSortOrder() == \App\Database::ORDER_DESCEND) {
                        $sortName = 'fa-sort-up';
                        $url .= '&sort=name&order=' . \App\Database::ORDER_ASCEND;
                    }
                }
                ?>
                Имя
                <a href="<?php echo $url ?>"><i class="fas <?php echo $sortName ?>"></i></a>
            </th>
            <th>
                <?php
                $sortEmail = 'fa-sort';
                $url = '?' . $paramsText . '&sort=email&order=' . \App\Database::ORDER_ASCEND;
                if (\App\Helper::getSortField() == 'email') {
                    if (\App\Helper::getSortOrder() == \App\Database::ORDER_ASCEND) {
                        $sortEmail = 'fa-sort-down';
                        $url .= '&sort=email&order=' . \App\Database::ORDER_DESCEND;
                    } else if (\App\Helper::getSortOrder() == \App\Database::ORDER_DESCEND) {
                        $sortEmail = 'fa-sort-up';
                        $url .= '&sort=email&order=' . \App\Database::ORDER_ASCEND;
                    }
                }
                ?>
                E-mail
                <a href="<?php echo $url ?>"><i class="fas <?php echo $sortEmail ?>"></i></a>
            </th>
            <th>
                Задача
            </th>
            <th>
                <?php
                $sortState = 'fa-sort';
                $url = '?' . $paramsText . '&sort=state&order=' . \App\Database::ORDER_ASCEND;
                if (\App\Helper::getSortField() == 'state') {
                    if (\App\Helper::getSortOrder() == \App\Database::ORDER_ASCEND) {
                        $sortState = 'fa-sort-down';
                        $url .= '&sort=state&order=' . \App\Database::ORDER_DESCEND;
                    } else if (\App\Helper::getSortOrder() == \App\Database::ORDER_DESCEND) {
                        $sortState = 'fa-sort-up';
                        $url .= '&sort=state&order=' . \App\Database::ORDER_ASCEND;
                    }
                }
                ?>
                Статус
                <a href="<?php echo $url ?>"><i class="fas <?php echo $sortState ?>"></i></a>
            </th>
        </tr>
        <?php
        foreach ($data as $row) {
            ?>
            <tr>
                <td>
                    <?php echo $row['name'] ?>
                </td>
                <td>
                    <?php echo $row['email'] ?>
                </td>
                <td>
                    <?php echo $row['text'] ?>
                </td>
                <td>
                    <?php echo $row['state'] == 'completed' ? '<i class="far fa-check-square"></i>' : '<i class="far fa-square"></i>' ?>
                </td>
            </tr>
            <?php
        }
        ?>
    </table>

    <?php

    $params = \App\Helper::getRequestData();
    unset($params['page']);
    $paramsText = '';
    foreach ($params as $key => $param) {
        $paramsText .= '&' . $key . '=' . $param;
    }
    if ($pagination['count'] > 1) { ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php if ($pagination['prev'] > 0) { ?>
                    <li class="page-item"><a class="page-link"
                                             href="/?page=<?php echo $pagination['prev'] . $paramsText ?>">Пред.</a>
                    </li>
                <?php } ?>
                <?php foreach ($pagination['range'] as $page) { ?>
                    <li class="page-item <?php echo $page == $pagination['cur'] ? 'active' : '' ?>">
                        <a class="page-link"
                           href="/?page=<?php echo $page . $paramsText ?>"><?php echo $page ?></a>
                    </li>
                <?php } ?>
                <?php if ($pagination['next'] > 0) { ?>
                    <li class="page-item"><a class="page-link"
                                             href="/?page=<?php echo $pagination['next'] . $paramsText ?>">След.</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    <?php } ?>

    <a class="btn btn-primary" href="/task/create">Новая задача</a>

</div>


</body>
</html>
