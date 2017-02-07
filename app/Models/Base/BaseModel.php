<?php namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model  {
//    use SoftDeletes;

    protected $primaryKey = 'Id';

//    const CREATED_AT = 'DateCreated';
//    const UPDATED_AT = 'DateUpdated';
//    const DELETED_AT = 'DateDeleted';



}