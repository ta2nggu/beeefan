<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurlController extends Controller
{
    public function __construct()
    {

    }

    public function postCurl() {
        $ORD = 'A015';

        $curl=curl_init();
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_URL, 'https://pt01.mul-pay.jp/payment/EntryTran.idPass' );
        $param = [
            'ShopID'       => 'tshop00050389',//'YourShopId',
            'ShopPass'     => '67knmfpc',//'YourShopPassword',
            'OrderID'      => $ORD,//'A009',//'Orderid',
            'JobCd'        => 'AUTH',
            //'ItemCode'     => '0000990',
            'Amount'       => '30',
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

//        return dd($data['AccessPass']);AccessID

        // 正常
        //return true;
        $this->pay($ORD, $data['AccessID'], $data['AccessPass']);
    }

    public function pay($ORD, $ID, $PASS) {
        // リクエストコネクションの設定
        $curl=curl_init();
        curl_setopt( $curl, CURLOPT_POST, true );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $curl, CURLOPT_URL, 'https://pt01.mul-pay.jp/payment/ExecTran.idPass' );
        // 本人認証サービス使用,トークン使用時
        $param = [
            'AccessID'        => $ID,//'SampleAccessID',
            'AccessPass'      => $PASS,//'SampleAccessPass',
            'OrderID'         => $ORD,//'SampleOrderID',
            'Method'          => '2',
            'PayTimes'        => '2',//'2',
            //'Token'           => 'SampleToken',
            //'HttpAccept'      => 'SampleHttpAccept',
            //'HttpUserAgent'   => 'HttpUserAgent',
            //'DeviceCategory'  => '0',
            //'ClientField1'    => 'SampleClientField1',
            //'ClientField2'    => 'SampleClientField2',
            //'ClientField3'    => 'SampleClientField3',

            'CardNo' => '5461122021371243',
            'Expire' => '2303',

            'ClientFieldFlag' => '0',
            'TokenType'       => '1',
            'RetUrl'          => 'https://google.com',//'https://example.com/xxxxx'
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
            return dd($data);
            return false;
        }

        return dd($data);

        // 正常
        return true;
    }
}
