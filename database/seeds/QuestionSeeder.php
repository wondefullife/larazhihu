<?php

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
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

        foreach (range(1, 1000) as $item) {
            $question = factory(Question::class)->make([
                'user_id' => rand(1, 100)
            ]);

            $data[] = [
                'title' => $question->title,
                'content' => $question->content,
                'user_id' => $question->user_id,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
                'published_at' => $now->toDateTimeString(),
            ];
        }

        Question::insert($data);
    }
}
