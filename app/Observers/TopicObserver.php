<?php

namespace App\Observers;
use App\Jobs\TranslateSlug;
use App\Models\Topic;
use App\Handlers\SlugTranslateHandler;
// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function saved(Topic $topic)
    {
        if(!$topic->slug ) {
            //队列
            dispatch(new TranslateSlug($topic));
        }
    }

    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id',$topic->id)->delete();
    }


}
