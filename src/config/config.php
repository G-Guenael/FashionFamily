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

const HOST = 'localhost';
const DB = 'fashion_family';
const USER = 'root';
const PASS_DB = 'root';
const CHARSET = 'utf8mb4';
const DSN = "mysql:host=" . HOST . ';' . "dbname=" . DB . ';' . "charset=" . CHARSET;

const OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

if (ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(0);
    ini_set('display_errors', '0');
}