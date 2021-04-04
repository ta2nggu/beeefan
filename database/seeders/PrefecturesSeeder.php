<?php

namespace Database\Seeders;

use App\Models\Prefecture;
use Illuminate\Database\Seeder;

class PrefecturesSeeder extends Seeder
{
    protected $prefs = [
        [
            "id" => 1,
            "name" => "北海道",
            "kana" => "ホッカイドウ",
        ],
        [
            "id" => 2,
            "name" => "青森県",
            "kana" => "アオモリケン",
        ],
        [
            "id" => 3,
            "name" => "岩手県",
            "kana" => "イワテケン",
        ],
        [
            "id" => 4,
            "name" => "宮城県",
            "kana" => "ミヤギケン",
        ],
        [
            "id" => 5,
            "name" => "秋田県",
            "kana" => "アキタケン",
        ],
        [
            "id" => 6,
            "name" => "山形県",
            "kana" => "ヤマガタケン",
        ],
        [
            "id" => 7,
            "name" => "福島県",
            "kana" => "フクシマケン",
        ],
        [
            "id" => 8,

            "name" => "茨城県",
            "kana" => "イバラキケン",
        ],
        [
            "id" => 9,
            "name" => "栃木県",
            "kana" => "トチギケン",
        ],
        [
            "id" => 10,
            "name" => "群馬県",
            "kana" => "グンマケン",
        ],
        [
            "id" => 11,
            "name" => "埼玉県",
            "kana" => "サイタマケン",
        ],
        [
            "id" => 12,
            "name" => "千葉県",
            "kana" => "チバケン",
        ],
        [
            "id" => 13,
            "name" => "東京都",
            "kana" => "トウキョウト",
        ],
        [
            "id" => 14,
            "name" => "神奈川県",
            "kana" => "カナガワケン",
        ],
        [
            "id" => 15,
            "name" => "新潟県",
            "kana" => "ニイガタケン",
        ],
        [
            "id" => 16,
            "name" => "富山県",
            "kana" => "トヤマケン",
        ],
        [
            "id" => 17,
            "name" => "石川県",
            "kana" => "イシカワケン",
        ],
        [
            "id" => 18,
            "name" => "福井県",
            "kana" => "フクイケン",
        ],
        [
            "id" => 19,
            "name" => "山梨県",
            "kana" => "ヤマナシケン",
        ],
        [
            "id" => 20,
            "name" => "長野県",
            "kana" => "ナガノケン",
        ],
        [
            "id" => 21,
            "name" => "岐阜県",
            "kana" => "ギフケン",
        ],
        [
            "id" => 22,
            "name" => "静岡県",
            "kana" => "シズオカケン",
        ],
        [
            "id" => 23,
            "name" => "愛知県",
            "kana" => "アイチケン",
        ],
        [
            "id" => 24,
            "name" => "三重県",
            "kana" => "ミエケン",
        ],
        [
            "id" => 25,
            "name" => "滋賀県",
            "kana" => "シガケン",
        ],
        [
            "id" => 26,
            "name" => "京都府",
            "kana" => "キョウトフ",
        ],
        [
            "id" => 27,
            "name" => "大阪府",
            "kana" => "オオサカフ",
        ],
        [
            "id" => 28,
            "name" => "兵庫県",
            "kana" => "ヒョウゴケン",
        ],
        [
            "id" => 29,
            "name" => "奈良県",
            "kana" => "ナラケン",
        ],
        [
            "id" => 30,
            "name" => "和歌山県",
            "kana" => "ワカヤマケン",
        ],
        [
            "id" => 31,
            "name" => "鳥取県",
            "kana" => "トットリケン",
        ],
        [
            "id" => 32,
            "name" => "島根県",
            "kana" => "シマネケン",
        ],
        [
            "id" => 33,
            "name" => "岡山県",
            "kana" => "オカヤマケン",
        ],
        [
            "id" => 34,
            "name" => "広島県",
            "kana" => "ヒロシマケン",
        ],
        [
            "id" => 35,
            "name" => "山口県",
            "kana" => "ヤマグチケン",
        ],
        [
            "id" => 36,
            "name" => "徳島県",
            "kana" => "トクシマケン",
        ],
        [
            "id" => 37,
            "name" => "香川県",
            "kana" => "カガワケン",
        ],
        [
            "id" => 38,
            "name" => "愛媛県",
            "kana" => "エヒメケン",
        ],
        [
            "id" => 39,
            "name" => "高知県",
            "kana" => "コウチケン",
        ],
        [
            "id" => 40,
            "name" => "福岡県",
            "kana" => "フクオカケン",
        ],
        [
            "id" => 41,
            "name" => "佐賀県",
            "kana" => "サガケン",
        ],
        [
            "id" => 42,
            "name" => "長崎県",
            "kana" => "ナガサキケン",
        ],
        [
            "id" => 43,
            "name" => "熊本県",
            "kana" => "クマモトケン",
        ],
        [
            "id" => 44,
            "name" => "大分県",
            "kana" => "オオイタケン",
        ],
        [
            "id" => 45,
            "name" => "宮崎県",
            "kana" => "ミヤザキケン",
        ],
        [
            "id" => 46,
            "name" => "鹿児島県",
            "kana" => "カゴシマケン",
        ],
        [
            "id" => 47,
            "name" => "沖縄県",
            "kana" => "オキナワケン",
        ],
        [
            "id" => 48,
            "name" => "国外",
            "kana" => "コクガイ",
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->prefs as $pref) {
            Prefecture::create($pref);
        }
    }
}
