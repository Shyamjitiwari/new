<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskClass;
use App\Teacher;
use App\User;
use App\Role;
use App\Location;
use App\Topic;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|teacher');
    }
    
    public function topicsIndexPage(){
        return view('topic.index');
    }

    public function getTopics()
    {
        $topicsData = Topic::where(['is_deleted' => false,])->get();
        $topics = array();

        foreach($topicsData as $topic)
        {
            $dataArray = [
                "topic_id" => $topic->id,
                "image" => $topic->image_name,
                "topic_name" => $topic->name,
                "topic_description" => $topic->description,
                "free_session" => $topic->free_session,
                "in_camps" => $topic->in_camps,
            ];
            array_push($topics,$dataArray);
        }

        return response()->json(['topics'=> $topics],200);
    }

    public function addTopic(Request $request)
    {
        $img = 'default.png';

        if($request->image_name) {
            $img = $this->uploadImage($request->image_name, 'topics', true);
        }
        echo $img;
        Topic::create([
            'name' => $request->topic_name,
            'description' => $request->topic_description,
            'image_name' => $img,
            'free_session' => $request->free_session,
        ]);

        return response()->json(['response_msg'=>'Data Saved'],200);
    }

    public function editTopic(Request $request, $id)
    {

        $data = Topic::find($id);
        $data->name = $request->topic_name;
        $data->description = $request->topic_description;
        $data->free_session = $request->free_session;
        $data->in_camps = $request->in_camps;
        $data->update();

        //get current image if any;
        $current_image = $data->image_name;

        // if old image exists and a new one has been uploaded, then replace
        if($current_image !='default.png' && $request->has('image_name'))
        {
            $this->deleteExistingImage('topics', $current_image);
            $data->image_name = $this->uploadImage($request->image_name, 'topics', true);
            $data->update();
        } else if ($request->image_name) {
            //Saving image here
            $data->image_name = $this->uploadImage($request->image_name, 'topics', true);
            $data->update();
        }

        return response()->json(['response_msg'=>'Data updated'],200);
    }
    public function deleteTopic($id){
        $data = Topic::find($id);
        $data->is_deleted = true;
        $data->update();
        return response()->json(['response_msg'=>'Data deleted'],200);
    }
}
