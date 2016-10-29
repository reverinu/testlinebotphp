<?php
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');
//���[�U�[����̃��b�Z�[�W�擾
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);
$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//���b�Z�[�W�擾
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//ReplyToken�擾
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
//���b�Z�[�W�ȊO�̂Ƃ��͉����Ԃ����I��
if($type != "text"){
	exit;
}
//�ԐM�f�[�^�쐬
if ($text == '�͂�') {
  $response_format_text = [
    "type" => "template",
    "altText" => "������́Z�Z�͂������ł����H",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
      "title" => "�������X�g����",
      "text" => "���T���̃��X�g�����͂���ł���",
      "actions" => [
          [
            "type" => "postback",
            "label" => "�\�񂷂�",
            "data" => "action=buy&itemid=123"
          ],
          [
            "type" => "postback",
            "label" => "�d�b����",
            "data" => "action=pcall&itemid=123"
          ],
          [
            "type" => "message",
            "label" => "�Ⴍ�Ȃ����",
            "text" => "�Ⴄ����肢"
          ]
      ]
    ]
  ];
} else if ($text == '������') {
  exit;
} else if ($text == '�Ⴄ����肢') {
  $response_format_text = [
    "type" => "template",
    "altText" => "�����R���ē����Ă��܂��B",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
            "title" => "�������X�g����",
            "text" => "������ɂ��܂����H",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "�\�񂷂�",
                  "data" => "action=rsv&itemid=111"
              ],
              [
                  "type" => "postback",
                  "label" => "�d�b����",
                  "data" => "action=pcall&itemid=111"
              ],
              [
                  "type" => "uri",
                  "label" => "�ڂ�������i�u���E�U�N���j",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
            "title" => "�������X�g����",
            "text" => "����Ƃ�������H�i�Q�ځj",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "�\�񂷂�",
                  "data" => "action=rsv&itemid=222"
              ],
              [
                  "type" => "postback",
                  "label" => "�d�b����",
                  "data" => "action=pcall&itemid=222"
              ],
              [
                  "type" => "uri",
                  "label" => "�ڂ�������i�u���E�U�N���j",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
            "title" => "�������X�g����",
            "text" => "�͂��܂�������H�i�R�ځj",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "�\�񂷂�",
                  "data" => "action=rsv&itemid=333"
              ],
              [
                  "type" => "postback",
                  "label" => "�d�b����",
                  "data" => "action=pcall&itemid=333"
              ],
              [
                  "type" => "uri",
                  "label" => "�ڂ�������i�u���E�U�N���j",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ]
      ]
    ]
  ];
} else if ($text == '1d100') {
	$random = rand(1,100);
	$response_format_text = [
		"type" => "text",
		"text" => $random
	];
} else {
  $response_format_text = [
    "type" => "template",
    "altText" => "����ɂ��� �������p�ł����H�i�͂��^�������j",
    "template" => [
        "type" => "confirm",
        "text" => "����ɂ��� �������p�ł����H ���p�ł���ˁH",
        "actions" => [
            [
              "type" => "message",
              "label" => "�͂�",
              "text" => "�͂�"
            ],
            [
              "type" => "message",
              "label" => "������",
              "text" => "������"
            ]
        ]
    ]
  ];
}
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