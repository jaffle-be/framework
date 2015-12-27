<?php

namespace Modules\Portfolio\Http\Admin;

use Illuminate\Http\Request;
use Modules\Account\AccountManager;
use Modules\Media\MediaWidgetPreperations;
use Modules\Portfolio\Jobs\UpdateProject;
use Modules\Portfolio\Project;
use Modules\System\Http\AdminController;

/**
 * Class PortfolioController
 * @package Modules\Portfolio\Http\Admin
 */
class PortfolioController extends AdminController
{
    use MediaWidgetPreperations;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function overview()
    {
        return view('portfolio::admin.overview');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail()
    {
        return view('portfolio::admin.detail');
    }

    /**
     * @param Project $project
     * @param Request $request
     * @return mixed
     */
    public function index(Project $project, Request $request)
    {
        $query = $project->with([
            'collaborators',
            'images',
            'images.sizes' => function ($query) {
                $query->dimension(150);
            },
            'translations',
        ])->orderBy('date', 'asc');

        $value = $request->get('query');
        $locale = $request->get('locale');

        if ($value) {
            $query->whereHas('translations', function ($q) use ($value, $locale) {

                $q->where('locale', $locale);
                $q->where(function ($q) use ($value) {
                    $q->where('title', 'like', '%'.$value.'%')
                        ->orWhere('content', 'like', '%'.$value.'%');
                });
            });
        }

        return $query->paginate();
    }

    /**
     * @param Project $project
     * @return Project
     */
    public function show(Project $project)
    {
        $project->load(['translations']);

        $this->prepareMedia($project);

        return $project;
    }

    /**
     * @param Project $project
     * @param AccountManager $accounts
     * @return Project|string
     */
    public function store(Project $project, AccountManager $accounts)
    {
        $project->newInstance();

        $project->account_id = $accounts->account()->id;

        return $project->save() ? $project : json_encode(['status' => 'noke']);
    }

    /**
     * @param Request $request
     * @param Project $project
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Project|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, Project $project)
    {
        $project->load('translations');

        if (! $this->dispatch(new UpdateProject($project, translation_input($request, ['published', 'title', 'content'])))) {
            return response('500', 'something bad happened');
        }

        return $project;
    }

    /**
     * @param Project $project
     * @return Project
     * @throws \Exception
     */
    public function destroy(Project $project)
    {
        if ($project->delete()) {
            $project->id = false;
        }

        return $project;
    }

    /**
     * @param Request $request
     * @param Project $project
     */
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

    /**
     * @param Request $request
     * @param Project $project
     */
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

    /**
     * @param Request $request
     * @param Project $project
     */
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
