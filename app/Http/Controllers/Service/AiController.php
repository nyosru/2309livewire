<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiController extends Controller
{

    public function sendMsg(string $msg = ''): array
    {
        $r = [];

        //    $iamToken = "ТВОЙ_IAM_ТОКЕН";
        $iamToken = config('custom.YANDEX_IAM');;
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

//        echo '<pre>';
//        print_r($result);
        return $r;
    }


//$question
//route::get('ai02', function ($q = '')
//{
////    $iamToken = "ТВОЙ_IAM_ТОКЕН";
//    $iamToken = config('custom.YANDEX_IAM');;
////    $folderId = "ТВОЙ_FOLDER_ID";  // Узнать можно в Yandex Cloud
////    $folderId = "ТВОЙ_FOLDER_ID";  // Узнать можно в Yandex Cloud
////    $folderId = "b1g81ovj0g4nvsa6sc61";  // Узнать можно в Yandex Cloud
////    $folderId = "b1ggvlsblhdgca8636dh";  // Узнать можно в Yandex Cloud
//    $folderId = "b1gisgakd83ng7j5dg41";  // Узнать можно в Yandex Cloud
////    $folderId = "aje6h4hf263b6cmo9qej";  // Узнать можно в Yandex Cloud
////    $folderId = "b1g81ovj0g4nvsa6sc61";  // Узнать можно в Yandex Cloud
//    $url = "https://llm.api.cloud.yandex.net/foundationModels/v1/completion";
//
//    $data = json_encode([
////        "modelUri" => "gpt://b1g88f00xgpt/ru/latest",
//        "modelUri" => 'gpt://' . $folderId . '/yandexgpt-lite',
//        "completionOptions" => ["stream" => false, "temperature" => 0.3, "maxTokens" => 100],
//        "messages" => [
//            [
//                "role" => "user",
//                "text" => "Какую услугу ищет человек: 'надо установить ванну' , название услуги или услуг напиши только название"
//            ]
//        ]
//    ]);
//
//    $options = [
//        "http" => [
//            "header" => [
//                "Authorization: Bearer $iamToken",
//                "x-folder-id: $folderId",
//                "Content-Type: application/json"
//            ],
//            "method" => "POST",
//            "content" => $data,
//        ]
//    ];
//
//    $context = stream_context_create($options);
//    $response = file_get_contents($url, false, $context);
//    $result = json_decode($response, true);
//
//    echo '<pre>';
//    print_r($result);
//});

//получение токена
//route::get('ai01', function ($q = '')
//{
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

    dd( "IAM-токен: " . $result["iamToken"] );
}
//});


//всякая дичь
//
//route::get('ai2', function ($q = '')
//{
//    $response = Http::withHeaders([
//        'Authorization' => config('custom.AI_HUGFACE_TOKEN'),
////    ])->post('https://api-inference.huggingface.co/models/YOUR_MODEL_NAME', [
////    ])->post('https://api-inference.huggingface.co/models/deepseek-ai/DeepSeek-R1', [
//    ])->post('https://api-inference.huggingface.co/models/facebook/bart-large-mnli', [
//        'inputs' => 'Какая услуга нужна тому кто написал такой запрос "Хочу установить ванну, нужно всё сделать в короткие сроки, третий этаж", напиши название услуги без знаков препинания, или несколько услуг из сообщения разделённых запятой',
//    ]);
//
//    if ($response->successful()) {
//        $data = $response->json();
//        // Обработка ответа
//        dd($data);
//    } else {
//        // Обработка ошибки
//        dd($response->status(), $response->body());
//    }
//});
//route::get('ai/{question?}', [\App\Http\Controllers\AiHugFaceController::class, 'getAnswer']);

}
