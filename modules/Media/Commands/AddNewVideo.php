<?php

namespace Modules\Media\Commands;

use Alaouy\Youtube\Youtube;
use App\Jobs\Job;
use Modules\Account\AccountManager;
use Modules\Media\MediaRepositoryInterface;
use Modules\Media\StoresMedia;
use Modules\Media\Video\VideoGenericFormatter;
use Modules\System\Locale;

class AddNewVideo extends Job
{

    use VideoGenericFormatter;

    /**
     * @var StoresMedia
     */
    protected $owner;

    /**
     * @var
     */
    protected $title;

    /**
     * @var
     */
    protected $input;

    public function __construct(StoresMedia $owner, $input)
    {
        $this->owner = $owner;
        //stores url, id, title
        //will store id when adding using search
        //will store url when adding using url
        $this->input = $input;
    }

    public function handle(AccountManager $accounts, MediaRepositoryInterface $media, Locale $locale)
    {
        if ($this->input['mode'] == 'youtube') {
            $info = $this->handleYoutube();
        } elseif ($this->input['mode'] == 'vimeo') {
            $info = $this->handleVimeo();
        }

        if (!$info) {
            return false;
        }

        $locale = $locale->whereSlug($this->input['locale'])->firstOrFail();

        $input = array_merge(array_except($this->input, ['url', 'mode']), [
            'provider' => $this->input['mode'],
            'provider_id' => $info['provider_id'],
            'provider_thumbnail' => $info['provider_thumbnail'],
            'title' => $info['title'],
            'description' => $info['description'],
            'width' => $info['width'],
            'height' => $info['height'],
            'account_id' => $accounts->account()->id,
            'locale_id' => $locale->id,
        ]);

        return $media->createVideo($this->owner, $input);
    }

    protected function handleYoutube()
    {
        /** @var Youtube $youtube */
        $youtube = app('youtube');

        try {
            if (isset($this->input['url']) && $this->input['url']) {
                $id = $youtube->parseVIdFromURL($this->input['url']);
            } else {
                $id = $this->input['provider_id'];
            }

            $info = $youtube->getVideoInfo($id);

            return $this->youtubeVideoResponse($info);
        } catch (\Exception $e) {
            if (isset($info)) {
                app('log')->notice('handling youtube video failed', ['message' => $e->getMessage(), 'info' => $info]);
            } else {
                app('log')->notice('handling youtube video failed', ['message' => $e->getMessage()]);
            }

            return false;
        }
    }

    protected function handleVimeo()
    {
        $vimeo = app('Vinkla\Vimeo\VimeoManager');

        if (isset($this->input['url']) && $this->input['url']) {
            $id = substr(parse_url($this->input['url'], PHP_URL_PATH), 1);
        } else {
            $id = $this->input['provider_id'];
        }

        if ($id) {
            $response = $vimeo->request('/videos/' . $id);

            return $this->vimeoVideoResponse($response['body']);
        }
    }
}
