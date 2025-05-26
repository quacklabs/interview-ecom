<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Access;
use Spatie\Permission\Traits\HasPermissions;

class AccessLevel extends Model
{
    use HasFactory, HasPermissions;
    protected $table = 'permission_groups';

    public function relate() {
        dd($this->getRelations());
    }

    public function permissions() {
        return $this->hasMany(Access::class, 'permission_group_id');
    }
}
