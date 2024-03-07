<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientsDocuments extends Model
{
    use HasFactory, SoftDeletes;

    /** @var string $table */
    protected $table = 'clients_documents';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'client_id',
        'client_documents'
    ];

    /**
     * Method getDocumentUrlAttribute
     *
     * @return string
     */
    public function getDocumentUrlAttribute()
    {
        $url = '';
        if( $this->client_documents )
        {
            $url = asset('storage/images/clients_documents/'.$this->client_documents);
        }

        return $url;
    }
}
