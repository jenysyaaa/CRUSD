<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('characters.edit') }}
    </h2>
  </x-slot>

  <x-container class="max-w-3xl mx-auto">
    <x-character.stages :character="$character" />

    <form class="space-y-8" method="POST" action="{{ route('characters.update', $character->login) }}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')

      <x-form.card>
        <x-slot name="header">
          {{ __('characters.cards.main_info') }}
        </x-slot>

        <x-form.input name="name" maxlength="100" required :value="old('name', $character->name)"/>
        <x-form.select required :name="'gender'" :values="App\Enums\CharacterGender::getKeys()" :labels="array_map(function($status) { return App\Enums\CharacterGender::fromValue($status)->localized(); }, App\Enums\CharacterGender::getValues())" :value="old('gender', $character->gender->description)"/>
        <x-form.input name="race" maxlength="100" required :value="old('race', $character->race)" />
        <x-form.input name="age" maxlength="100" required :value="old('age', $character->age)"/>
        <x-form.textarea name="description" maxlength="512" required onfocus="preview(this)" wrap="on">
          {{ old('description', $character->description) }}
        </x-form.textarea>

        <x-form.checkbox name="info_hidden" value="{{ old('info_hidden', $character->info_hidden) }}" />
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('characters.cards.visuals') }}
        </x-slot>

        <x-form.input name="reference" type="file" accept="image/*" />
        <x-form.textarea name="appearance" maxlength="10000" required onfocus="preview(this)" wrap="on">
          {{ old('appearance', $character->appearance) }}
        </x-form.textarea>
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('characters.cards.biography') }}
        </x-slot>

        <x-form.textarea name="background" onfocus="preview(this)" wrap="on">
          {{ old('background', $character->background) }}
        </x-form.textarea>
        <x-form.checkbox name="bio_hidden" value="{{ old('bio_hidden', boolval($character->bio_hidden)) }}" />
      </x-form.card>

      <x-form.card>
        <x-slot name="header">
          {{ __('characters.cards.additional_info') }}
        </x-slot>

        <x-form.textarea name="player_only_info" onfocus="preview(this)" wrap="on">
          {{ old('player_only_info', $character->player_only_info) }}
        </x-form.textarea>

        @can('seeGmOnlyInfo', $character)
          <x-form.textarea name="gm_only_info" onfocus="preview(this)" wrap="on">
            {{ old('gm_only_info', $character->gm_only_info) }}
          </x-form.textarea>
        @endcan
      </x-form.card>

      <x-button>
        {{ __('ui.submit') }}
      </x-button>
    </form>
    <script>
      var previewText = @json(__('label.preview'));
    </script>
  </x-container>
</x-app-layout>
