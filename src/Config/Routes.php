<?php

$routes->group('admin', function ($routes) {

    $routes->resource('licencias', [
        'filter' => 'permission:licencias-permission',
        'controller' => 'licenciasController',
        'except' => 'show',
        'namespace' => 'julio101290\boilerplatelicences\Controllers',
    ]);
    $routes->post('licencias/save'
            , 'LicenciasController::save'
            , ['namespace' => 'julio101290\boilerplatelicences\Controllers']
             );
    
    $routes->post('licencias/getLicencias'
            , 'LicenciasController::getLicencias'
            , ['namespace' => 'julio101290\boilerplatelicences\Controllers']
            );


});
