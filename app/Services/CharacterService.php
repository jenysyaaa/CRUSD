<?php

namespace App\Services;

use App\Enums\CharacterStatus;
use App\Events\CharacterCompletelyDeleted;
use App\Events\CharacterDeleted;
use App\Models\Character;
use Illuminate\Support\Facades\Storage;

class CharacterService
{
    public function create($request)
    {
        $validated = $request->validated();
        $character = $request->user->characters()->create($validated);
        $character->charsheet()->create();

        $this->saveReference($character, $validated);

        return $character;
    }

    public function update($character, $request)
    {
        $charsheet = $character->charsheet;
        $validated = $request->validated();

        $character->update($validated);

        if ($charsheet->character !== $character->login) {
            $charsheet->character = $character->login;
            $charsheet->save();
        }

        $this->saveReference($character, $validated);
    }

    public function saveReference($character, $validated)
    {
        $file = $validated['reference'];

        Storage::disk('characters')->putFileAs($character->id, $file, 'reference');
    }

    public function delete($character)
    {
        $character->status = CharacterStatus::Deleting;
        $character->save();

        event(new CharacterDeleted($character));
    }

    public function restore($character)
    {
        $character->status = CharacterStatus::Blank;
        $character->save();
    }

    public function forceDelete($character)
    {
        event(new CharacterCompletelyDeleted($character));

        $character->delete();
    }
}
