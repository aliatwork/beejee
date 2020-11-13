<!DOCTYPE html>
<html>
<head>

    <title>BeeJee</title>
    <link rel="stylesheet" href="/resource/bootstrap-4.5.3/css/bootstrap.css"/>
    <link rel="stylesheet" href="/resource/fontawesome-free-5.15.1-web/css/all.css"/>

</head>
<body>

<nav class="navbar navbar-light bg-light container">
    <a class="btn btn-danger" href="/logout">Выйти</a>
</nav>

<div class="container mt-5">


    <h1>Администраторская панель</h1>

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
                    <?php if ($row['check_state'] == 'checked') {
                        echo '<div class="alert alert-success" role="alert">Отредактировано администратором</div>';
                    } ?>
                    <form action="/admin/post/change" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>"/>
                        <div class="form-group">
                            <textarea class="form-control" name="text"><?php echo $row['text'] ?></textarea>
                        </div>
                        <input type="submit" value="Изменить" class="btn btn-primary"/>
                    </form>
                </td>
                <td>
                    <?php echo $row['state'] == 'completed' ? '<i class="far fa-check-square"></i>' : '<a href="/admin/post/completed?id=' . $row['id'] . '">Выполнено</a>' ?>
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
                                             href="/admin?page=<?php echo $pagination['prev'] . $paramsText ?>">Пред.</a>
                    </li>
                <?php } ?>
                <?php foreach ($pagination['range'] as $page) { ?>
                    <li class="page-item <?php echo $page == $pagination['cur'] ? 'active' : '' ?>">
                        <a class="page-link"
                           href="/admin?page=<?php echo $page . $paramsText ?>"><?php echo $page ?></a>
                    </li>
                <?php } ?>
                <?php if ($pagination['next'] > 0) { ?>
                    <li class="page-item"><a class="page-link"
                                             href="/admin?page=<?php echo $pagination['next'] . $paramsText ?>">След.</a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    <?php } ?>


</div>


</body>
</html>
