<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class EventsController extends Controller
{
    //
    public function getIndex(){
        return View("backend.events.index",["page_title"=>"Events","pages"=>Post::where("type","event")->paginate(20)]);
    }

    public function getAddNew(){

        $cats = \DB::table("posts")->where("type","event category")->get();
        return View("backend.events.addnew",["posts"=>\DB::table("posts")->where("type","event")->get(),"page_title"=>"Events","title"=>"Add New Event","categories"=>$cats]);
    }

    public  function getEditEvent(Request $request, $pgId){
        $cats = \DB::table("posts")->where("type","event category")->get();
        return View("backend.events.edit",["mypage"=>Post::find($pgId),"page_title"=>"Edit Event","title"=>"Edit Event","categories"=>$cats]);
    }

    public function getEventCategoryList(){
        return View("backend.events.categories",["page_title"=>"Edit Event","title"=>"Edit Event","categories"=>Post::where("type","=","event category")->get()]);
    }

    /**
     * Post an event category into database.
     * @param \Symfony\Component\HttpFoundation\Request;
     */
    public function postEventCategory(Request $request){
        $input = $request->all();

        $validator =   Validator::make($input, [
            'title'  =>  'required|min:2|unique:posts',
            'permalink'  =>  'required|min:2|unique:posts',

        ]);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $post = new  Post();
            $post->title            =   $input['title'];
            $post->p_content        =   $input['p_content'];
            $post->permalink        =   $input['permalink'];
            $post->description      =   $input['p_content'];
            $post->type             =   $input['type'];
            $post->created_by       =   "Admin";
            //var_dump($post);
            try {
                if($post->save()){
                    Session::flash("success_message","Category created");
                    echo '<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Category created</div>';
                }else{
                    Session::flash("error_message","Unexpected Error Record could not be Category created");
                    echo '<div class="alert alert-danger fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Unexpected Error</div>';
                }

                // $redirect = (isset($input['form_save'])) ? "backend/{$input['type']}s" : "backend/{$input['type']}s/create";

                //return \Redirect::to($redirect)
                // ->with('success_message', 'The ' . $this->type . ' was created.');
            } catch(ValidationException $e) {
                Session::flash("error_message","Unexpected Error! Category not created: ".$e->getMessage());
                echo '<div class="alert alert-danger fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Unexpected Error! Category not created: '.$e->getMessage()."</div>";// \Redirect::back()->withInput()->withErrors($e->getErrors());
            }
        }
    }

    public function  postAddNew(Request $request){
        $input = $request->all();

        if($request->ajax()){
            /***Designed to perform other form activities  via ajax
             * faction --- represents input field that specifies the type of image
             * to upload
             */
            if(isset($input['faction']) && ($input['faction']=="image feature")){

                ############ Configuration ##############
                $thumb_square_size 		= 200; //Thumbnails will be cropped to 200x200 pixels
                $max_image_size 		= 500; //Maximum image size (height and width)
                $destination_folder = public_path()."/uploads/images/";

                if(!empty($_POST['imageInput'])){
                    unlink($destination_folder.$_POST['imageInput']);
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
                            echo '<img src="'.public_path().'/uploads/images/'.$new_file_name.'" alt="Resize Image">';
                            echo '</div>@@'.$new_file_name;
                        }
                        imagedestroy($image_res); //freeup memory
                    }
                }
            }
            exit;
        }


        $validator =   Validator::make($request->all(), [
            'title'  =>  'required|min:2|unique:posts',
            'permalink'  =>  'required|min:2|unique:posts',
            'p_content'  =>  'required|min:2',
            'start_date'  =>  'required|min:2',
            'end_date'  =>  'required|min:2',
        ]);
        $validator->setAttributeNames(['title'=>"Page Title","permalink"=>"page link"]);
        if($validator->fails()){
            //Make provision for ajax post
            if($request->ajax()){
                return response()->json($validator->messages()); //if ajax request send ajax response
            }else{
                return Redirect::back()->withErrors($validator)->withInput();
            }

        }else{
            if(isset($input['id'])){
                $post = Post::find($input['id']);
            }else{
                $post = new Post();
            }


            $post->description          = (isset($_POST['description'])) ?  $request->get("description") : "";
            $post->caption              = $post->description;
            $post->title                =   $input['title'];
            $post->p_content            =   $input['p_content'];
            $post->permalink            =   $input['permalink'];
            $post->type                 =   $input['type'];
            $post->parent_id            =   (isset($input['parent_id'])) ? $input['parent_id'] :"";
            $post->image                =   isset($input['image']) ? $input['image'] :"";
            $post->video                =   isset($input['video']) ? $input['video'] :"";
            //$post->view_status        =   $input['view_status'];
            $post->created_by           =   "Admin";
            $post->meta_keyword         =   $input['meta_keyword'];
            $post->meta_description     =   $input['meta_description'];
            $post->meta_title           =   $input['meta_title'];
            $post->start_date                =   isset($input['start_date']) ? $input['start_date'] :"";
            $post->end_date                =   isset($input['end_date']) ? $input['end_date'] :"";
            $post->start_time                =   isset($input['start_time']) ? $input['start_time'] :"";
            $post->end_time                =   isset($input['end_time']) ? $input['end_time'] :"";
            $post->venue                =   isset($input['venue']) ? $input['venue'] :"";
            $post->address                =   isset($input['address']) ? $input['address'] :"";
            $post->fee                    = $input['fee'];

            try {

                if (is_uploaded_file($_FILES['document']['tmp_name'])) {
                    $destination_folder		= public_path()."/uploads/documents/"; //upload directory ends with / (slash)
                    $image_invention_folder = public_path()."/uploads/documents/";
                    //uploaded file info we need to proceed
                    $image_name = $_FILES['document']['name']; //file name
                    $image_size = $_FILES['document']['size']; //file size
                    $image_temp = $_FILES['document']['tmp_name']; //file temp
                    $image_size_info 	= getimagesize($image_temp); //get image size

                    //Get file extension and name to construct new file name
                    $image_info = pathinfo($image_name);
                    $image_extension = strtolower($image_info["extension"]); //image extension
                    $image_name_only = strtolower($image_info["filename"]);//file name only, no extension

                    //create a random name for new image (Eg: fileName_293749.jpg) ;
                    $mrand =rand(0, 9999999999);
                    $new_file_name = $image_name_only. '_' .  $mrand . '.' . $image_extension;
                    $request->file('document')->move($destination_folder,$new_file_name);
                    $post->document  = $new_file_name;

                }else{
                    $post->document  =isset($input['olddocument']) ? $input['olddocument'] :""; //$input['olddocument'];
                    switch($_FILES['document']['error']){
                        case 0: //no error; possible file attack!
                            break;
                        case 1: //uploaded file exceeds the upload_max_filesize directive in php.ini
                            Session::flash("The file you are trying to upload is too big.");
                            return Redirect::back()->withInput();
                            break;
                        case 2: //uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form
                            Session::flash("The file you are trying to upload is too big.");
                            return Redirect::back()->withInput();
                            //echo "";
                            break;
                        case 3: //uploaded file was only partially uploaded

                            Session::flash("The file you are trying upload was only partially uploaded.");
                            return Redirect::back()->withInput();
                            break;
                        case 4: //no file was uploaded

                            break;
                        default: //a default error, just in case!  :)
                            Session::flash("Unexpected error");
                            return  Redirect::back()->withInput();
                            break;
                    }
                }
                if(!isset($input['id'])){
                    if($post->save()){

                        Session::flash("success_message","Post Created");
                        return Redirect::back()
                            ->with('success_message', 'The ' . $input["type"] . ' was saved.');
                    }else{
                        Session::flash("error_message","Unexpecetd Error! Post Not saved");
                        return Redirect::back()->withInput()
                            ->with('error_message', 'Unexpecetd Error! The ' . $input["type"] . ' was not saved.');
                    }
                }else{
                    if($post->update()){

                        Session::flash("success_message","Post Updated");
                        return Redirect::back()
                            ->with('success_message', 'The ' . $input["type"] . ' was saved.');
                    }else{
                        Session::flash("error_message","Unexpecetd Error! Post Not saved");
                        return Redirect::back()->withInput()
                            ->with('error_message', 'Unexpecetd Error! The ' . $input["type"] . ' was not saved.');
                    }
                }

            } catch(ValidationException $e) {
                return Redirect::back()->withInput()->withErrors($e->getErrors());
            }catch(\Illuminate\Database\QueryException $e){
                Session::flash("error_message",$e->getMessage());
                return Redirect::back()->withInput();
            }catch(\PDOException $e){
                Session::flash("error_message",$e->getMessage());
                return Redirect::back()->withInput();
            }catch(\Exception $e){
                Session::flash("error_message",$e->getMessage());
                return Redirect::back()->withInput();
            }
        }
    }
    public function  postUploadImage(){

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
