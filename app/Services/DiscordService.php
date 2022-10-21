<?php

namespace App\Services;

use App\Models\Character;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DiscordService
{
    public function auth($request)
    {
        try {
            $token = $this->getAccessToken($request->code, route('register'));
            $userData = $this->getUserData($token);

            if (User::firstWhere('discord_id', $userData['id'])->exists()) {
                return to_route('login')->withErrors([
                    'discord' => __('auth.already_registered'),
                ]);
            }

            return view('auth.register', [
                'discord_data' => $userData,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return to_route('login')->withErrors([
                'discord' => $request->input('error_description', __('auth.discord_error')),
            ]);
        }
    }

    public function getUserData($token)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get('https://discordapp.com/api/users/@me');
        $response->throw();

        return json_decode($response->body(), true);
    }

    public function getAccessToken($code, $redirect)
    {
        $response = Http::asForm()->post('https://discord.com/api/oauth2/token', [
            'client_id' => config('services.discord.clientid'),
            'client_secret' => config('services.discord.secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect,
        ]);
        $response->throw();

        return json_decode($response->body(), true);
    }

    public function createRegistrationTicket(Character $character)
    {
        if ($character->ticket) {
            throw new Exception('Character ticket already exists');
        }

        $response = Http::withHeaders([
            'Authenticate' => config('services.discord.token'),
        ])->post(config('services.discord.tickets.api_url').'/ticket', [
            'guild_id' => config('services.discord.tickets.guild_id'),
            'user_id' => $character->user->discord_id,
            'registrar_id' => $character->registrar->discord_id,
            'category_id' => config('services.discord.tickets.category_id'),
            'topic' => "Регистрация {$character->name}",
        ]);
        $response->throw();

        if ($response->ok()) {
            $ticket = json_decode($response->body(), true);

            $character->ticket()->create([
                'id' => $ticket['id'],
                'character_id' => $character->id,
                'category_id' => config('services.discord.tickets.category_id'),
            ]);
        }
    }

    public function deleteRegistrationTicket(Character $character)
    {
        if (! $character->ticket) {
            throw new Exception('Character has no ticket');
        }

        $response = Http::withHeaders([
            'Authenticate' => config('services.discord.token'),
        ])->delete(config('services.discord.tickets.api_url').'/ticket', [
            'ticket_id' => strval($character->ticket->id),
        ]);
        $response->throw();

        if ($response->ok()) {
            $character->ticket->delete();
        }
    }

    public function verifyUser(User $user)
    {
        if ($user->verified) {
            return;
        }

        $response = Http::withHeaders([
            'Authenticate' => config('services.discord.token'),
        ])->get(config('services.discord.tickets.api_url').'/has-user', [
            'id' => $user->discord_id,
        ]);
        $response->throw();

        if ($response->ok()) {
            $found = json_decode($response->body(), true);
            if ($found) {
                $user->verified = true;
                $user->save();
            }
        }
    }
}
