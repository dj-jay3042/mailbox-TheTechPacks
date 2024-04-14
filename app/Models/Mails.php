<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mails extends Model
{
    protected $table = 'tblMails';
    protected $primaryKey = 'mailId';
    public $timestamps = false;

    protected $fillable = [
        'mailToEmail', 'mailFromEmail', 'mailToName', 'mailFromName', 'mailSubject', 'mailContent', 'mailType', 'mailIsDeleted', 'mailHasAttachment', 'mailIsRead'
    ];

    public function attachments()
    {
        return $this->hasMany('App\Attachment', 'atcMailId', 'mailId');
    }
}
