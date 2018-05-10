<?php
namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Transformers\TopicTransformer;
use App\Http\Requests\Api\TopicRequest;
use App\Models\User;

class TopicsController extends Controller
{   

    public function userIndex(User $user, Request $request)
    {
        $topics = $user->topics()->recent()
            ->paginate(20);

        return $this->response->paginator($topics, new TopicTransformer()); 
    }

    public function index(Request $request, Topic $topic)
    {
        $query = $topic->query();

        if($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }

        switch ($request->order) {
            case 'request':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        $topics = $query->paginate(20);

        return $this->response->paginator($topics, new TopicTransformer());
    }





    public function store(TopicRequest $request, Topic $topic)
    {
    	$topic->fill($request->all());
    	$topic->user_id = $this->user()->id;
    	$topic->save();

    	return $this->response->item($topic, new TopicTransformer())
    		->setStatusCode(201);
    }

    public function update(TopicRequest $request, Topic $topic)
    {   //用户授权策略
    	$this->authorize('update', $topic);

    	$topic->update($request->all());
    	return $this->response->item($topic, new TopicTransformer());

    }

    public function destroy(Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->delete();
        return $this->response->noContent();
    }
}
