<?php
use Illuminate\Http\Request;

function translation_input(Request $request, array $except = [])
{
    $input = $request->except($except);

    if(isset($input['translations']))
    {
        foreach ($input['translations'] as $locale => $translation) {
            $input[$locale] = $translation;
        }

        unset($input['translations']);
    }

    return $input;
}