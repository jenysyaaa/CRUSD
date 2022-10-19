<?php

namespace App\Models;

use App\Enums\CharacterGender;
use App\Enums\CharacterStatus;
use App\Traits\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Kyslik\ColumnSortable\Sortable;

class Character extends Model
{
    use HasFactory, HybridRelations, Sortable, Searchable;

    public $sortable = [
        'name',
        'status_updated_at',
        'status',
    ];

    protected $fillable = [
        'name',
        'description',
        'gender',
        'race',
        'age',
        'appearance',
        'background',
        'info_hidden',
        'bio_hidden',
        'login',
        'status',
        'status_updated_at',
        'player_only_info',
        'gm_only_info',
        'registered',
        'vox',
        'personality',
        'last_idea',
    ];

    protected $casts = [
        'status' => CharacterStatus::class,
        'gender' => CharacterGender::class,
        'info_hidden' => 'boolean',
        'bio_hidden' => 'boolean',
    ];

    public function hasFreeIdea()
    {
        return ! isset($this->last_idea) || Carbon::now()->startOfWeek()->greaterThan(Carbon::createFromTimeString($this->last_idea));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrar()
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    public function charsheet()
    {
        return $this->hasOne(Charsheet::class, 'character', 'login');
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }

    public function narrativeCrafts()
    {
        return $this->hasMany(NarrativeCraft::class);
    }

    public function perkVariants()
    {
        return $this->belongsToMany(PerkVariant::class, 'characters_perks')->withPivot('note', 'active');
    }

    public function fates()
    {
        return $this->hasMany(Fate::class);
    }

    public function voxLogs()
    {
        return $this->hasMany(VoxLog::class);
    }

    public function skins()
    {
        return $this->hasMany(Skin::class);
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function spheres()
    {
        return $this->hasMany(Sphere::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function scopeFilter($query, $request)
    {
        $query->search($request->search);

        if ($request->has('perk')) {
            $query->hasPerk($request->perk);
        }
    }

    public function scopeHasPerk($query, $perkId)
    {
        $query->whereHas('perkVariants', function ($query) use ($perkId) {
            $query->where('perk_id', $perkId);
        });
    }

    public function scopeStatus($query, $status)
    {
        $query->where('status', $status);
    }

    public function status(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                $this->status_updated_at = now();

                return $value;
            },
        );
    }

    public function reference(): Attribute
    {
        return Attribute::make(
            get: function () {
                $disk = Storage::disk('characters');
                $fileName = $this->id . '/reference';

                return $disk->url($disk->exists($fileName) ? $fileName : 'default/reference');
            }
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Character $character) {
            if ($character->charsheet) {
                $character->charsheet->delete();
            }
        });

        static::created(function ($character) {
            info('Character created', [
                'user' => auth()->user() !== null ? auth()->user()->login : null,
                'character' => $character->login,
            ]);
        });

        static::updated(function ($character) {
            info('Character updated', [
                'user' => auth()->user()->login,
                'character' => $character->login,
            ]);
        });

        static::deleted(function ($character) {
            info('User unbanned', [
                'user' => auth()->user()->login,
                'character' => $character->login,
            ]);
        });
    }
}
