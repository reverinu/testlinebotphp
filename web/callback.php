<?php



$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
$secret = "3095c84a53d38913b6716fb770f3f326";

//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//メッセージ取得
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//ReplyToken取得
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

$join = $jsonObj->{"events"}[0]->{"type"};


//メッセージ以外のときは何も返さず終了
if($type != "text"){
	exit;
}

if($join == 'join'){
	$response_format_text = [
		"type" => "text",
		"text" => "でゅふふふふ"
	];
}


if ($text == '@help') {
	$response_format_text = [
		"type" => "text",
		"text" => "ヘルプ\nヘルプだよ"
	];
} else if ($text == '@join') {
	$response_format_text = [
		"type" => "text",
		"text" => "ゲームに参加登録したよ！準備が出来たらグループの方で@startって言ってね！"
	];
} else if ($text == '@start') {
	$response_format_text = [
		"type" => "text",
		"text" => "ワオーーーン\n\n\n狼の遠吠えが聞こえる…\n\n夜時間です。各自行動をしてください。"
	];
} else if ($text == '@rule') {
	$response_format_text = [
		"type" => "text",
		"text" => "ワンナイト人狼ルール説明\n\nある日、あなたたちの住んでいる村に狼がいるといううわさが流れてきた。\nこの村は人が１０人にも満たなくて、１日以内に人狼を探し出さないといけない！\n\n村陣営勝利条件：人狼を吊ること\n狼陣営勝利条件：人狼以外を吊ること"
	];
} else if ($text == '@skip') {
	$response_format_text = [
		"type" => "text",
		"text" => "時間をスキップしたよ。\n昼時間になりました。この中に人狼が居ます。議論して探してください"
	];
} else if ($text == '@haiyaku') {
	$response_format_text = [
    "type" => "template",
    "altText" => "あなたは狂人です",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/kyojin.jpeg",
      "title" => "あなたの役職",
      "text" => "あなたは狂人です。",
      "actions" => [
          [
            "type" => "message",
            "label" => "了解",
            "text" => "了解"
          ]
      ]
    ]
  ];
} else if ($text == '@vote') {
	$response_format_text = [
    "type" => "template",
    "altText" => "だれに投票する？",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/jinro.jpeg",
      "title" => "投票",
      "text" => "だれに投票する？",
      "actions" => [
          [
            "type" => "message",
            "label" => "川犬(kawaken)",
            "text" => "川犬(kawaken)"
          ],
          [
            "type" => "message",
            "label" => "石井翼",
            "text" => "石井翼"
          ]
      ]
    ]
  ];
}


/*
//返信データ作成
if ($text == 'はい') {
  $response_format_text = [
    "type" => "template",
    "altText" => "こちらの〇〇はいかがですか？",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
      "title" => "○○レストラン",
      "text" => "お探しのレストランはこれですね",
      "actions" => [
          [
            "type" => "postback",
            "label" => "予約する",
            "data" => "action=buy&itemid=123"
          ],
          [
            "type" => "postback",
            "label" => "電話する",
            "data" => "action=pcall&itemid=123"
          ],
          [
            "type" => "message",
            "label" => "違くないやつ",
            "text" => "違うやつお願い"
          ]
      ]
    ]
  ];
} else if ($text == 'いいえ') {
  exit;
} else if ($text == '違うやつお願い') {
  $response_format_text = [
    "type" => "template",
    "altText" => "候補を３つご案内しています。",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
            "title" => "●●レストラン",
            "text" => "こちらにしますか？",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "予約する",
                  "data" => "action=rsv&itemid=111"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=111"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
            "title" => "▲▲レストラン",
            "text" => "それともこちら？（２つ目）",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "予約する",
                  "data" => "action=rsv&itemid=222"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=222"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
            "title" => "■■レストラン",
            "text" => "はたまたこちら？（３つ目）",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "予約する",
                  "data" => "action=rsv&itemid=333"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=333"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ]
      ]
    ]
  ];
} else if ($text == '1d1000') {
	$random = rand(1,100);
	$response_format_text = [
		"type" => "text",
		"text" => $random
	];
} else {
  $response_format_text = [
    "type" => "template",
    "altText" => "hello",
    "template" => [
        "type" => "confirm",
        "text" => "hello",
        "actions" => [
            [
              "type" => "message",
              "label" => "YES",
              "text" => "はい"
            ],
            [
              "type" => "message",
              "label" => "NO",
              "text" => "NO"
            ]
        ]
    ]
  ];
}
*/
$post_data = [
	"replyToken" => $replyToken,
	"messages" => [$response_format_text]
	];
$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
    ));
$result = curl_exec($ch);
curl_close($ch);