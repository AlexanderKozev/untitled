<?php
class ApiCest 
{    
    public function tryApi1(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGet('/mnogopay/s/purchase',[]);
        $I->seeResponseCodeIs(502);
    }
    public function tryApi2(ApiTester $I)
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
    public function tryApi3(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPut('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(502);
        $I->seeResponseIsJson();
    }
    public function tryApi4(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendDelete('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(502);
        $I->seeResponseIsJson();
    }
    public function tryApi5(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>-1,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"111","message":"Incorrect parameter in request amount: -1"}');
    }
    public function tryApi6(ApiTester $I)
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
    public function tryApi7(ApiTester $I)
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
    public function tryApi8(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>32768,"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"333","message":"It is too much amount"}');
    }
    public function tryApi9(ApiTester $I)
    {
        $I->haveHttpHeader('secret', 'QWERTY000097531KEY');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>'abc',"currency"=>"RUB", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"resp_code":"111","message":"Incorrect parameter in request amount: abc"}');
    }
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
    public function tryApi22(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/mnogopay/s/purchase',[ "amount"=>123,"currency"=>"123", "order_id"=>"NTS123",
            "phone"=>88001234578, "description"=>"abc"]);
        $I->seeResponseCodeIs(403);

    }
}