<?php
namespace App\Models;

use Mindscms\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $fillable = ['name','display_name','description'];
}