<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientsPhotos extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'clients_photos';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'client_id',
        'client_photos'
    ];

    /**
     * Method getPhotoUrlAttribute
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        $url = '';
        if( $this->client_photos )
        {
            $url = asset('storage/images/clients_photos/'.$this->client_photos);
        }

        return $url;
    }
}
