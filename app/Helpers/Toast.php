<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;

class Toast
{
    const SUCCESS = 'success';
    const INFO = 'info';
    const WARNING = 'warning';
    const ERROR = 'error';

    private static string $_status = Toast::INFO;

    public static function success(string $message): void
    {
        Session::flash('toast-status', Toast::SUCCESS);
        Session::flash('toast', $message);
    }

    public static function info(string $message): void
    {
        Session::flash('toast-status', Toast::INFO);
        Session::flash('toast', $message);
    }

    public static function warning(string $message): void
    {
        Session::flash('toast-status', Toast::WARNING);
        Session::flash('toast', $message);
    }

    public static function error(string $message): void
    {
        Session::flash('toast-status', Toast::ERROR);
        Session::flash('toast', $message);
    }

    public static function getStatus(): string
    {
        return Session::get('toast-status', Toast::INFO);
    }

    public static function isAvailable(): bool
    {
        return Session::exists('toast');
    }

    public static function getMessage(): string
    {
        return Session::get('toast', '');
    }
}
