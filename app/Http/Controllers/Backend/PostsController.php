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
        return View("backend.posts.addnew",["page_title"=>"Post Listing","title"=>"Posts- Add New","categories"=> Post::where("type","post category")->get()]);
    }

    public function getEditPost(Request $request, $pgId){
        return View("backend.posts.edit",["page_title"=>"Edit Post","categories"=> Post::where("type","post category")->get(),"mypage"=>Post::find($pgId),"title"=>"Post- Edit Post"]);
    }

    public function postAddNew(Request $request){
        $input = $request->all();


        /**
         *
         */

        if($request->ajax()){
            /***Designed to perform other form activities  via ajax
             * faction means form action
             */
            if(isset($input['faction']) && ($input['faction']=="featured image")){

                ############ Configuration ##############
                $thumb_square_size 		= 200; //Thumbnails will be cropped to 200x200 pixels
                $max_image_size 		= 500; //Maximum image size (height and width)
                $destination_folder = public_path()."/uploads/images/";

                if(!empty($_POST['image_file'])){
                    unlink($destination_folder.$_POST['image_file']);
                }

                //$file =
                $jpeg_quality 			= 90; //jpeg quality
                ##########################################

                //continue only if $_POST is set and it is a Ajax request
                if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
                    // check $_FILES['ImageFile'] not empty
                    if(!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])){
                        die('Image file is Missing!'); // output error when above checks fail.
                        exit;
                    }
                    //uploaded file info we need to proceed
                    $image_name = $_FILES['image_file']['name']; //file name
                    $image_size = $_FILES['image_file']['size']; //file size
                    $image_temp = $_FILES['image_file']['tmp_name']; //file temp
                    $image_size_info 	= getimagesize($image_temp); //get image size

                    if($image_size_info){
                        $image_width 		= $image_size_info[0]; //image width
                        $image_height 		= $image_size_info[1]; //image height
                        $image_type 		= $image_size_info['mime']; //image type
                    }else{
                        die("Make sure image file is valid!");
                    }

                    //switch statement below checks allowed image type
                    //as well as creates new image from given file
                    switch($image_type){
                        case 'image/png':
                            $image_res =  imagecreatefrompng($image_temp); break;
                        case 'image/gif':
                            $image_res =  imagecreatefromgif($image_temp); break;
                        case 'image/jpeg': case 'image/pjpeg':
                        $image_res = imagecreatefromjpeg($image_temp); break;
                        default:
                            $image_res = false;
                    }

                    if($image_res){
                        //Get file extension and name to construct new file name
                        $image_info = pathinfo($image_name);
                        $image_extension = strtolower($image_info["extension"]); //image extension
                        $image_name_only = strtolower($image_info["filename"]);//file name only, no extension

                        //create a random name for new image (Eg: fileName_293749.jpg) ;
                        $mrand =rand(0, 9999999999);
                        $new_file_name = $image_name_only. '_' .  $mrand . '.' . $image_extension;

                        //folder path to save resized images and thumbnails
                        //$thumb_save_folder 	= $destination_folder . $thumb_prefix . $new_file_name;
                        $image_save_folder 	= $destination_folder . $new_file_name;

                        //call normal_resize_image() function to proportionally resize image
                        if(normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality))
                        {
                            /* We have succesfully resized and created thumbnail image
                            We can now output image to user's browser or store information in the database.$destination_folder */
                            echo '<div align="center">';
                            echo '<img src="'.url('').'/uploads/images/'.$new_file_name.'" alt="Resized Image">';
                            echo '</div>@@'.$new_file_name;
                        }
                        imagedestroy($image_res); //freeup memory
                    }
                }
            }

            if(isset($input['faction']) && ($input['faction']=="getprice")){
                $price = Product::where("product_link",$input['prod'])->first()->prices()->where("size","=",$input['bsize'])->where("quantity","=",$input['qty'])->pluck("price"); //Product::where("product_link","=",$input['prod'])->first();
                /**
                 * return the first element in the plucked price array
                 */
                //$priceData = ["price"=>$price[0]];
                return response()->json($price[0]);
            }

            exit;
        }





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
            $post->updated_at = date("Y-m-d H:i:s");
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

    public function getPostCategoryList(){
        return View("backend.posts.categories",["page_title"=>"Post Category","title"=>"Post Category","categories"=>Post::where("type","=","post category")->get()]);
    }

    /**
     *
     */
    public function postPostCategory(Request $request){
        $input = $request->all();

        if(isset($input['pgid']) && $input['pgid'] != ""){
            $validator =   Validator::make($input, [
                'title'  =>  'required|min:2',
                'permalink'  =>  'required|min:2',

            ]);
        }else{
            $validator =   Validator::make($input, [
                'title'  =>  'required|min:2|unique:posts',
                'permalink'  =>  'required|min:2|unique:posts',

            ]);
        }


        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $post = (isset($input['pgid']) && $input['pgid'] != "") ? Post::find($input['pgid']) : new  Post();
            $post->title            =   $input['title'];
            $post->p_content        =   $input['p_content'];
            $post->permalink        =   $input['permalink'];
            $post->description      =   $input['p_content'];
            $post->type             =   $input['type'];
            $post->post_type        =   isset($input['post_type']) ? $input['post_type'] : $input['type'];
            $post->created_by       =   "Admin";
            //var_dump($post);

            try {
                /**
                 *Check for condition if pgid isset and is not empty
                 * then it is an update action
                 * to be performed else it is a fresh post table insert
                 */
                if(isset($input['pgid']) && $input['pgid'] != ""){
                    $post->updated_at = date("Y-m-d H:i:s");
                    if($post->update()){
                        Session::flash("success_message","Record created");
                        return response()->json(["data"=>$post,"status"=>"200","msg"=>'<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Record Successfully created</div>']);
                    }else{
                        Session::flash("error_message","Unexpected Error Record could not be created");
                        return response()->json(["data"=>$post,"status"=>"400","msg"=>'<div class="alert alert-danger fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Unexpected Error</div>']);
                    }
                }else{ // else condition to save / create new record
                    if($post->save()){
                        Session::flash("success_message","Category created");
                        return response()->json(["data"=>$post,"status"=>"200","msg"=>'<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Category created</div>']);
                    }else{
                        Session::flash("error_message","Unexpected Error Record could not be Category created");
                        return response()->json(["data"=>$post,"status"=>"400","msg"=>'<div class="alert alert-danger fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Unexpected Error</div>']);
                    }
                }


                // $redirect = (isset($input['form_save'])) ? "backend/{$input['type']}s" : "backend/{$input['type']}s/create";

                //return \Redirect::to($redirect)
                // ->with('success_message', 'The ' . $this->type . ' was created.');
            } catch(ValidationException $e) {
                Session::flash("error_message","Unexpected Error! Category not created: ".$e->getMessage());
                return response()->json('<div class="alert alert-danger fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Unexpected Error! Category not created: '.$e->getMessage()."</div>");// \Redirect::back()->withInput()->withErrors($e->getErrors());
            }
        }
    }

}




