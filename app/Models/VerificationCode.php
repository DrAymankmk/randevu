<?php

namespace App\Models;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Twilio\Rest\Client;

class VerificationCode extends Model
{
    use HasFactory;

    public $fillable = ['phone', 'type_verify', 'status', 'expired_at', 'code','user_id'];

    public static function send_code_old($key,$value, $code, $input)
    {
        $message = "مرحبًا بك في تطبيق تكافل ✅\nكود التفعيل الخاص بك هو: *$code*\nيرجى عدم مشاركة هذا الكود مع أي شخص.";
        $params = array(
            'token' => 'mrmm9ckrsa8ojdef',
            'to' => '+966'.$value,
            'body' => $message
        );
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance78179/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            echo $response;
//        }
    }


   static function send_code_from_twillo($phone, $code, $input)
    {
        $accountSid = config('services.twilio.sid', env('TWILIO_ACCOUNT_SID'));
        $authToken = config('services.twilio.token', env('TWILIO_AUTH_TOKEN'));
        $twilioNumber = config('services.twilio.from', env('TWILIO_FROM'));

        if (!$accountSid || !$authToken || !$twilioNumber) {
            throw new InvalidArgumentException('Twilio credentials are missing. Configure TWILIO_SID, TWILIO_TOKEN, and TWILIO_FROM.');
        }
        $phone = $input->country_code .' ' . $phone;
        $client = new Client($accountSid, $authToken);
        $message = $client->messages->create(
            "$phone",
            array(
                'from' => $twilioNumber,
//                'from' => 'Randevu',
                'body' => 'رمز تعريفك الخاص ب رانديفو هو  : ' . $code
            )
        );
        return $message;

    }
    public static function verificationCode($phone, $code)
    {
        $appId = config('services.fourjawaly.app_id');
        $appSecret = config('services.fourjawaly.app_secret');
        $sender = config('services.fourjawaly.sender');
        $url = config('services.fourjawaly.url', 'https://api-sms.4jawaly.com/api/v1/account/area/sms/send');

        if (!$appId || !$appSecret) {
            throw new InvalidArgumentException('4Jawaly credentials are missing. Configure FOURJAWALY_APP_ID and FOURJAWALY_APP_SECRET.');
        }

        if (!$sender) {
            throw new InvalidArgumentException('4Jawaly sender is missing. Configure FOURJAWALY_SENDER with a sender name approved in your 4Jawaly account.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($appId . ':' . $appSecret),
        ])
            ->acceptJson()
            ->asJson()
            ->timeout(config('services.fourjawaly.timeout', 30))
            ->post($url, [
                'messages' => [
                    [
                        'text' => 'Verification code is ' . $code,
                        'numbers' => [(string) $phone],
                        'sender' => $sender,
                    ],
                ],
            ]);

        if ($response->failed()) {
            $error = $response->json();
            $message = is_array($error) && isset($error['message'])
                ? $error['message']
                : $response->body();

            if (is_array($error) && !empty($error['missing_senders'])) {
                $message .= ' Missing senders: ' . implode(', ', $error['missing_senders']);
            }

            throw new RuntimeException('4Jawaly SMS request failed with status ' . $response->status() . ': ' . $message);
        }

        return $response->json() ?? $response->body();

    }


}
