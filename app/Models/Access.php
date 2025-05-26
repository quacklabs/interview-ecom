<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use App\Models\AccessLevel;
use Spatie\Permission\Traits\HasPermissions;

class Access extends Permission
{
    use HasFactory, HasPermissions; 
    protected $table = 'permissions';

    public function permissionGroup(){
        return $this->belongsTo(AccessLevel::class, 'permission_group_id');
    }
}
