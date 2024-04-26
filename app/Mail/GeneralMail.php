<?php

namespace App\Mail;

use App\Models\Mails;
use Illuminate\Mail\Mailable;

class GeneralMail extends Mailable
{
    public $data;

    public function __construct($customData)
    {
        $this->data = $customData;
    }

    public function build()
    {
        $insertData = array(
            "mailToEmail" => implode(",", $this->data["toEmail"]),
            "mailToName" => $this->data["name"],
            "mailFromName"=> $this->data["fromName"],
            "mailFromEmail"=> $this->data["fromEmail"],
            "mailSubject" => $this->data["subject"],
            "mailContent" => $this->data["body"],
            "mailType" => "1",
        );
        Mails::insert($insertData);
        return $this->from($this->data["fromEmail"], $this->data["fromName"])->subject($this->data["subject"])
            ->view('emails.general');
    }
}
