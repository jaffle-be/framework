<?php

namespace Modules\Theme;

use Illuminate\Contracts\Mail\Mailer as MailContract;
use Illuminate\Mail\Mailer;

class ThemeMailer implements MailContract{

    /**
     * @var Theme
     */
    protected $theme;

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @param Theme $theme
     * @param Mailer $mailer
     */
    public function __construct(Theme $theme, Mailer $mailer)
    {
        $this->theme = $theme;

        $this->mailer = $mailer;
    }

    /**
     * Send a new message when only a raw text part.
     *
     * @param  string $text
     * @param  \Closure|string $callback
     * @return int
     */
    public function raw($text, $callback)
    {
        return $this->mailer->raw($text, $callback);
    }

    /**
     * Send a new message using a view.
     *
     * @param  string|array $view
     * @param  array $data
     * @param  \Closure|string $callback
     * @return void
     */
    public function send($view, array $data, $callback)
    {
        $data = array_merge($data, [
            'theme' => $this->theme,
            'theme_template' => $this->resolveThemeTemplate()
        ]);

        return $this->mailer->send($view, $data, $callback);
    }

    /**
     * Get the array of failed recipients.
     *
     * @return array
     */
    public function failures()
    {
        return $this->mailer->failures();
    }

    protected function resolveThemeTemplate()
    {
        return config('theme.email_template');
    }

}