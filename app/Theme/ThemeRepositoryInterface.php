<?php namespace App\Theme;

interface ThemeRepositoryInterface
{
    public function supported();

    public function current();

    public function activate($theme);
}