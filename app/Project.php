<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class Project extends Model
{
    public $table = 'projects';

    const IS_ACTIVE_RADIO = [
        '1' => 'active',
        '0' => 'not active',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'code',
        'location',
        'bowheer',
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function projectAssets()
    {
        return $this->hasMany(Asset::class, 'project_id', 'id');
    }
}
