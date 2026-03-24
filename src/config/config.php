<?php
declare(strict_types=1);

const ENV = 'development';
const APP_NAME = 'Fashion Family';
const APP_VERSION = '0.1';
const APP_URL = 'http://localhost/fashion-family/public/';
const BASE_URL = 'http://localhost/fashion-family/';
const ANNEE_FONDATION = '2026';

const PATH_ROOT = __DIR__ . '/../../';
const PATH_TEMPLATES = __DIR__ . '/../templates/';
const PATH_PAGES = __DIR__ . '/../../pages/';

if (ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}