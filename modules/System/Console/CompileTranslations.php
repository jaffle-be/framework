<?php namespace Modules\System\Console;

use Illuminate\Console\Command;
use Illuminate\Translation\Translator;
use Lang;

class CompileTranslations extends Command
{

    protected $signature = 'system:translations';

    protected $description = 'will generate a txt file with all missing translation lines';

    public function handle()
    {
        //make sure we clear the views, so we are not 'finding' keys in already refactored but not yet recompiled views
        $this->call('view:clear');

        //remove old files
        if(file_exists('translations.txt'))
        {
            unlink('translations.txt');
        }
        if(file_exists('translations-missing.txt'))
        {
            unlink('translations-missing.txt');
        }

        //search all translations
        passthru('translations');

        //filter them
        $content = file_get_contents('translations.txt');
        $pieces = explode("\n", $content);
        $pieces = array_unique($pieces);
        $pieces = array_values($pieces);
        sort($pieces);

        $missing = [];
        $found = [];

        /** @var Translator $translator */
        $translator = app('translator');

        foreach($pieces as $piece)
        {
            if(!$translator->has($piece))
            {
                $missing[] = $piece;
            }
            else{
                $found[] = $piece;
            }
        }

        file_put_contents('translations-missing.txt', implode("\n", $missing));

    }

}
