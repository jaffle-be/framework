<?php

namespace Modules\System\Presenter;

trait ShortCodeCompiler
{

    public function formatShortcodes($content)
    {
        return $this->loopShortcodes('format', $content);
    }

    public function loopShortcodes($type, $content)
    {
        if (!property_exists($this, 'shortcodes')) {
            throw new \Exception('You need to add the shortcodes property to ' . get_called_class());
        }

        foreach ($this->shortcodes as $code) {
            $method = $type . ucfirst($code) . 'ShortCodes';

            if (method_exists($this, $method)) {
                $content = $this->$method($content);
            }
        }

        return $content;
    }

    public function compileShortcodes($content)
    {
        return $this->loopShortcodes('compile', $content);
    }

    public function stripShortcodes($content)
    {
        return $this->loopShortcodes('strip', $content);
    }
}
