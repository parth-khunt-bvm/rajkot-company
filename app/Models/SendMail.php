<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
class SendMail extends Model
{
    use HasFactory;

    public function sendMailltesting(){
        $mailData['data']=[];
        $mailData['data']['firstName']='Hello, Welcome to BVM infotech.';
        $mailData['subject'] = "Testing Mail";
        $mailData['attachment'] = array();
        $mailData['template'] ="emailtemplate.test";
        $mailData['mailto'] = 'hil.bvminfotech@gmail.com';
        $sendMail = new Sendmail();
        return $sendMail->sendSMTPMail($mailData);
    }

    public function sendSMTPMail($mailData)
    {
        $pathToFile = $mailData['attachment'];

        $mailsend = Mail::send($mailData['template'], ['data' => $mailData['data']], function ($m) use ($mailData,$pathToFile) {
            $m->from('info@hrms.bvminfotech.com', 'BVM Infotech || HRMS');
            $m->to($mailData['mailto'], "BVM Infotech || HRMS")->subject($mailData['subject']);
            $m->subject($mailData['subject']);
        });
        if($mailsend){
            return true;
        }else{
            return false;
        }
    }
}
