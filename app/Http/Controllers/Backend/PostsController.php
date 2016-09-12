<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{
    //
    public function getIndex(){
        return View("backend.posts.index",["page_title"=>"Post Listing","title"=>"Posts","categories"=> Post::where("type","category")->get(),"posts"=>Post::where("type","post")->paginate(20)]);
    }

    public function getAddNew(){
        return View("backend.posts.addnew",["page_title"=>"Post Listing","title"=>"Posts- Add New","categories"=> Post::where("type","category")->get()]);
    }

    public function getEditPost(Request $request, $pgId){
        return View("backend.posts.edit",["page_title"=>"Edit Post","categories"=> Post::where("type","category")->get(),"mypage"=>Post::find($pgId),"title"=>"Post- Edit Post"]);
    }

    public function postAddNew(Request $request){
        $input = $request->all();
        /**
         * Validate the inputs before they are sent
         * to database
         */
        $validator =   Validator::make($request->all(), [
            'title'  =>  'required|min:2|unique:posts',
            'permalink'  =>  'required|min:2|unique:posts',

        ]);
        $validator->setAttributeNames(['title'=>"Page Title","permalink"=>"page link"]);
        //$validator->setAttributeName()
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator->messages()); //if ajax request send ajax response
            }else{
                return Redirect::back()->withErrors($validator)->withInput();
            }
        }else{
            $post = new Post();
            /**
             * Loop through the $input and get
             * $key and $value pair for post
             * object
             */
            array_forget($input,"_token");
            foreach($input as $key=>$value){
                $post->$key = $value;
            }
            if($post->save()){
                if($request->ajax()){
                    return response()->json("record saved successfully");
                }else{
                    Session::flash("success_message","Post successfully saved");
                    return Redirect::back();
                }
            }else{
                if($request->ajax()){
                    return response()->json("record saved successfully");
                }else{

                    Session::flash("error_message","Post was not successfully saved");
                    return Redirect::back()->withInput();
                }
            }
        }
    }

    public function postEditPost(Request $request, $pgId){
        $input = $request->all();
        /**
         * Validate the inputs before they are sent
         * to database
         */
        $validator =   Validator::make($request->all(), [
            'title'  =>  'required|min:2',
            'permalink'  =>  'required|min:2',

        ]);
        $validator->setAttributeNames(['title'=>"Page Title","permalink"=>"page link"]);
        //$validator->setAttributeName()
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator->messages()); //if ajax request send ajax response
            }else{
                return Redirect::back()->withErrors($validator)->withInput();
            }
        }else{
            $post = Post::find($pgId);
            /**
             * Loop through the $input and get
             * $key and $value pair for post
             * object
             */
            array_forget($input,"_token");
            foreach($input as $key=>$value){
                $post->$key = $value;
            }
            if($post->update()){
                if($request->ajax()){
                    return response()->json("record saved successfully");
                }else{
                    Session::flash("success_message","Post successfully saved");
                    return Redirect::back();
                }
            }else{
                if($request->ajax()){
                    return response()->json("record saved successfully");
                }else{

                    Session::flash("error_message","Post was not successfully saved");
                    return Redirect::back()->withInput();
                }
            }
        }
    }
}
