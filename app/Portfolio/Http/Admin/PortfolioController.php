<?php namespace App\Portfolio\Http\Admin;

use App\Http\Controllers\AdminController;
use App\Portfolio\Jobs\UpdateProject;
use App\Portfolio\Project;
use Illuminate\Http\Request;

class PortfolioController extends AdminController
{

    public function overview()
    {
        return view('portfolio::admin.overview');
    }

    public function detail()
    {
        return view('portfolio::admin.detail');
    }

    public function index(Project $project, Request $request)
    {
        $query = $project->with([
            'collaborators',
            'images',
            'images.sizes' => function ($query) {
                $query->dimension(150);
            },
            'translations'
        ])->orderBy('date', 'asc');

        $value = $request->get('query');
        $locale = $request->get('locale');

        $query->whereHas('translations', function ($q) use ($value, $locale) {
            if ($value) {
                $q->where('locale', $locale);
                $q->where(function ($q) use ($value) {
                    $q->where('title', 'like', '%' . $value . '%')
                        ->orWhere('description', 'like', '%' . $value . '%');
                });
            }
        });

        return $query->paginate();
    }

    public function show(Project $project)
    {
        $project->load(['translations']);

        return $project;
    }

    public function store(Project $project)
    {
        $project->newInstance();

        return $project->save() ? $project : json_encode(['status' => 'noke']);
    }

    public function update(Request $request, Project $project)
    {
        $project->load('translations');

        $payload = [
            'project'  => $project,
            'input' => translation_input($request, ['title', 'description'])
        ];

        if (!$this->dispatchFromArray(UpdateProject::class, $payload)) {
            return response('500', 'something bad happened');
        }

        return $project;
    }

}