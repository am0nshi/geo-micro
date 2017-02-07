<?php
namespace App\Models;

use Illuminate\Database\Eloquent;
use App\Models\Base\BaseModel;

class Whitelist extends BaseModel {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Whitelist';

    protected $fillable = ['ip','customerId','fullName'];

}