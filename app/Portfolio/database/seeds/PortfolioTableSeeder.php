<?php

use App\Account\Account;
use App\Account\Client;
use App\Media\Commands\StoreNewImage;
use App\Portfolio\Project;
use App\System\Seeder;
use App\Tags\Tag;
use App\Users\User;
use Illuminate\Foundation\Bus\DispatchesCommands;

class PortfolioTableSeeder extends Seeder
{

    use DispatchesCommands;

    public function __construct(\Intervention\Image\ImageManager $images)
    {
        $this->images = $images;

        $this->image_sizes = config('media.sizes.portfolio');

        $this->prefix = __DIR__ . '/../images/';

        parent::__construct();
    }

    public function run()
    {
        \DB::connection()->disableQueryLog();

        $this->preImageCaching();

        $projects = Project::all();
        $account = Account::find(1);
        $clients = Client::all();

        foreach($projects as $project)
        {
            $project->delete();
        }

        $users = User::all();
        $users = $users->lists('id')->toArray();
        //flip so we can use array_rand
        $tags = array_flip(Tag::lists('id')->toArray());

        for ($i = 0; $i < 35; $i++) {

            $project = App\Portfolio\Project::create([
                'account_id' => 1,
                'date'        => $this->nl->dateTimeBetween('-3 months', 'now'),
                'website'     => $this->nl->url,
                'nl'      => [
                    'title' => $this->nl->sentence(2),
                    'description' => $this->nl->text(1300),
                    'created_at'  => $this->nl->dateTimeBetween('-3 months', 'now'),
                    'updated_at'  => $this->nl->dateTimeBetween('-2 months', 'now'),
                ],
                'fr'      => [
                    'title' => $this->fr->sentence(2),
                    'description' => $this->fr->text(1300),
                    'created_at'  => $this->fr->dateTimeBetween('-3 months', 'now'),
                    'updated_at'  => $this->fr->dateTimeBetween('-2 months', 'now'),
                ],
                'en'      => [
                    'title' => $this->en->sentence(2),
                    'description' => $this->en->text(1300),
                    'created_at'  => $this->en->dateTimeBetween('-3 months', 'now'),
                    'updated_at'  => $this->en->dateTimeBetween('-2 months', 'now'),
                ],
                'de'      => [
                    'title' => $this->de->sentence(2),
                    'description' => $this->de->text(1300),
                    'created_at'  => $this->de->dateTimeBetween('-3 months', 'now'),
                    'updated_at'  => $this->de->dateTimeBetween('-2 months', 'now'),
                ]
            ]);

            $counter = 0;

            if ($counter < 5) {
                $count = 2;
            } else {
                $count = 1;
            }

            while ($counter < $count) {
                $this->newImage($project, $account);
                $counter++;
            }

            echo 'project number ' . $i . PHP_EOL;


            //foreach project we randomly add 1 to 3 collaborators
            $amount = rand(1, 3);
            $possibleUsers = $users;

            for($j = 0; $j < $amount; $j++)
            {
                shuffle($possibleUsers);

                $add = array_shift($possibleUsers);

                $project->collaborators()->attach($add);
            }

            $project->tags()->sync(array_rand($tags, 2));

            $project->client()->associate($clients->random());

            $project->save();

        }
    }

    protected $image_names = [
        'PORTFOLIO_O14A0456.jpg',
        'PORTFOLIO_O14A0464.jpg',
        'PORTFOLIO_O14A0465.jpg',
        'PORTFOLIO_IMG_0331.jpg',
        'PORTFOLIO_IMG_0324.jpg',
    ];

    protected $image_sizes = [];

    protected $prefix;

    protected $images;


    protected function newImage($post, $account)
    {
        $image = rand(0, count($this->image_names) - 1);

        $this->dispatchFromArray(StoreNewImage::class, [
            'account' => $account,
            'owner'   => $post,
            'path'    => $this->prefix . $this->image_names[$image],
            'sizes'   => $this->image_sizes,
            'seeding' => true
        ]);
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function dimensions($size)
    {
        if (strpos($size, 'x') === false && is_numeric($size)) {
            return array($size, null);
        }

        list($width, $height) = explode('x', $size);

        if (!is_numeric($width) || !is_numeric($height)) {
            throw new Exception('Invalid image size provided');
        }

        return array($width, $height);
    }

    /**
     * @param $images
     * @param $sizes
     *
     * @return mixed
     */
    protected function preImageCaching()
    {
        //run images cachings.
        foreach ($this->image_names as $image) {

            $path = $this->prefix . $image;

            foreach ($this->image_sizes as $size) {

                list($width, $height) = $this->dimensions($size);

                $constraint = $this->constraint($width, $height);

                $this->images->cache(function ($image) use ($path, $width, $height, $constraint) {
                    $image->make($path)->resize($width, $height, $constraint);
                });
            }
        }
    }

    protected function constraint($width, $height)
    {
        if ($width === null || $height === null) {
            return function ($constraint) {
                $constraint->aspectRatio();
            };
        }

        return null;
    }

}