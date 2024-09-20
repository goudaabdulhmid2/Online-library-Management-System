<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'books';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'book_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
         'author', 
         'genre_id', 
         'description',
         'quantity'
    ];

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function loans(){
        return $this->hasMany(Loan::class);
    }
}
