<?php

use App\Models\Answer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $now = Carbon::now();

        foreach (range(1, 10000) as $index) {
            $answer = factory(Answer::class)->make([
                'user_id' => rand(1, 100),
                'question_id' => rand(1, 1000),
            ]);

            $data[] = [
                'content' => $answer->content,
                'user_id' => $answer->user_id,
                'question_id' => $answer->question_id,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ];
        }

        Answer::insert($data);
    }
}
