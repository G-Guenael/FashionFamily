<?php

class ErrorController
{
    public function notFound(): array
    {
        return [
            'titrePage' => 'Page introuvable',
            'view' => '404',
        ];
    }
}