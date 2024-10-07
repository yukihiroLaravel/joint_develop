<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Post;

class ScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:publish-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes scheduled posts if their time has come.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = Post::where('scheduled_at', '<=', now())
        ->where('is_published', false) // 未公開のもの
        ->get();

        foreach ($posts as $post) {
            $post->is_published = true;
            $post->save();
        }

        return 0;
    }
}
