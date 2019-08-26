<?php

namespace App\Jobs\Api\V1\Tag;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Tables as TableModels;

class ClassifyJob
{
    use Dispatchable, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $tags = TableModels\Tag::select('id', 'tag_group', 'name')->groupBy('tag_group', 'id', 'name')->get()->toArray();

        $data = [];

        foreach ($tags as $tag) {
            if (isset($data[$tag['tag_group']])) {
                array_push($data[$tag['tag_group']], ['id' => $tag['id'], 'name' => $tag['name']]);
            } else {
                $temp = ['id' => $tag['id'], 'name' => $tag['name']];
                $data[$tag['tag_group']][] = $temp;
            }
        }

        $temp = [];
        foreach ($data as $key => $val) {
            $temp[] = [$key => $val];
        }

        $response = [
            'code' => trans('pheicloud.response.success.code'),
            'msg' => trans('pheicloud.response.success.msg'),
            'data' => $temp,
        ];

        return response()->json($response);
    }
}
