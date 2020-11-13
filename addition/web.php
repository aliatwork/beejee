<?php

use App\Route;

$routes = new Route();

$routes->add('/', 'Main@index');
$routes->add('/task/create', 'Main@create');
$routes->add('/login', 'Admin@login');
$routes->add('/logout', 'Admin@logout');
$routes->add('/admin', 'Admin@index');
$routes->add('/admin/post/change', 'Admin@postChange');
$routes->add('/admin/post/completed', 'Admin@postCompleted');

$routes->execute();

