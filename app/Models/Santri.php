<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Santri extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_santri',
        'asal_santri',
        'id_pesantren',
        'email_wali_santri',
        'status_kesehatan',
        'keterangan_kesehatan',
        'foto_santri',
        'status_aktivasi',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $table = "santri";
    protected $primaryKey = "id_santri";
}
