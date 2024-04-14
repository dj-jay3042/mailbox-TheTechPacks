<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'tblAttachment';
    protected $primaryKey = 'atcId';
    public $timestamps = false;

    protected $fillable = [
        'atcMailId', 'atcLocation', 'atcIsDeleted'
    ];

    public function mail()
    {
        return $this->belongsTo('App\Mail', 'atcMailId', 'mailId');
    }
}
