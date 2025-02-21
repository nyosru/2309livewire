<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\PhpcatAiToken;

class AiController extends Controller
{

    public $ai_name = 'yandex';

    public function sendMsg(string $msg = ''): array
    {
        $t = $this->checkToken();
        $iamToken = $t['data']['token'];

        $folderId = "b1gisgakd83ng7j5dg41";  // Узнать можно в Yandex Cloud
        $url = "https://llm.api.cloud.yandex.net/foundationModels/v1/completion";

        $data = json_encode([
            "modelUri" => 'gpt://' . $folderId . '/yandexgpt-lite',
            "completionOptions" => ["stream" => false, "temperature" => 0.3, "maxTokens" => 100],
            "messages" => [
                [
                    "role" => "user",
                    "text" => $msg ?? $this->msg
//                    "text" => "Какую услугу ищет человек: 'надо установить ванну' , название услуги или услуг напиши только название"
                ]
            ]
        ]);

        $options = [
            "http" => [
                "header" => [
                    "Authorization: Bearer $iamToken",
                    "x-folder-id: $folderId",
                    "Content-Type: application/json"
                ],
                "method" => "POST",
                "content" => $data,
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $r = json_decode($response, true);

        return $r;
    }


    /**
     * проверить токеен есть нет и если нет, запускаем егополулчение и  сохраняем
     * @return void
     */
    public function checkToken(): array
    {
        $return = [
            'status' => true,
            'renew' => false,
            'data' => ['token' => ''],
        ];

        try {
            $t = PhpcatAiToken::where('name', $this->ai_name)
                ->where('expires_at', '>', now())
//                ->select('value')
                ->firstOrFail();
            $return['data']['token'] = $t->value;
            $return['data']['token_expires'] = date('d.m.Y H:i',strtotime($t->expires_at));
        } catch (\Exception $e) {
            $token_new = $this->getToken();
            if (!empty($token_new)) {
                $new = PhpcatAiToken::storeToken($this->ai_name, $token_new);
                $return['renew'] = true;
                $return['data']['token'] = $token_new;
                $return['data']['token_expires'] = date('d.m.Y H:i',strtotime($new->expires_at));
                $return['data']['new'] = $new;
            } else {
                $return['renew'] = true;
                $return['status'] = false;
            }
        }

        return $return;
    }

    public function getToken()
    {
        $apiKey = config('custom.YANDEX_OAUTH');
        $url = "https://iam.api.cloud.yandex.net/iam/v1/tokens";

        $data = json_encode(["yandexPassportOauthToken" => $apiKey]);

        $options = [
            "http" => [
                "header" => "Content-Type: application/json",
                "method" => "POST",
                "content" => $data,
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $result = json_decode($response, true);

//        dd("IAM-токен: " . $result["iamToken"]);
        return $result["iamToken"] ?? null;
    }

}
