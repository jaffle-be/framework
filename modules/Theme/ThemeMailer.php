<?php

namespace Modules\Theme;

use Illuminate\Contracts\Mail\Mailer as MailContract;
use Illuminate\Mail\Mailer;

/**
 * Class ThemeMailer
 * @package Modules\Theme
 */
class ThemeMailer implements MailContract
{
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
     * @param string $text
     * @param \Closure|string $callback
     * @return int
     */
    public function raw($text, $callback)
    {
        return $this->mailer->raw($text, $callback);
    }

    /**
     * @param array|string $view
     * @param array $data
     * @param \Closure|string $callback
     * @throws \Exception
     */
    public function send($view, array $data, $callback)
    {
        $this->validateData($data);

        $data = array_merge($data, [
            'theme' => $this->theme,
            'theme_template' => $this->resolveThemeTemplate(),
        ]);

        $previousRootUrl = $this->setRootUrl($data['root_url']);

        //let's wrap our closure to automatically to set email defaults.
        //when we passed a string, our callback represents the subject line
        if (is_string($callback)) {
            $callback = $this->stringClosure($data, $callback);
        } else {
            //if we don't have a subject, but a closure, we'll be wrapping it again
            //and call the closure itself at the bottom of our wrapping closure.
            //this allows us to override it in the originally passed closure.
            $this->closureClosure($data, $callback);
        }

        $result = $this->mailer->send($view, $data, $callback);

        $this->setRootUrl($previousRootUrl);

        return $result;
    }

    /**
     * @param $data
     * @throws \Exception
     */
    protected function validateData($data)
    {
        if (! isset($data['email_from'], $data['email_from_name'], $data['email_to'], $data['root_url'])) {
            throw new \Exception('need all valid email fields in the data array');
        }
    }

    /**
     * @return mixed
     */
    protected function resolveThemeTemplate()
    {
        return config('theme.email_template');
    }

    /**
     * @param $new
     * @return mixed
     */
    protected function setRootUrl($new)
    {
        $old = config('app.url');

        config()->set('app.url', $new);

        app('url')->forceRootUrl($new);

        return $old;
    }

    /**
     * @param array $data
     * @param $callback
     * @return \Closure
     */
    protected function stringClosure(array $data, $callback)
    {
        $callback = function ($message) use ($callback, $data) {
            $message->from($data['email_from'], $data['email_from_name']);
            $message->to($data['email_to']);
            $message->subject($callback);
        };

        return $callback;
    }

    /**
     * @param array $data
     * @param $callback
     * @return \Closure
     */
    protected function closureClosure(array $data, $callback)
    {
        return $callback = function ($message) use ($callback, $data) {
            $message->from($data['email_from'], $data['email_from_name']);
            $message->to($data['email_to']);

            $callback($message);

            if (! $message->from) {
                throw new \Exception('need to set subject line');
            }
        };
    }

    /**
     * Get the array of failed recipients.
     *
     *
     */
    public function failures()
    {
        return $this->mailer->failures();
    }
}
