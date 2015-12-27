<?php

namespace Modules\Users\Http\Admin;

use Illuminate\Auth\Guard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Modules\Account\AccountManager;
use Modules\System\Http\AdminController;
use Modules\Users\Skill;

/**
 * Class SkillController
 * @package Modules\Users\Http\Admin
 */
class SkillController extends AdminController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function widget()
    {
        return view('tags::admin.widget');
    }

    /**
     * @param Skill $skill
     * @param Request $request
     * @param AccountManager $manager
     * @param Guard $guard
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Paginator
     */
    public function index(Skill $skill, Request $request, AccountManager $manager, Guard $guard)
    {
        $value = $request->get('value');

        $locale = $request->get('locale');

        $user = $guard->user();

        $skills = $user->skills->lists('id')->toArray();

        //why o why did we paginate this?
        $skills = $skill
            ->with(['translations'])
            ->where(function ($q) use ($skills) {
                if (! empty($skills)) {
                    $q->whereNotIn('id', $skills);
                }
            })
            ->whereHas('translations', function ($q) use ($value, $locale) {
                $q->where('locale', $locale);
                $q->where('name', 'like', '%'.$value.'%');
            })
            ->paginate(10);

        $sorted = new Collection($skills->items());

        $sorted = $sorted->sortBy(function ($skill) use ($locale) {
            return $skill->translate($locale)->name;
        });

        $skills = new Paginator($sorted, $skills->perPage(), $skills->currentPage());

        return $skills;
    }

    /**
     * @param Request $request
     * @param Skill $skill
     * @param Guard $guard
     * @return Skill|static
     */
    public function store(Request $request, Skill $skill, Guard $guard)
    {
        $name = $request->get('name');
        $locale = $request->get('locale');

        $user = $guard->user();

        $skill = $skill->create([
            $locale => [
                'name' => $name,
            ],
        ]);

        $user->skills()->attach($skill);

        return $skill;
    }

    /**
     * @param Skill $skill
     * @param Request $request
     * @param Guard $guard
     * @return mixed
     */
    public function update(Skill $skill, Request $request, Guard $guard)
    {
        //save base data for the skill
        $data = translation_input($request, ['name', 'description']);

        $skill->load(['translations']);

        $skill->fill($data);

        $skill->save();

        //attach the skill to the user if needed
        $user = $guard->user();

        if (! $user->skills->contains($skill->id)) {
            $user->skills()->attach($skill);
        }

        //update the pivot data when necessary
        $userSkill = $user->skills()->find($skill->id);

        if ($userSkill) {
            $userSkill->pivot->level = array_get($request->get('pivot'), 'level');

            $userSkill->pivot->save();
        }

        $userSkill->load('translations');

        return $userSkill;
    }

    /**
     * @param Skill $skill
     * @param Request $request
     * @param Guard $guard
     * @throws \Exception
     */
    public function destroy(Skill $skill, Request $request, Guard $guard)
    {
        $user = $guard->user();

        $user->skills()->detach($skill);

        if ($skill->users()->count() == 0) {
            $skill->delete();
        }
    }
}
