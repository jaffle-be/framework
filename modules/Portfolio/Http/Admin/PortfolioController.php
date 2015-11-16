<?php namespace Modules\Portfolio\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Media\MediaWidgetPreperations;
use Modules\Portfolio\Jobs\UpdateProject;
use Modules\Portfolio\Project;
use Modules\System\Http\AdminController;

class PortfolioController extends AdminController
{

    use MediaWidgetPreperations;

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

        if ($value) {
            $query->whereHas('translations', function ($q) use ($value, $locale) {

                $q->where('locale', $locale);
                $q->where(function ($q) use ($value) {
                    $q->where('title', 'like', '%' . $value . '%')
                        ->orWhere('content', 'like', '%' . $value . '%');
                });
            });
        }

        return $query->paginate();
    }

    public function show(Project $project)
    {
        $project->load(['translations']);

        $this->prepareMedia($project);

        return $project;
    }

    public function store(Project $project, AccountManager $accounts)
    {
        $project->newInstance();

        $project->account_id = $accounts->account()->id;

        return $project->save() ? $project : json_encode(['status' => 'noke']);
    }

    public function update(Request $request, Project $project)
    {
        $project->load('translations');

        $payload = [
            'project' => $project,
            'input'   => translation_input($request, ['published', 'title', 'content'])
        ];

        if (!$this->dispatchFromArray(UpdateProject::class, $payload)) {
            return response('500', 'something bad happened');
        }

        return $project;
    }

    public function destroy(Project $project)
    {
        if ($project->delete()) {
            $project->id = false;
        }

        return $project;
    }

    public function batchDestroy(Request $request, Project $project)
    {
        $projectids = $request->get('projects', []);

        if (is_array($projectids) && count($projectids)) {
            $projects = $project->whereIn('id', $projectids)->get();

            foreach ($projects as $project) {
                $project->delete();
            }
        }
    }

    public function batchPublish(Request $request, Project $project)
    {
        $ids = $request->get('projects', []);

        if (is_array($ids) && count($ids)) {
            $projects = $project->whereIn('portfolio_projects.id', $ids)
                ->get();

            foreach ($projects as $project) {
                $translation = $project->translate($request->get('locale'));

                if ($translation) {
                    $translation->published = true;
                }

                $translation->save();
            }
        }
    }

    public function batchUnpublish(Request $request, Project $project)
    {
        $ids = $request->get('projects', []);

        if (is_array($ids) && count($ids)) {
            $projects = $project->whereIn('portfolio_projects.id', $ids)
                ->get();

            foreach ($projects as $project) {
                $translation = $project->translate($request->get('locale'));

                if ($translation) {
                    $translation->published = false;
                }

                $translation->save();
            }
        }
    }

}