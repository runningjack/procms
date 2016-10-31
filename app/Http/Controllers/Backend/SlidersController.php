<?php

namespace App\Http\Controllers\Backend;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $pgid = null)
    {
        $input = $request->all();
        $slideElements="";
        $myslider="";
        $responsedata=[];
        //
        $responsedata["accordion"] = null;
            if(!empty($pgid)){
                $myslider = Post::find($pgid);

                $dataArrs = (json_decode($myslider->post_meta));

                if(isset($input['action'])){
                    if($input['action']=="update main slider"){
                    }
                }
                $responsedata["accordion"]= $this->loadAccordion($dataArrs,$myslider);
            }
        $responsedata["mypost"]=$myslider;
        // $slideElements;
       // echo json_encode($responsedata);
        //exit;
        if($request->ajax()){
            return response()->json(["data"=>$responsedata,"status"=>"200","msg"=>'<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Unexpected Error</div>']);
        }
        $sliders  =  DB::table("posts")->where("type","slider")->get();
        return View("backend.sliders.index",["data"=>Post::find($pgid),"slideshows"=>$sliders,"page_title"=>"Sliders","menufposts"=>Post::where("post_type","slider")->get()]);
    }

    public function postIndex(Request $request, $pgid=""){
        $input = $request->all();
        /** Section for file upload via ajax*/
        if($request->ajax()){
            if(isset($input['action']) ){
                if(!empty($input['postid']) && $input['action']=="update main slider"){
                    $post = Post::find($input['postid']);
                    $post->post_meta = $input['postmeta'];
                    $post->updated_at = date("Y-m-d H:i:s");
                    $slideElements = "";
                    if($post->update()){

                        $dataArrs = (json_decode($input['postmeta']));
                        $slideElements = $this->loadAccordion($dataArrs,$post);


                        return response()->json(["data"=>$slideElements,"status"=>"200","msg"=>'<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Unexpected Error</div>']);
                    }


                }
                elseif($input['action'] == "delete main slider item"){
                    $post = Post::find($pgid);
                    $checkPost = Post::where("parent_id",$input['id'])->first();
                    $dataArrs = (json_decode($post->post_meta));
                    //print_r($dataArrs);

                    unset($dataArrs[0]->$input['id']);
                    //array_forget($dataArrs,$input['id']);
                    $slideElements = $this->loadAccordion($dataArrs,$post);




                    if(is_null($checkPost)){
                        $post->post_meta = json_encode($dataArrs);
                        $post->updated_at = date("Y-m-d H:i:s");
                        if($post->update()){
                            Session::flash("success_message","record successfully deleted from database");

                            return response()->json(["data"=>$slideElements,"status"=>"200","msg"=>'<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Record Successfully Updated</div>']);
                        }else{
                            Session::flash("error_message","Unexpected Error! Record could not be deleted");

                            return response()->json(["data"=>$slideElements,"status"=>"500","msg"=>'<div class="alert alert-danger fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Record Successfully Updated</div>']);
                        }
                    }else{
                        Session::flush("error_message","This record is associated with another record(s) in the database! Record cannot be deleted at this time");
                        return response()->json(["data"=>"This record is associated with another record(s) in the database! Record cannot be deleted at this time","status"=>400]);
                    }

                }else if($input['action'] == "update main slider item"){

                    $post = Post::find($pgid);
                    $checkPost = Post::where("parent_id",$input['id'])->first();
                    $dataArrs = (json_decode($post->post_meta));
                    //print_r($dataArrs);
                    foreach($dataArrs[0]->$input['id'] as $slide){
                        $slide->slidetitle = $input['title'];
                        $slide->link = $input['link'];
                        $slide->caption = $input['descript'];
                    }


                    //array_forget($dataArrs,$input['id']);
                    $slideElements = $this->loadAccordion($dataArrs,$post);

                    if(is_null($checkPost)){
                        $post->post_meta = json_encode($dataArrs);
                        $post->updated_at = date("Y-m-d H:i:s");
                        if($post->update()){
                            Session::flash("success_message","record successfully deleted from database");

                            return response()->json(["data"=>$slideElements,"status"=>"200","msg"=>'<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Record Successfully Updated</div>']);
                        }else{
                            Session::flash("error_message","Unexpected Error! Record could not be deleted");

                            return response()->json(["data"=>$slideElements,"status"=>"500","msg"=>'<div class="alert alert-danger fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Record Successfully Updated</div>']);
                        }
                    }else{
                        Session::flush("error_message","This record is associated with another record(s) in the database! Record cannot be deleted at this time");
                        return response()->json(["data"=>"This record is associated with another record(s) in the database! Record cannot be deleted at this time","status"=>400]);
                    }
                }
                exit;
            }


            ### Check if type is file is uploaded #

            if(isset($input['image_file']) && $_FILES['image_file']['error'] != UPLOAD_ERR_NO_FILE){
                ############ Configuration ##############
                $postid="";$link="";$maxWidth="";$maxHeight="";$width = 500;$height =500;$thumbheight =100;$thumwidth=100;$title="";$caption ="";$p_content="";$permalink="";
                ### Check if post meta data json is set
                $image_size_info 	= getimagesize($_FILES['image_file']['tmp_name']); //get image size


                $thumb_square_size 		=  200; //Thumbnails will be cropped to 200x200 pixels
                $max_image_size 		= 500; //Maximum image size (height and width)
                $destination_folder = public_path()."/uploads/images/";

                if(!empty($_POST['image_file'])){
                    unlink($destination_folder.$_POST['image_file']);
                }
                $jpeg_quality 			= 90; //jpeg quality
                ##########################################



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

                    if(isset($input['post_meta']) && $input['post_meta'] != ""){
                        $postmeta = json_decode($input['post_meta']); // get post meta data and convert to PHP array
                        ### Looop through the object an get properties ###
                        foreach($postmeta as $postdata){

                            $width = !empty($postdata->width) && isset($postdata->width) ? $postdata->width : $image_size_info[0];
                            $postid = $postdata->postid;
                            $maxWidth = (isset($postdata->width) && !empty($postdata->width) )  ? $postdata->width : $image_size_info[0];
                            $maxHeight= (isset($postdata->height) && $postdata->height !="") ? $postdata->height : $image_size_info[1];
                            $height = (isset($postdata->height) && !empty($postdata->height)) ? $postdata->height : $image_size_info[1];
                            $thumwidth = (isset($postdata->thumwidth) && !empty($postdata->thumwidth)) ? $postdata->thumwidth : 100;
                            $thumbheight =(isset($postdata->thumbheight) && !empty($postdata->thumbheight)) ? $postdata->thumbheight : 100;
                            $title = (isset($postdata->slidetitle) && !empty($postdata->slidetitle)) ? $postdata->slidetitle : 100;
                            $caption = (isset($postdata->caption) && !empty($postdata->caption)) ? $postdata->caption : 100;
                            $link = (isset($postdata->link) && !empty($postdata->link)) ? $postdata->link : 100;
                            $slideid = (isset($postdata->slideid) && !empty($postdata->slideid)) ? $postdata->slideid : 0;

                        }
                    }

                    //call normal_resize_image() function to proportionally resize image
                    if(resizeImage($image_temp, $image_save_folder, $maxWidth, $maxHeight, $quality = 90,$image_type))
                    {

                        /* We have succesfully resized and created thumbnail image
                        We can now output image to user's browser or store information in the database.$destination_folder */
                        $post = new Post();
                        $post->title = $title == "" ? $new_file_name : $title;
                        $post->p_content = $caption == "" ? $new_file_name : $caption;
                        $post->description = $caption == "" ? $new_file_name : $caption;
                        $post->permalink = $link =="" ? $new_file_name : $link ;
                        $post->image = $new_file_name;
                        $post->post_meta = json_encode($postmeta);
                        $post->type = "slide image";
                        $post->post_type = "slide image";
                        //dd($post);
                        if($post->save()){
                            $postmeta[0]->slideid = $post->id;
                            $postmeta[0]->width = $width;
                            $postmeta[0]->height = $height;
                            $postmeta[0]->slideimage = $post->image;

                            $post->post_meta  =   (json_encode($postmeta));//json_decode()

                            $post->update();
                            Session::flash("success_message","Category created");
                            return response()->json(["data"=>$post,"status"=>"200","img"=>'<div align="center"><img src="'.url('').'/uploads/images/'.$new_file_name.'" alt="Resized Image"></div>@@'.$new_file_name,"msg"=>'<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Category created</div>']);
                        }else{
                            unlink($image_save_folder);
                            Session::flash("error_message","Unexpected Error Record could not be Category created");
                            return response()->json(["data"=>$post,"status"=>"400","msg"=>'<div class="alert alert-danger fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Unexpected Error</div>']);

                        }
                        /*echo '<div align="center">';
                        echo '<img src="'.url('').'/uploads/images/'.$new_file_name.'" alt="Resized Image">';
                        echo '</div>@@'.$new_file_name;*/
                    }

                    //resizeImage($image_res, $image_save_folder, $maxWidth, $maxHeight, $quality = 90,$image_type);
                    //imagedestroy($image_res); //freeup memory
                }



                exit;
            }
        }

        if(isset($input['pgid']) && $input['pgid'] != ""){
            $validator      =   Validator::make($input, [
                'title'     =>  'required|min:2',
                'permalink' =>  'required|min:2',
            ]);
        }else{
            $validator      =   Validator::make($input,[
                'title'     =>  'required|min:2|unique:posts',
                'permalink' =>  'required|min:2|unique:posts',
            ]);
        }


        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }else{
            $post = (isset($input['pgid']) && $input['pgid'] != "") ? Post::find($input['pgid']) : new  Post();

            array_forget($input,"_token");
            array_forget($input,"submit");
            foreach($input as $key=>$value){
                $post->$key = $value;
            }

            try {
                /**
                 *Check for condition if pgid isset and is not empty
                 * then it is an update action
                 * to be performed else it is a fresh post table insert
                 */
                if(isset($input['pgid']) && $input['pgid'] != ""){
                    if($post->update()){
                        Session::flash("success_message","Record created");
                        return response()->json(["data"=>$post,"status"=>"200","msg"=>'<div class="alert alert-success fade in">
                                        <button class="close" data-dismiss="alert">×</button>
                                        <i class="fa-fw fa fa-times">Record Successfully created</div>']);
                    }else{
                        Session::flash("error_message","Unexpected Error Record could not be created");
                        return response()->json(["data"=>$post,"slideshows"=>"","status"=>"400","msg"=>'<div class="alert alert-danger fade in">
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function loadAccordion($dataArrs,$post){
        $slideElements ="";

        if(!is_null($dataArrs)){
            foreach($dataArrs as $dataArr){
                foreach($dataArr as $dataA){
                    $slideElements .="<div class='panel panel-default'>
                                                <div class='panel-heading'>
                                                    <h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#".$dataA[0]->slideid."' class='collapsed'>
                                                            <i class='fa fa-lg fa-angle-down pull-right'></i> <i class='fa fa-lg fa-angle-up pull-right'></i>
                                Slide ".$dataA[0]->slideid." </a>
                                                    </h4>
                                                </div>
                                                <div id='".$dataA[0]->slideid."' class='panel-collapse collapse' style='height: 0px;'>
                                                    <div class='panel-body'>
                                                        <form method='post' class='form-horizontal' id='".$dataA[0]->slideid."'>
                                                        <fieldset>
                                                            <legend>Slide #".$dataA[0]->slideid."</legend>
                                                            <input type='hidden' id='id' name='id' value='".$dataA[0]->slideid."'>
                                                            <div class='form-group'>
                                                                <div class='col-md-12.>
                                                                    <label class='radio radio-inline'>
                                                                        <input type='radio' id='image' name='image' class='radiobox' value='".$dataA[0]->slideid."'>";
                    $img_name = Post::find($dataA[0]->slideid)->pluck("image");
                    $slideElements .= "<span><img src='".url('')."/uploads/images/";$slideElements .= isset($dataA[0]->slideimage) ? $dataA[0]->slideimage : "" ; $slideElements .="'  style='width:90px; height:55px' ></span>
                                                                    </label>

                                                                </div>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label class='col-md-2 control-label'>Title</label>
                                                                <div class='col-md-10'>
                                                                    <input class='form-control' name='title' id='title".$dataA[0]->slideid."' type='text' value='".$dataA[0]->slidetitle."'>
                                                                </div>
                                                            </div>
                                                            <div class='form-group'>
                                                                <label class='col-md-2 control-label'>Url</label>
                                                                <div class='col-md-10'>
                                                                    <input class='form-control' id='permalink".$dataA[0]->slideid."'  name='permalink' placeholder='' type='text' value='".$dataA[0]->link."' >
                                                                </div>
                                                            </div>
                                                            <input type='hidden'  name='type".$dataA[0]->slideid."' value='slideshow' >
                                                            <input type='hidden'  name='p_content".$dataA[0]->slideid."' value='".$dataA[0]->caption."'>
                                                            <input type='hidden' name='parent_id'>
                                                            <input type='hidden'  name='meta_keyword'>
                                                            <input type='hidden'  name='meta_description'>
                                                            <input type='hidden'  name='meta_title'>
                                                            <input type='hidden'  name='audio".$dataA[0]->slideid."'>
                                                            <input type='hidden'  name='video".$dataA[0]->slideid."'>
                                                            <input type='hidden' name='document".$dataA[0]->slideid."' id='document".$dataA[0]->slideid."' value=''>
                                                            <div class='form-group'>
                                                                <label class='col-md-2 control-label'>Description</label>
                                                                <div class='col-md-10'>
                                                                    <textarea class='form-control' id='description".$dataA[0]->slideid."' name='description".$dataA[0]->slideid."' placeholder='' rows='4'>".$dataA[0]->caption."</textarea>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <input type='hidden' name='oldimage' value='"; $slideElements.= isset($dataA[0]->slideimage) ? $dataA[0]->slideimage :""; $slideElements .="'>
                                                        <a href='#' dal='".$dataA[0]->slideid."' mspostid='".$post->id."' id='update".$dataA[0]->slideid."' class='update btn btn-primary btn-sm'>Update</a>
                                                        <a href='#' data-toggle='modal' data-target='#myModal".$dataA[0]->slideid."' class='btn btn-danger'><i class='fa fa-trash'>Delete</a></i> <!-- Modal -->
                                                        <div class='modal fade' id='myModal".$dataA[0]->slideid."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                                            <div class='modal-dialog'>
                                                                <div class='modal-content'>
                                                                    <div class='modal-header' style='background-color: #3276B1; color:#fff'>
                                                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
                                                                            &times;
                                                                        </button>
                                                                        <h1 class='modal-title' id='myModalLabel'>Remove slide <b>".$dataA[0]->slideid."</b></h1>
                                                                    </div>
                                                                    <div class='modal-body' id='mbody".$dataA[0]->slideid."'>
                                                                        <input type='hidden' name='oldimage".$dataA[0]->slideid."' value='";$slideElements.= isset($dataA[0]->slideimage) ? $dataA[0]->slideimage :""; $slideElements .="'>
                                                                        <div class='row' >
                                                                            <div class='col-md-12'>

                                                                                <input type='hidden' id='pgid".$dataA[0]->slideid."' name='pgid".$dataA[0]->slideid."'' value='".$dataA[0]->slideid."'>

                                                                                <h2>Are you sure you want to remove <b>".$dataA[0]->slidetitle."</b> from the database ?</h2>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <button type='button' class='btn btn-default' data-dismiss='modal'>
                                    Cancel
                                                                        </button>
                                                                        <button type='button' class='btn btn-primary datadel' mspostid='".$post->id."' dal='".$dataA[0]->slideid."'>
                                    Delete
                                                                        </button>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal --></p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>";
                }
            }
        }

        return $slideElements;
    }
}





#####  This function will proportionally resize image #####
/**
 * Resize image - preserve ratio of width and height.
 * @param string $sourceImage path to source JPEG image
 * @param string $targetImage path to final JPEG image file
 * @param int $maxWidth maximum width of final image (value 0 - width is optional)
 * @param int $maxHeight maximum height of final image (value 0 - height is optional)
 * @param int $quality quality of final image (0-100)
 * @return bool
 */
function resizeImage($sourceImage, $targetImage, $maxWidth, $maxHeight, $quality = 90,$image_type)
{
    // Obtain image from given source file.
    if (!$image = @imagecreatefromjpeg($sourceImage))
    {
        return false;
    }

    // Get dimensions of source image.
    list($origWidth, $origHeight) = getimagesize($sourceImage);

    if ($maxWidth == 0)
    {
        $maxWidth  = $origWidth;
    }

    if ($maxHeight == 0)
    {
        $maxHeight = $origHeight;
    }

    // Calculate ratio of desired maximum sizes and original sizes.
    $widthRatio = $maxWidth / $origWidth;
    $heightRatio = $maxHeight / $origHeight;

    // Ratio used for calculating new image dimensions.
    $ratio = min($widthRatio, $heightRatio);

    // Calculate new image dimensions.
    $newWidth  = (int)$origWidth  * $ratio;
    $newHeight = (int)$origHeight * $ratio;

    // Create final image with new dimensions.
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
    //imagejpeg($newImage, $targetImage, $quality);

        save_image($newImage, $targetImage, $image_type, $quality); //save resized image


    // Free up the memory.
    imagedestroy($image);
    imagedestroy($newImage);

    return true;
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

