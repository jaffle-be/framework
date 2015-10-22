<?php namespace App\Media\Http\Admin;

use Alaouy\Youtube\Youtube;
use App\Media\Commands\AddNewVideo;
use App\Media\MediaRepositoryInterface;
use App\Media\Video\Video;
use App\Media\Video\VideoGenericFormatter;
use App\System\Http\AdminController;
use App\Theme\ThemeManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends AdminController
{
    use VideoGenericFormatter;

    protected $media;

    public function __construct(ThemeManager $theme, MediaRepositoryInterface $media)
    {
        $this->media = $media;

        parent::__construct($theme);
    }

    public function widget()
    {
        return view('media::admin.video');
    }

    public function index(Request $request)
    {
        $owner = $this->owner($request);

        $videos = $owner->videos;

        return $videos->byLocale();
    }

    protected function owner(Request $request)
    {
        $id = $request->get('ownerId');
        $type = $request->get('ownerType');

        return $this->media->findOwner($type, $id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'url',
        ]);

        $owner = $this->owner($request);

        $input = $request->except(['_token']);

        $video = $this->dispatchFromArray(AddNewVideo::class, [
            'input' => $input,
            'owner' => $owner,
        ]);

        if (!$video) {
            return new JsonResponse('Dit not match any movie', 422);
        }

        return $video;
    }

    public function update(Video $video, Request $request)
    {
        $owner = $this->owner($request);

        if ($video->owner->id == $owner->id) {

            $input = $request->except(['_token', '_method']);

            $video->fill($input);

            $video->save();
        }
    }

    public function destroy(Request $request, Video $video)
    {
        $video->load('owner');

        $owner = $this->owner($request);

        if ($video->owner->id == $owner->id) {
            $video->delete();
        }
    }

    public function sort(Request $request)
    {
        $owner = $this->owner($request);

        $owner->load('videos');

        foreach ($request->get('order') as $position => $id) {
            $video = $owner->videos->find($id);
            $video->sort = $position;
            $video->save();
        }
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'query' => 'required'
        ]);

        if($request->get('mode') == 'youtube')
        {
            /** @var Youtube $youtube */
            $youtube = app('youtube');

            $response = $youtube->searchVideos($request->get('query'), 10, null, ['id', 'snippet']);

            return $this->youtubeResponse($response);
        }
        else{
            $vimeo = app('Vinkla\Vimeo\VimeoManager');

            $response = json_decode(json_encode($vimeo->request('/videos', ['query' => $request->get('query'), 'per_page' => 10])));

            return $this->vimeoReponse($response);
        }
    }



}