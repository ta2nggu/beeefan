<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurlController extends Controller
{
    public function __construct()
    {

    }

    public static function postCurl() {
        $curl=curl_init();
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_URL, 'https://pt01.mul-pay.jp/payment/EntryTran.idPass' );
        $param = [
            'ShopID'       => 'ADMINISTRATOR',//'YourShopId',
            'ShopPass'     => 'Kg3uqNF9?',//'YourShopPassword',
            'OrderID'      => 'A001',//'Orderid',
            'JobCd'        => 'AUTH',
            //'ItemCode'     => '0000990',
            'Amount'       => '100',
            'Tax'          => '0',//'10',
            'TdFlag'       => '1',
            //'TdTenantName' => 'YourTenantName',
            'Tds2Type'     => '1'
        ];
        // リクエストボディの生成
        curl_setopt( $curl, CURLOPT_POSTFIELDS, http_build_query( $param ) );

        // リクエスト送信
        $response = curl_exec( $curl );
        $curlinfo = curl_getinfo( $curl );
        curl_close( $curl );

        // レスポンスチェック
        if( $curlinfo[ 'http_code' ] != 200 ){
            // エラー
            return false;
        }

        // レスポンスのエラーチェック
        parse_str( $response, $data );
        if( array_key_exists( 'ErrCode', $data ) ){
            // エラー
            return false;
        }

        // 正常
        return true;
    }

    public static function getCurl($host, $url) {
        $ch = curl_init($host . $url);

        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
