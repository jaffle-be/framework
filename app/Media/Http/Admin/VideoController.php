<?php namespace App\Media\Http\Admin;

use Alaouy\Youtube\Youtube;
use App\Media\Commands\AddNewVideo;
use App\Media\Video\Video;
use App\Media\Video\VideoGenericFormatter;
use App\System\Http\AdminController;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class VideoController extends AdminController
{
    use VideoGenericFormatter;

    public function widget()
    {
        return view('media::admin.video');
    }

    public function index(Request $request)
    {
        $owner = $this->owner($request);

        $videos = $owner->videos;

        if ($videos) {
            $videos->load($this->relations());

            if (!$videos instanceof Collection) {
                $videos = new Collection([$videos]);
            }
        }

        return $videos;
    }

    protected function relations()
    {
        return [
            'translations',
        ];
    }

    protected function sizes(Request $request)
    {
        $type = $request->get('ownerType');

        $sizes = config('media.sizes');

        if (!isset($sizes[$type])) {
            throw new \Exception('No valid sizes for this media type defined');
        }

        return $sizes[$type];
    }

    protected function owner(Request $request)
    {
        $id = $request->get('ownerId');
        $type = $request->get('ownerType');

        $owners = config('media.owners');

        if (!isset($owners[$type])) {
            throw new Exception('Invalid owner type provided for videos');
        }

        $class = $owners[$type];

        $class = new $class();

        return $class->findOrFail($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'url' => 'url',
        ]);

        $owner = $this->owner($request);

        $input = translation_input($request);

        $video = $this->dispatchFromArray(AddNewVideo::class, [
            'input' => $input,
            'owner' => $owner,
        ]);

        if (!$video) {
            return new JsonResponse(['url' => ['Dit not match any youtube movie']], 422);
        }

        return $video;
    }

    public function update(Video $video, Request $request)
    {
        $video->load($this->relations());

        $owner = $this->owner($request);

        if ($video->owner->id == $owner->id) {

            $input = translation_input($request, ['_token', 'title']);

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

            return $this->vimeoReponse($response->body);
        }
    }



}