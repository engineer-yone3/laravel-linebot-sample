<?php

namespace Tests\Feature\Api\Line;

use App\Models\LineFriend;
use Illuminate\Support\Facades\DB;
use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use LINE\LINEBot\Response as LineResponse;
use Tests\TestCase;

class LineBotControllerTest extends TestCase
{
    private $setUpOnce = false;

    public function setUp(): void
    {
        parent::setUp();

        if (!$this->setUpOnce) {
            // $this->artisan('migrate:fresh', ['--env' => 'testing']);
            $this->setUpOnce = true;
        }
        DB::table('line_friends')->truncate();

        $mock = Mockery::mock('alias:' . SignatureValidator::class);
        $mock->shouldReceive('validateSignature')
            ->once()
            ->andReturn(true);
        
        $mockResponse = new LineResponse(200, '');
        $replyTextMock = Mockery::mock(LINEBot::class);
        $replyTextMock->shouldReceive('replyText')
            ->once()
            ->andReturn($mockResponse);
        
        $replyMessageMock = Mockery::mock(LINEBot::class);
        $replyMessageMock->shouldReceive('replyMessage')
            ->once()
            ->andReturn($mockResponse);
    }

    /**
     * @test
     * @dataProvider sendFollowEventData
     */
    public function LINEコールバックを呼び出しHTTPステータス200が返ってくる($data)
    {
        $response = $this->postJson(route('line.callback'), $data, [HTTPHeader::LINE_SIGNATURE => 'aaaaa']);
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     * @dataProvider sendFollowEventData
     */
    public function 友達登録イベント処理後テーブル登録される($data)
    {
        $this->postJson(route('line.callback'), $data, [HTTPHeader::LINE_SIGNATURE => 'aaaaa']);

        $this->assertDatabaseCount('line_friends', 1);

        $expected = [
            'line_id' => $data['events'][0]['source']['userId'],
        ];
        $this->assertDatabaseHas('line_friends', $expected);
    }

    /**
     * @test
     * @dataProvider sendUnFollowEventData
     */
    public function 友達削除イベント処理後テーブルから削除される($data)
    {
        $lineId = $data['events'][0]['source']['userId'];
        LineFriend::factory()->featureTestSetup(['line_id' => $lineId])->create();
        $this->postJson(route('line.callback'), $data, [HTTPHeader::LINE_SIGNATURE => 'aaaaa']);

        $this->assertDatabaseCount('line_friends', 0);

        $expected = [
            'line_id' => $lineId,
        ];
        $this->assertDatabaseMissing('line_friends', $expected);
    }

    public function sendFollowEventData(): array
    {
        return [
            [
                [
                    'destination' => 'xxxxxxxxxx',
                    'events' => [
                        [
                            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
                            'type' => 'follow',
                            'mode' => 'active',
                            'timestamp' => 1462629479859,
                            'source' => [
                                'type' => 'user',
                                'userId' => 'U4af4980629...'
                            ],
                            'webhookEventId' => '01FZ74A0TDDPYRVKNK77XKC3ZR',
                            'deliveryContext' => [
                                'isRedelivery' => false
                            ]
                        ]
                    ],
                ]
            ]
        ];
    }

    public function sendUnFollowEventData(): array
    {
        return [
            [
                [
                    'destination' => 'xxxxxxxxxx',
                    'events' => [
                        [
                            'replyToken' => 'nHuyWiB7yP5Zw52FIkcQobQuGDXCTA',
                            'type' => 'unfollow',
                            'mode' => 'active',
                            'timestamp' => 1462629479859,
                            'source' => [
                                'type' => 'user',
                                'userId' => 'U4af4980629...'
                            ],
                            'webhookEventId' => '01FZ74A0TDDPYRVKNK77XKC3ZR',
                            'deliveryContext' => [
                                'isRedelivery' => false
                            ]
                        ]
                    ],
                ]
            ]
        ];
    }

}
