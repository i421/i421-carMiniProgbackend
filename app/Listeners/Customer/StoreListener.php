<?php

namespace App\Listeners\Customer;

use App\Events\Customer\StoreEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Tables as TableModels;

class StoreListener
{
    private $userInfo;
    private $recommender;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StoreEvent  $event
     * @return void
     */
    public function handle(StoreEvent $event)
    {
        $this->userInfo = $event->userInfo;
        $this->recommender = $event->recommender;

        $customer = TableModels\Customer::where('openid', $this->userInfo['openId'])->first();

        if (empty($customer)) {

            $customer_id = TableModels\Customer::insertGetId([
                'openid' => $this->userInfo['openId'],
                'uuid' => time() . str_random(30),
                'nickname' => $this->userInfo['nickName'],
                'gender' => $this->userInfo['gender'],
                'avatar' => $this->userInfo['avatarUrl'],
                'country' => $this->userInfo['country'],
                'province' => $this->userInfo['province'],
                'city' => $this->userInfo['city'],
                'recommender' => $this->recommender,
            ]);
	
            //积分计算
            TableModels\Score::create([
                'customer_id' => $customer_id,
                'count' => getScoreThreshold()['store'],
                'desc' => '注册积分奖励',
            ]);

            if (!empty($this->recommender)) {

                // avoid repeat
                if ($customer->recommender == null) {
                    $res = TableModels\Customer::where('id', $this->recommender)->increment('recommend_count', 1);

                    //积分计算
                    TableModels\Score::create([
                        'customer_id' => $this->recommender,
                        'count' => getScoreThreshold()['recommend'],
                        'desc' => '推荐积分奖励',
                    ]);
                }

                if (empty($res)) {
                    \Log::info("[error]: not found recommender with uuid: $this->recommender");
                } else {
                    \Log::info("[customer]: finished store");
                }
            }

        } else {

            //积分计算
            /*
            TableModels\Score::create([
                'customer_id' => $customer->id,
                'count' => getScoreThreshold()['store'],
                'desc' => '注册积分奖励',
            ]);
             */

            if (!empty($this->recommender)) {

                if ($customer->recommender == null) {
                    $res = TableModels\Customer::where('id', $this->recommender)->increment('recommend_count', 1);

                    //积分计算
                    TableModels\Score::create([
                        'customer_id' => $this->recommender,
                        'count' => getScoreThreshold()['recommend'],
                        'desc' => '推荐积分奖励',
                    ]);
                }

                if (empty($res)) {
                    \Log::info("[error]: not found recommender with uuid: $this->recommender");
                } else {
                    \Log::info("[customer]: finished store");
                }
            }

            $customer->nickname = $this->userInfo['nickName'];
            $customer->gender = $this->userInfo['gender'];
            $customer->avatar = $this->userInfo['avatarUrl'];
            $customer->country = $this->userInfo['country'];
            $customer->province = $this->userInfo['province'];
            $customer->city = $this->userInfo['city'];
            $customer->save();

        }
    }
}
