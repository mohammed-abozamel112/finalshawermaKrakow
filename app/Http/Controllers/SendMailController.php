<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;

class SendMailController extends Controller
{
    public function index(Request $request)
    {
        return response()->json('email send');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $mail = new PHPMailer(true);

        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'subject' => 'string',
                'message' => 'string',
            ]);
            /*  $request->name = $name;
             $request->email = $email; */
            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $message = $request->message;

            /* Email SMTP Settings */
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'e0c0f50ac65c00';
            $mail->Password = '08b708e0285e16';


            //Recipients
            $mail->setFrom($email, $name);
            $mail->addAddress(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = $message;


            if (!$mail->send()) {
                return response()->json([
                    "error",
                    "Email not sent.",
                ]);
            } else {
                return response()->json([
                    "success",
                    "Email has been sent."
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'error',
                'Message could not be sent.',
            ]);
        }
    }
}
