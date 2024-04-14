<?php

namespace App\Http\Controllers;

use App\Models\Mails;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Webklex\IMAP\Facades\Client;

class MailController extends BaseController
{
    public function loadInbox()
    {
        if (Session::has('user'))
            return view('inbox');
        else
            return redirect()->route('login');
    }

    public function loadMail($mailId)
    {
        if (Session::has('user'))
            return view('mail');
        else
            return redirect()->route('login');
    }

    public function loadOutbox()
    {
        if (Session::has('user'))
            return view('sent');
        else
            return redirect()->route('login');
    }

    public function loadCompose()
    {
        if (Session::has('user'))
            return view('compose');
        else
            return redirect()->route('login');
    }

    public function getInboundEmails()
    {
        $client = Client::make([
            'host'          => config('imap.accounts.default.host'),
            'port'          => config('imap.accounts.default.port'),
            'encryption'    => config('imap.accounts.default.encryption'),
            'validate_cert' => config('imap.accounts.default.validate_cert'),
            'username'      => config('imap.accounts.default.username'),
            'password'      => config('imap.accounts.default.password'),
            'protocol'      => config('imap.accounts.default.protocol'),
        ]);

        $client->connect();
        $folder = $client->getFolder('INBOX');
        $messages = $folder->query()->unseen()->get();

        foreach ($messages as $message) {
            $details = array(
                "mailToEmail" => $message->getTo()[0]->mail,
                "mailToName" => $message->getTo()[0]->personal ?? $message->getTo()[0]->mailbox,
                "mailFromEmail" => $message->getFrom()[0]->mail,
                "mailFromName" => $message->getFrom()[0]->personal,
                "mailSubject" => $message->getSubject(),
                "mailContent" => $message->getHTMLBody(),
                "mailType" => "0",
                "mailTime" => $message->getdate()[0]->format("Y-m-d H:i:s"),
                "mailIsDeleted" => "0",
                "mailIsRead" => "0"
            );
            Mails::insert($details);
            $message->setFlag('SEEN');
        }
        $client->disconnect();

        return response()->json(['message' => 'Emails retrieved successfully.']);
    }
}
