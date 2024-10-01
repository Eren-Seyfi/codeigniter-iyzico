<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/iyzico-responsive', 'Home::iyzicoResponsive');
$routes->get('/iyzico-popup', 'Home::iyzicoPopup');
$routes->post('/iyzico-payment-verify', 'Home::iyzicoPaymentVerify');

