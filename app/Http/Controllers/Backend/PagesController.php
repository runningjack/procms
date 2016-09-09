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

}
