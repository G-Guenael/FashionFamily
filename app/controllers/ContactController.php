<?php
require_once __DIR__ . '/../../core/BaseController.php';


class ContactController extends BaseController
{
    public function index(): void
    {
        $this->render('home/contact', [
            'description' => APP_NAME . ' - Contactez-nous',
        ], 'Contact');
    }
}