<?php

namespace Modules\Shop\Product;

use Modules\Search\SearchServiceInterface;

class CategorySuggestSyncer
{
    public function handle(CategoryTranslation $translation)
    {
        $model = $translation->category;

        if ($model->original_id) {
            $model = $model->originalCategory;
        }

        $model->load(['translations', 'synonyms', 'synonyms.translations']);

        /** @var SearchServiceInterface $search */
        $search = app('Modules\Search\SearchService');

        foreach ($model->synonyms as $synonym) {
            $search->update($synonym);
        }

        $search->update($model);

        $search->getClient()->indices()->optimize([
            'only_expunge_deletes' => true,
        ]);
    }
}