//This function is for converting Numbers to Letters that are compatible with Excel, and Excel writter for cell selection
function num_to_letter($num, $uppercase = TRUE)
{
    $num -= 1;
    $letter =   chr(($num % 26) + 97);
    if ($num >= 26) {
        $letter = num_to_letter(floor($num/26),$uppercase).$letter;
    }
    return      ($uppercase ? strtoupper($letter) : $letter);
}

#####  This function will proportionally resize image #####
function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){

    if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize

    //do not resize if image is smaller than max size
    if($image_width <= $max_size && $image_height <= $max_size){
        if(save_image($source, $destination, $image_type, $quality)){
            return true;
        }
    }

    //Construct a proportional size of new image
    $image_scale	= min($max_size/$image_width, $max_size/$image_height);
    $new_width		= ceil($image_scale * $image_width);
    $new_height		= ceil($image_scale * $image_height);

    $new_canvas		= imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image

    //Copy and resize part of an image with resampling
    if(imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)){
        save_image($new_canvas, $destination, $image_type, $quality); //save resized image
    }

    return true;
}

##### This function corps image to create exact square, no matter what its original size! ######
function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
    if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize

    if($image_width > $image_height)
    {
        $y_offset = 0;
        $x_offset = ($image_width - $image_height) / 2;
        $s_size 	= $image_width - ($x_offset * 2);
    }else{
        $x_offset = 0;
        $y_offset = ($image_height - $image_width) / 2;
        $s_size = $image_height - ($y_offset * 2);
    }
    $new_canvas	= imagecreatetruecolor( $square_size, $square_size); //Create a new true color image

    //Copy and resize part of an image with resampling
    if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
        save_image($new_canvas, $destination, $image_type, $quality);
    }

    return true;
}
##### Saves image resource to file #####
function save_image($source, $destination, $image_type, $quality){
    switch(strtolower($image_type)){//determine mime type
        case 'image/png':
            imagepng($source, $destination); return true; //save png file
            break;
        case 'image/gif':
            imagegif($source, $destination); return true; //save gif file
            break;
        case 'image/jpeg': case 'image/pjpeg':
        imagejpeg($source, $destination, $quality); return true; //save jpeg file
        break;
        default: return false;
    }
}

