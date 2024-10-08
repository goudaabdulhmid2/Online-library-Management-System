<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'loans';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'loan_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'due_date',
        'return_date',
        'loan_status',
    ];

    protected $dates = ['loan_date', 'due_date'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

  
    public function book()
    {
        return $this->belongsTo(Book::class,'book_id');
    }
}
