<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    //
    public function getIndex(){
        return View("backend.pages.index",["page_title"=>"Pages Listing","pages"=>Post::where("type","page")->paginate(20)]);
    }

    public function getAddNew(){
        return View("backend.pages.addnew",["page_title"=>"Add New Page","pages"=>Post::where("type","page")]);
    }

    public function getEditPage(Request $request, $pgId){

        return View("backend.pages.edit",["page_title"=>"Add New Page","mypage"=>Post::find($pgId),"pages"=>Post::where("type","page")]);
    }

    public function postAddNew(Request $request){
        $input = $request->all();
        /**
         * Validate the inputs before they are sent
         * to database
         */
        $validator =  Validator::make($request->all(), [
            'title'  =>  'required|min:2|unique:posts',
            'permalink'  =>  'required|min:2|unique:posts',
            //'p_content'  =>  'required|min:2',
        ]);
        $validator->setAttributeNames(['title'=>"Page Title","permalink"=>"page link"]);
        //$validator->setAttributeName()
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator->messages()); //if ajax request send ajax response
            }else{
                return \Redirect::back()->withErrors($validator)->withInput();
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
                    Session::flash("success_message","Page successfully saved");
                    return \Redirect::back();
                }
            }else{
                if($request->ajax()){
                    return response()->json("record saved successfully");
                }else{
                    Session::flash("error_message","Page was not successfully saved");
                    return \Redirect::back()->withInput();
                }
            }
        }
    }

    public function postEditPage(Request $request, $pgId){
        $input = $request->all();
        //procedure designed for deleting posts
        if($request->ajax()){
            if(isset($input['action']) && $input['action'] == "delete"){
                $post = Post::find($input['id']);
                $checkPost = Post::where("parent_id",$input['id'])->first();

                if(is_null($checkPost)){
                    if($post->delete()){
                        Session::flash("success_message","record successfully deleted from database");
                        return response()->json(["data"=>"record successfully deleted from database","status"=>200]);
                    }else{
                        Session::flash("error_message","Unexpected Error! Record could not be deleted");
                        return response()->json("Unexpected Error! Record could not be deleted",500);
                    }
                }else{
                    Session::flush("error_message","This record is associated with another record(s) in the database! Record cannot be deleted at this time");
                    return response()->json(["data"=>"This record is associated with another record(s) in the database! Record cannot be deleted at this time","status"=>400]);
                }
                exit;
            }
        }


        /**
         * Validate the inputs before they are sent
         * to database
         */
        $validator =  Validator::make($request->all(), [
            'title'  =>  'required|min:2',
            'permalink'  =>  'required|min:2',
            //'p_content'  =>  'required|min:2',
        ]);
        $validator->setAttributeNames(['title'=>"Page Title","permalink"=>"page link"]);
        //$validator->setAttributeName()
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator->messages()); //if ajax request send ajax response
            }else{
                return \Redirect::back()->withErrors($validator)->withInput();
            }
        }else{
            $post = Post::find($input['id']);
            /**
             * Loop through the $input and get
             * $key and $value pair for post
             * object
             */
            array_forget($input,"_token");
            foreach($input as $key=>$value){
                $post->$key = $value;
            }
            $post->updated_at = date("Y-m-d H:i:s");
            if($post->update()){
                if($request->ajax()){
                    return response()->json("record successfully updated");
                }else{
                    Session::flash("success_message","Page successfully updated");
                    return \Redirect::back();
                }
            }else{
                if($request->ajax()){
                    return response()->json("record could not save successfully");
                }else{
                    Session::flash("error_message","Page was not successfully saved");
                    return \Redirect::back()->withInput();
                }
            }
        }
    }

}
