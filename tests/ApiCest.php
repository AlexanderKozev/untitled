<?php
class ApiCest 
{   /* Const */
    Const ResponseError = "Notice: Undefined index: secret in /opt/app-root/src/mock/paysys/mnogopay/s/main.php on line 200\nIncorrect secret key";
    /* Cases */
    //Запрос GET
    public function tryApi01(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/mnogopay/s/purchase',[]);
        $I->seeResponseCodeIs(502);
    }
    //Запрос POST с валидными данными
    public function tryApi02(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $date = date('YmdHi',strtotime('-3 hours'));
        $I->seeResponseContainsJson([
            'payment_id' => "payment_$date",
            'order_id' => 'NTS123',
            'resp_code' => '000'
        ]);
    }
    //Запрос PUT  с валидными данными
    public function tryApi03(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(502);
        $I->seeResponseIsJson();
    }
    //Запрос DELETE с валидными данными
    public function tryApi04(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(502);
        $I->seeResponseIsJson();
    }
    //Запрос POST со значением amount -1
    public function tryApi05(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>-1,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"111","message":"Incorrect parameter in request amount: -1"}');
    }
    //Запрос POST со значением amount 0
    public function tryApi06(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>0,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $date = date('YmdHi',strtotime('-3 hours'));
        $I->seeResponseContainsJson([
            'payment_id' => "payment_$date",
            'order_id' => 'NTS123',
            'resp_code' => '000'
        ]);
    }
    //Запрос POST со значением amount 32767
    public function tryApi07(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>32767,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $date = date('YmdHi',strtotime('-3 hours'));
        $I->seeResponseContainsJson([
            'payment_id' => "payment_$date",
            'order_id' => 'NTS123',
            'resp_code' => '000'
        ]);
    }
    //Запрос POST со значением amount 32768
    public function tryApi08(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>32768,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"333","message":"It is too much amount"}');
    }
    //Запрос POST со значением amount ABC
    public function tryApi09(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>'abc',"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"111","message":"Incorrect parameter in request amount: abc"}');
    }
    //Запрос POST пустым значением amount
    public function tryApi10(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>'',"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"222","message":"Required parameter is absent: amount"}');
    }
    //Запрос POST со значением currency USD
    public function tryApi11(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"USD", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"111","message":"Incorrect parameter in request currency: USD"}');
    }
    //Запрос POST с пустым значением currency
    public function tryApi12(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"222","message":"Required parameter is absent : currency"}');
    }
    //Запрос POST со значением currency ABC
    public function tryApi13(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"abc", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"111","message":"Incorrect parameter in request currency: abc"}');
    }
    //Запрос POST со значением currency 123
    public function tryApi14(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"123", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"111","message":"Incorrect parameter in request currency: 123"}');
    }
    //Запрос POST со значением order_id 1
    public function tryApi15(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"1",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $date = date('YmdHi',strtotime('-3 hours'));
        $I->seeResponseContainsJson([
            'payment_id' => "payment_$date",
            'order_id' => '1',
            'resp_code' => '000'
        ]);
    }
    //Запрос POST со значением order_id NTS12345678912345  (17 символов)
    public function tryApi16(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"123", "order_id"=>"NTS12345678912345",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"111","message":"Incorrect parameter in request order_id: NTS12345678912345"}');
    }
    //Запрос POST со значением order_id 1234567891234  (16 символов)
    public function tryApi17(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS1234567891234",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $date = date('YmdHi',strtotime('-3 hours'));
        $I->seeResponseContainsJson([
            'payment_id' => "payment_$date",
            'order_id' => 'NTS1234567891234',
            'resp_code' => '000'
        ]);
    }
    //Запрос POST с пустым значением order_id
    public function tryApi18(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"123", "order_id"=>"",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"222","message":"Required parameter is absent : order_id"}');
    }
    //Запрос POST со значением discription 1
    public function tryApi19(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS1234567891234",
            "phone"=>88001234578, "description"=>"1"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $date = date('YmdHi',strtotime('-3 hours'));
        $I->seeResponseContainsJson([
            'payment_id' => "payment_$date",
            'order_id' => 'NTS1234567891234',
            'resp_code' => '000',
            'description' => '1'
        ]);
    }
    //Запрос POST со значением discription 33 символа
    public function tryApi20(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS1234567891234",
            "phone"=>88001234578, "description"=>"123456789012345678901234567890123"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $date = date('YmdHi',strtotime('-3 hours'));
        $I->seeResponseContainsJson([
            'payment_id' => "payment_$date",
            'order_id' => 'NTS1234567891234',
            'resp_code' => '000',
            'description' => '123456789012345678901234567890123'
        ]);
    }
    //Запрос POST с пустым значением discription
    public function tryApi21(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS1234567891234",
            "phone"=>88001234578, "description"=>""]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $date = date('YmdHi',strtotime('-3 hours'));
        $I->seeResponseContainsJson([
            'payment_id' => "payment_$date",
            'order_id' => 'NTS1234567891234',
            'resp_code' => '000',
            'description' => ''
        ]);
    }
    //Запрос POST без секретного ключа
    public function tryApi22(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"123", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(403);
        $I->seeResponseContains(self::ResponseError);

    }
}