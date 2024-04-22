<?php

namespace App\Http\Controllers;

use App\Mail\GeneralMail;
use App\Models\Mails;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Webklex\IMAP\Facades\Client;

class MailController extends BaseController
{
    public function loadInbox()
    {
        if (Session::has('user')) {
            $mailData = Mails::select("mailId", "mailFromEmail", "mailFromName", "mailSubject", "mailTime")->where("mailType", "0")->where("mailIsDeleted", "0")->get();

            return view('inbox', compact("mailData"));
        } else
            return redirect()->route('login');
    }

    public function loadMail($mailId)
    {
        if (Session::has('user'))
            return view('mail', compact("mailId"));
        else
            return redirect()->route('login');
    }

    public function loadOutbox()
    {
        if (Session::has('user')) {
            $mailData = Mails::select("mailId", "mailFromEmail", "mailFromName", "mailSubject", "mailTime")->where("mailType", "1")->where("mailIsDeleted", "0")->get();

            return view('sent', compact("mailData"));
        } else
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

    public function sendMail(Request $request)
    {
        $toEmail = $request->input("toEmail");
        $toName = $request->input("toName");
        $mailSubject = $request->input("mailSubject");
        $mailBody = $request->input("mailBody");

        $customData = array(
            "subject" => $mailSubject,
            "referrer" => "Dear",
            "name" => $toName,
            "toEmail" => $toEmail,
            "fromEmail" => session("user")->userEmail,
            "fromName" => session("user")->userFirstName . " " . session("user")->userLastName . " | The Tech Packs",
            "body" => $mailBody,
        );
        // return view('emails.general', compact("customData"));
        Mail::to($toEmail)->send(new GeneralMail($customData));

        return redirect()->route('outbox')->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    public function loadMailBody($mailId) {
        $body = Mails::select("mailContent")->where("mailId", $mailId)->get();
        return view('mailBody', compact("body"));
    }
}
