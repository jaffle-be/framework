<?php namespace Modules\Media\Commands;

use App\Jobs\Job;
use Exception;

use Illuminate\Filesystem\Filesystem;
use Modules\Account\Account;
use Modules\Media\Configurator;
use Modules\Media\Media;
use Modules\Media\MediaRepositoryInterface;
use Modules\Media\StoresMedia;
use Modules\System\Locale;

class StoreNewFile extends Job
{

    protected $account;

    /**
     * @var StoresMedia
     */
    protected $owner;

    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var string
     */
    protected $currentPath;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var null|string
     */
    protected $rename;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $extension;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var string
     */
    protected $path;

    /**
     * @param Account     $account
     * @param StoresMedia $owner
     * @param Locale      $locale
     * @param string      $path
     * @param null        $rename
     */
    public function __construct(Account $account, StoresMedia $owner, Locale $locale, $path, $rename = null)
    {
        $this->account = $account;
        $this->owner = $owner;
        $this->locale = $locale;
        $this->currentPath = $path;
        $this->directory = pathinfo($path, PATHINFO_DIRNAME);
        $this->filename = pathinfo($path, PATHINFO_FILENAME);
        $this->extension = pathinfo($path, PATHINFO_EXTENSION);
        $this->basename = pathinfo($this->currentPath, PATHINFO_BASENAME);
        $this->rename = $rename;
    }

    public function handle(MediaRepositoryInterface $repo, Filesystem $files, Configurator $config)
    {
        if (!$files->exists($this->currentPath)) {
            return false;
        }

        $this->newName();
        $this->handleFile($files, $config);

        try {
            return $repo->createFile($this->owner, $this->getPayload());
        }
        catch (Exception $exception) {
            //probably duplicate file error, always remove created file on error.
            $files->delete(public_path($this->path));

            return false;
        }
    }

    protected function handleFile(Filesystem $files, Configurator $config)
    {
        $abstract = $config->getAbstractPath($this->owner, 'files');
        $public = $config->getPublicPath($this->owner, 'files');

        if (!$files->isDirectory($public)) {
            $files->makeDirectory($public, 0755, true);
        }

        //abstract path to actual file
        $path = $abstract . $this->rename;

        //always copy the file first
        $files->copy($this->currentPath, public_path($path));

        $this->path = $path;
    }

    protected function newName()
    {
        if (empty($this->rename)) {
            $this->rename = $this->basename;
        }
    }

    /**
     * @return array
     */
    protected function getPayload()
    {
        return [
            'account_id' => $this->account->id,
            'locale_id'  => $this->locale->id,
            'path'       => $this->path,
            'filename'   => $this->rename,
            'extension'  => $this->extension,
        ];
    }
}