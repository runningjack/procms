<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 12/22/14
 * Time: 11:53 AM
 */
?>

@extends("backend.layouts.default")
@section("content")
<?php
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["slider"]["sub"]["addnew"]["active"] = false;
$breadcrumbs["Sliders"] =url('')."/backend/sliders/index";
?>
<script src="{{url('')}}/js/app.config.js" xmlns="http://www.w3.org/1999/html"></script>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->

<?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
//$breadcrumbs["Pages"] = "";
include("inc/ribbon.php");
?>
<?php //$user = \Toddish\Verify\Models\User::find(\Auth::user()->id); ?>

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-code"></i> Slider <span>>
Management</span></h1>

    </div>
    <div class="col-md-12">
        @if(Session::has('error_message'))
        <div class="alert alert-danger fade in">
            <button class="close" data-dismiss="alert">×</button>
            <i class="fa-fw fa fa-check"></i>{{Session::get('error_message')}}
        </div>
        @endif
        @if(Session::has('success_message'))
        <div class="alert alert-success fade in">
            <button class="close" data-dismiss="alert">×</button>
            <i class="fa-fw fa fa-check"></i>{{Session::get('success_message')}}
        </div>
        @endif

        @if ( ! empty( $errors ) )
        @foreach ( $errors->all() as $error )
        <div class="alert alert-danger fade in">
            <button class="close" data-dismiss="alert">×</button>
            <i class="fa-fw fa fa-times"></i>{{$error}}
        </div>
        @endforeach
        @endif
    </div>
</div>


<div class="row">
<div class="col-sm-3">
    <div class="jarviswidget jarviswidget-sortable " id="wid-id-9" data-widget-
         load="#" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-
         togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-
         custombutton="false" role="widget">

        <header role="heading" class=""><div class="jarviswidget-ctrls" role="menu"><a
                    href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" data-loading-
                    text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-
                    title="Refresh"><i class="fa fa-refresh"></i></a>     </div>
            <h2><strong>Slide Shows</strong> <i></i></h2>

                    <span class="jarviswidget-loader" style="display: none;"><!--<i class="fa fa-refresh fa-
spin"></i></span>--></header>

        <!-- widget div-->
        <div role="content" class="">
            <!-- widget content -->
            <div class="widget-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @foreach($menufposts as $page)
                    <div class="row" id="menu-cat-list">
                        <div class="col-md-8">{{$page->title}}</div>
                        <div class="col-md-2"><a href="javascript:void(0);" rel-data="{{$page->id}}" class="edt" act="edit"><i class="fa fa-edit"></i> </a></div>
                        <div class="col-md-2"><a  data-toggle="modal" data-target="#myModal{{$page->id}}" act="delete" ><i class="fa fa-trash"></i></a>
                        <!-- Modal to delete data -->
                             <!-- Modal -->
                            <div class='modal fade' id='myModal{{$page->id}}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <div class='modal-header  ' style="background-color: #3276B1; color:#fff">
                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
                                                &times;
                                            </button>
                                            <h1 class='modal-title' id='myModalLabel'>Remove Post {{$page->title}}</h1>
                                        </div>
                                        <div class='modal-body' id="mbody{{$page->id}}">

                                            <div class='row' >
                                                <div class='col-md-12'>
                                                    <input type="hidden" id="pgid{{$page->id}}" name="pgid" value="{{$page->id}}">
                                                    <h2>Are you sure you want to remove <b>{{$page->title}}</b> from the database ?</h2>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-default' data-dismiss='modal'>
                                                Cancel
                                            </button>
                                            <button type='button' class='btn btn-primary datadel' dal="{{$page->id}}">
                                                Delete
                                            </button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </div>
                    </div>
                    @endforeach
                    <p>&nbsp;</p>
                    <button  class="btn btn-info create-menu">Create</button>
                </div>
            </div>
        </div>
        <!-- end widget div -->
    </div>
</div>
<!-- Begin Section nine -->
<div class="col-sm-9">

    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-sm-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="well widget-disabled">
                    <header>
                        <h2>Slider Manager </h2>
                    </header>
                    <!-- widget div-->
                    <div>
                        <!-- widget content -->
                        <div class="vfd">
                            <ul id="Tab2" class="nav nav-tabs bordered">
                                <li id="slideshowtab" class="active">
                                    <a href="#slideTab1" data-toggle="tab">Slide-Show Details</a>
                                </li>
                                <li id="slideitemstab">
                                    <a  href="#slideTab2" data-toggle="tab">Slide Show Management</a>
                                </li>
                            </ul>
                            <div id="TabContent2" class="tab-content padding-10">
                                <div class="tab-pane fade in active" id="slideTab1">
                                    <div class="row">
                                        {{ Form::open(array( 'method'=>'POST', 'class'=>'form-horizontal', "id"=>"regCategory")) }}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Add New Slide-Show Category</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="hidden" id="postid" name="pgid">
                                                    <input type="hidden" id="slidemetadata" name="slidemetadata" >
                                                    <h5>Slider</h5>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group has-feedback">
                                                        <input type="text" class="form-control" id="title" name="title"  required="required" value="">
                                                        <span class="fa fa-li form-control-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">

                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group has-feedback">
                                                        <input type="hidden" class="form-control"  id="permalink" name="permalink"  required="required" value="">
                                                        <span class="glyphicon glyphicon-comments form-control-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <h5>Description</h5>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="form-group has-feedback">
                                                        <input type="hidden" id="post_type" name="post_type" value="slider" >
                                                        <input type="hidden" name="description">
                                                        <textarea class="form-control textarea" id="p_content" name="p_content" placeholder="Description" rows="4"></textarea>
                                                        <span class="glyphicon glyphicon-comments form-control-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Slider Positioning</div>
                                                <div class="col-md-9">
                                                    <div class="form-group has-feedback">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" class="radiobox style-0 homeslider" id="type" name="type" @if(isset($thisSlider) && $thisSlider->type =="homeslide"){{"checked"}} @endif  value="homeslider">
                                                            <span>Home Slider</span>
                                                        </label>
                                                    </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="radiobox style-0 productslider" id="type" name="type" @if(isset($thisSlider) && $thisSlider->type =="productslider"){{"checked"}} @endif  value="productslider">
                                                                <span>Product Slider</span>
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="radiobox style-0 inpageslider" id="type" name="type" @if(isset($thisSlider) && $thisSlider->type =="inpageslider"){{"checked"}} @endif  value="inpageslider">
                                                                <span>In-page Slider</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" > Save </button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="slideTab2">
                                <div class="text-right">
                                    <a href="#" data-toggle="modal" data-target="#myModalDriverNew" class="btn btn-labeled btn-success">
                                        <span class="btn-label"><i class="glyphicon glyphicon-plus"></i> Add New </a></div>
                                    <div class="row">
                                        <div class="panel-group smart-accordion-default" id="accordion">
                                            @foreach($slideshows as $slideshow)
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#{{$slideshow->id}}" class="collapsed">
                                                            <i class="fa fa-lg fa-angle-down pull-right"></i> <i class="fa fa-lg fa-angle-up pull-right"></i>
                                                            Slide {{$slideshow->id}} </a>
                                                    </h4>
                                                </div>
                                                <div id="{{$slideshow->id}}" class="panel-collapse collapse" style="height: 0px;">
                                                    <div class="panel-body">
                                                        {{ Form::open(array('action'=>array('Backend\HomeController@postEditPage', $slideshow->id), 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'$slideshow->id')) }} <!--<form class="form-horizontal" id="{{$slideshow->id}}" method="get">-->
                                                        <fieldset>
                                                            <legend>Slide #{{$slideshow->id}}</legend>
                                                            <input type="hidden" id="id" name="id" value="{{$slideshow->id}}">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    @foreach($slideimages as $image)
                                                                    <label class="radio radio-inline">
                                                                        <input type="radio" id="image" name="image" class="radiobox" value="{{$image->img_name}}" @if($image->img_name == $slideshow->image) {{"checked"}} @endif>
                                                                        <span><img src="{{ASSETS_URL}}/uploads/slideshow/{{$image->img_name}}"  style="width:90px; height:55px" ></span>
                                                                    </label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label">Title</label>
                                                                <div class="col-md-10">
                                                                    <input class="form-control" name="title" id="title" type="text" value="{{$slideshow->title}}">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label">Url</label>
                                                                <div class="col-md-10">
                                                                    <input class="form-control"  name="permalink" placeholder="" type="text" value="{{$slideshow->permalink}}" >
                                                                </div>
                                                            </div>
                                                            <input type="hidden"  name="type" value="slideshow" >
                                                            <input type="hidden"  name="p_content" value="{{$slideshow->p_content}}">
                                                            <input type="hidden" name="parent_id">
                                                            <input type="hidden"  name="meta_keyword">
                                                            <input type="hidden"  name="meta_description">
                                                            <input type="hidden"  name="meta_title">
                                                            <input type="hidden"  name="audio">
                                                            <input type="hidden"  name="video">
                                                            <input type="hidden" name="document" id="document" value="">
                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label">Description</label>
                                                                <div class="col-md-10">
                                                                    <textarea class="form-control" name="description" placeholder="" rows="4">{{$slideshow->description}}</textarea>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <input type="hidden" name="oldimage" value="{{$slideshow->image}}">
                                                        <input type="submit" name="update" value="update"  class="btn btn-primary btn-sm">
                                                        <a href="#" data-toggle="modal" data-target="#myModal{{$slideshow->id}}" class="btn btn-danger"><i class="fa fa-trash">Delete</a></i> <!-- Modal -->
                                                        <div class='modal fade' id='myModal{{$slideshow->id}}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                                            <div class='modal-dialog'>
                                                                <div class='modal-content'>
                                                                    <div class='modal-header  ' style="background-color: #3276B1; color:#fff">
                                                                        <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
                                                                            &times;
                                                                        </button>
                                                                        <h1 class='modal-title' id='myModalLabel'>Remove slide <b>{{$slideshow->title}}</b></h1>
                                                                    </div>
                                                                    <div class='modal-body' id="mbody{{$slideshow->id}}">
                                                                        <input type="hidden" name="oldimage{{$slideshow->id}}" value="{{$slideshow->image}}">
                                                                        <div class='row' >
                                                                            <div class='col-md-12'>

                                                                                <input type="hidden" id="pgid{{$slideshow->id}}" name="pgid{{$slideshow->id}}" value="{{$slideshow->id}}">

                                                                                <h2>Are you sure you want to remove <b>{{$slideshow->title}}</b> from the database ?</h2>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class='modal-footer'>
                                                                        <button type='button' class='btn btn-default' data-dismiss='modal'>
                                                                            Cancel
                                                                        </button>
                                                                        <button type='button' class='btn btn-primary datadel' dal="{{$slideshow->id}}">
                                                                            Delete
                                                                        </button>
                                                                    </div>
                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal --></p>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end widget content -->
                    </div>
                    <!-- end widget div -->
                </div>
                <!-- end widget -->
            </article>
            <!-- WIDGET END -->
        </div>
        <!-- end row -->
        <!-- row -->
        <input type="hidden" id="nestable2-output" rows="3" class="form-control font-md" value="">
        <!-- end row -->

    </section>
</div>
<!-- End section nine -->
</div>


<div style='display:none'>
    <div id='inline_content2' style='padding:10px; background:#fff;'></div>
</div>
<div class="modal  fade" id="myModalDriverNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Manage Slider Components</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-9">
                <ul id="myTab2" class="nav nav-tabs bordered">
                    <li class="active">
                        <a href="#v1" data-toggle="tab"><i class="fa fa-fw fa-lg fa-upload"></i>Upload File</a>
                    </li>
                    <li>
                        <a href="#v2" data-toggle="tab"><i class="fa fa-fw fa-lg fa-camera"></i>Images</a>
                    </li>
                </ul>
                <div id="myTabContent2" class="tab-content padding-10">
                    <div class="tab-pane fade in active" id="v1">
                        {{Form::open(array('action'=>array('Backend\SlidersController@postIndex', ""), 'method'=>'post', 'class'=>'form-horizontal', 'files'=>true,"onSubmit"=>"return false","enctype"=>"multipart/form-data","id"=>"MyUploadForm")) }}
                        <input name="image_file" id="imageInput" type="file" />
                        <input type="submit"  id="submit-btn" value="Upload" />
                        <img src="{{url('')}}/img/loading.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
                        <input type="hidden" id="post_meta" name="post_meta">

                        </form>
                        <div id="progressbox" style="display:none;"><div id="progressbar"></div><div id="statustxt">0%</div></div>
                        <div id="output">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="v2">
                        <div id="mmd">
                            <h3>Images</h3>
                            <?php
                            //Open images directory
                            $dir = opendir(public_path()."/uploads/images/");

                            //List files in images directoryb
                            while (($file = readdir($dir)) !== false) {
                                if(substr( $file, -3 ) == "jpg" || substr( $file, -3 ) == "png" || substr( $file, -3 ) == "JPG" ) {
                                    $filelist[] = $file;
                                }
                            }
                            closedir($dir);
                            sort($filelist);
                            echo "<ul class='imglist'>";
                            for($i=0; $i<count($filelist); $i++) {
                                $posts = \App\Post::where("type","=","slide image")->get();
                                if(count($posts)){
                                    $posdata = "";
                                    foreach($posts as $post){
                                        if($post->image == $filelist[$i] ){
                                            $posdata = $post->post_meta;
                                        }
                                    }

                                    if(!empty($posdata)){
                                            echo "<li><label><input class='form-control radio radimg' type='radio' data-meta='"; if ($posdata !="") { echo json_encode($posdata); }else{echo "";} ""; echo"' id='input$i' name='input' value='$filelist[$i]'><img
                                      src='".url('')."/uploads/images/".$filelist[$i] ."' width='100' height='100'></label></li>";$posdata="";
                                        }else{
                                            echo "<li><label><input class='form-control radio radimg' data-meta='' type='radio' id='input$i' name='input' value='$filelist[$i]'><img
                                      src='".url('')."/uploads/images/".$filelist[$i] ."' width='100' height='100'></label></li>";
                                        }


                                }else{
                                    echo "<li><label><input class='form-control radio radimg' data-meta='' type='radio' id='input$i' name='input' value='$filelist[$i]'><img
                                      src='".url('')."/uploads/images/".$filelist[$i] ."' width='100' height='100'></label></li>";
                                }


                            }
                            echo "</ul>";
                            ?>
                            <?php

                            ?>
                        </div>
                        <br clear="all">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <p>&nbsp;</p>

                                <a href="#" class="btn btn-img btn-primary">Set As Setting</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="col-md-3">
            <h6>Image Setting</h6>
                <form class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="hidden" name="slideid" id="slideid" ><!--Input to hide slideid-->
                            <input type="hidden" name="slideitempostmeta" id="slideitempostmeta" ><!--Input to hide slidepostmetadata-->
                            <input class="form-control"  id="slidetitle" name="slidetitle" placeholder="Title" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <!--<label>Link</label>-->
                            <input class="form-control"  id="link" name="link" placeholder="Link" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <!--<label>Caption</label>-->
                            <input class="form-control"  id="caption" name="caption" placeholder="Caption" multiple type="text">
                        </div>
                    </div>

                <div class="form-group">
                    <div class="col-md-6">
                        <!--<label>Width</label>-->
                        <input class="form-control"  id="width" name="width" placeholder="Width" type="text">
                    </div>

                    <div class="col-md-6">
                        <!--<label>Height</label>-->
                        <input class="form-control" id="height" name="height" placeholder="Height" type="text">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <!--<label>Thumb Width</label>-->
                        <input class="form-control"  id="thumbwidth" name="thumbwidth" placeholder="Width" type="text">
                    </div>

                    <div class="col-md-6">
                        <!--<label>Thumb Height</label>-->
                        <input class="form-control" id="thumbheight" name="thumbheight" placeholder="Height" type="text">
                    </div>
                </div>

                </form>
        </div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="setslideitem" >Set As Slide Item</button> <button type="submit" class="btn btn-primary" >Update </button>
            </div>
        </div>
    </div>
</div>
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{url('')}}/js/jquery.form.min.js"></script>
<link href="{{url('')}}/js/plugin/colorbox/example4/colorbox.css">
<script src="{{url('')}}/js/plugin/colorbox/jquery.colorbox-min.js"></script>

<script type="text/javascript">
   var jsonObj= [];

   var parentSliderObj = []
    var item= new Object();
   var parentSliderItem =  new Object();

   item["postid"]=$("#postid").val();
   item["slideid"]=0;



    function getRootUrl(){
        var curLocation = location.href;
        var domain;
        //find & remove protocol (http, ftp, etc.) and get domain
        if (curLocation.indexOf("://") > -1) {domain = curLocation.split('/')[2];}else {domain = curLocation.split('/')[0];}
        //find & remove port number
        domain = domain.split(':')[0];
        return "http://"+domain;
    }

    function createJSONItem(field,val) {
        var d = new Object();
        d[field] = val;
        item =  $.extend(d,item) //extend the two objects to form one
        /**
         * Check if property already exist
         * in the item object then change
         * the value to current value
         */
        if(item.hasOwnProperty(field)){
            item[field] = val;
        }
        jsonObj.length = null; //
        jsonObj.push(item)
        //console.log(jsonObj.link)
    }
   /**
    * Method to populate slider parent post meta
    * slideId***slider ID
    * value***value
    * elem*** elements to push value to
    *
    */
   function createMainSlideJsonItem(slideId,val,elem){

       //console.log(val)
       if(val instanceof Object == true){
           var k = new Object();
           var w =new Object();
           k[slideId] = (val);

           //parentSliderItem = w;
           //parentSliderItem= merge_options(w,k);// parentSliderItem.concat(w)
           //parentSliderObj.push(k)
           $.extend(parentSliderItem,k)

           //parentSliderItem.push(w)
           /*if(parentSliderItem.hasOwnProperty(slideId)){
               $.extend(parentSliderItem,k)
           }*/
          parentSliderObj.length =null

           parentSliderObj.push(parentSliderItem)

           console.log((parentSliderObj))
           elem.val(JSON.stringify(parentSliderObj));
       }
   }

   function merge_options(obj1,obj2){
       var obj3 = {};
        $.extend(obj3,obj1)
       $.extend(obj3,obj2)
      // for (var attrname in obj1) { obj3[attrname] = obj1[attrname]; }
      //for (var attrname in obj2) { obj3[attrname] = obj2[attrname]; }
       return obj3;
   }

    $(document).ready(function() {
        $("#height,#width,#thumbheight,#thumbwidth,#slidetitle,#link,#caption").on("blur",function(){
            if($(this).length > 0){
                createJSONItem($(this).attr("name"),$(this).val());

            }
            var j = JSON.parse(JSON.stringify(jsonObj))
            $("#post_meta").val(JSON.stringify(jsonObj))
        })

        // PAGE RELATED SCRIPTS
        var l, p,pgid;
        var d=$(".myDelete");l=$("a.del");p=$("#myProcess")
        $(".inline2").colorbox({inline:true, width:"60%",height:"80%"});


        var validator = $('#fr').validate({
            rules: {
                title: {required: true,minlength : 2},
                permalink: {required: true,minlength : 2}

            },messages : {
                title : {
                    required : 'Please enter a title'
                },
                permalink : {
                    required : 'Permalink is field is required'
                }
            },submitHandler: function(form) {
                $("#myModalCategoryNew").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: getRootUrl()+'/backend/sliders/index',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){ console.log(data);if(data.status=="200"){
                        $("div#menu-cat-list").prepend("<div")
                        $("div#transProcess").html(data.msg)} ;/*setInterval(window.location.reload(),50000);*/}});
            },errorPlacement : function(error, element) {
                error.insertAfter(element.parent());
            }
        });

        var validator = $('#regCategory').validate({
            rules: {
                title: {required: true,minlength : 2},
                permalink: {required: true,minlength : 2}

            },messages : {
                title : {
                    required : 'Please enter a title'
                },
                permalink : {
                    required : 'Permalink is field is required'

                }
            },submitHandler: function(form) {
                $("#myModalCategoryNew").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: getRootUrl()+'/backend/posts/categories',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){ console.log(data);if(data.status=="200"){
                        $("div#menu-cat-list").prepend("<div")
                        $("div#transProcess").html(data.msg)} ;/*setInterval(window.location.reload(),50000);*/}});
            },errorPlacement : function(error, element) {
                error.insertAfter(element.parent());
            }
        });

        $("#inline_content2 input[type='text']").attr("disabled",false)

        $("#setslideitem").on("click",function(){
            pgid = $("#postid").val()
            p.modal("show")
            $.ajax({url:'',type:'post',data:{action:"update main slider",_token: $('meta[name="csrf_token"]').attr('content'),postmeta:$("#slidemetadata").val(),postid:pgid},success:function(data){
                if(data.status == 200)
                $("#accordion").html(data.data)
                $("#myModalDriverNew").modal("hide")
                $("div#transProcess").html(data.msg)
            },fail:function(data){
                $("#myModalDriverNew").modal("hide")
                $("div#transProcess").html(data.msg)
            }})
        })

        $("#title").keyup(function(){
            perma = $(this).val()
            perma = perma.replace(/\s/g,"-")
            perma = perma.toLowerCase()
            //alert("all good")
            $("#permalink").val(perma)
        })

        $("#title").on("blur",function(){

            perma = $(this).val()
            perma = perma.replace(/\s/g,"-")
            perma = perma.toLowerCase()
            //alert("all good")
            $("#permalink").val(perma)
        })

        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title : function(title) {
                if (!this.options.title) {
                    title.html("&#160;");
                } else {
                    title.html(this.options.title);
                }
            }
        }));

        $('#dialog_link').click(function() {
            $('#dialog_simple').dialog('open');
            return false;

        });
        $('#dialog_simple').dialog({
            autoOpen : false,
            width : 600,
            resizable : false,
            modal : true,
            title : "<div class='widget-header'><h4><i class='fa fa-warning'></i> Add Image to Slide </h4></div>"

        });
        $(".radimg").each(function(){
            $(this).click(function(){
                createJSONItem("slideimage",$(this).val());
                var dat =null;
                dat =  $(this).attr("data-meta");
                dat = (dat.replace(/\[|\]/g,''))

                var slideJson = null
                slideJson = dat.length > 0 ? JSON.parse(JSON.parse($(this).attr("data-meta"))) : null;
                if(slideJson != null){

                    if(slideJson[0].hasOwnProperty("link")){$("#link").val(slideJson[0].link);}
                    if(slideJson[0].hasOwnProperty("slidetitle")){$("#slidetitle").val(slideJson[0].slidetitle);}
                    if(slideJson[0].hasOwnProperty("slideid")){$("#slideid").val(slideJson[0].slideid);}
                    if(slideJson[0].hasOwnProperty("caption")){$("#caption").val(slideJson[0].caption);}
                    if(slideJson[0].hasOwnProperty("width")){$("#width").val(slideJson[0].width);}
                    if(slideJson[0].hasOwnProperty("height")){$("#height").val(slideJson[0].height);}
                    if(slideJson[0].hasOwnProperty("thumbwidth")){$("#thumbwidth").val(slideJson[0].thumbwidth);}
                    if(slideJson[0].hasOwnProperty("thumbheight")){$("#thumbheight").val(slideJson[0].thumbheight);}
                    $("#slideitempostmeta").val($(this).attr("data-meta"))

                    var daa = $("#slideitempostmeta").val()
                    daa = daa.replace(/^\"/,"")
                    daa = daa.replace(/\"$/,"")
                    //daa = daa.replace(/\]/,"")
                    //daa = daa.replace(/\[/,"")
                   //// daa = (daa.replace(/\[|\]/g,''))
                    daa = daa.replace(/\\/g,"")
                    createMainSlideJsonItem($("#slideid").val(),(JSON.parse(daa)),$("#slidemetadata"))


                }else{
                    $("#link").val("")
                    $("#slidetitle").val("")
                    $("#caption").val("")
                    $("#width").val("")
                    $("#height").val("")
                    $("#thumbheight").val("")
                    $("#thumbwidth").val("")
                    $("#slideid").val("");
                    $("#slideitempostmeta").val("")
                }
                $("#image").val($(this).val())
                $("#imgg").html("<img src='"+getRootUrl()+"/uploads/images/"+$(this).val()+ "' height='100' weight='100'>")
                return false
            })
        })

        $(".inline2").colorbox({inline:true, width:"80%",height:"80%"});
        $("#savemenu").click(function(){
            var request = $.ajax({
                url:"index",
                type:"post",
                data: {id:2,val:$("#nestable2-output").val(),_token:$('meta[name="csrf_token"]').attr('content')},
                dataType: "html"
            });

            request.done(function(msg){
                //$("<span>updating</span>").insertAfter($(this))
                if(msg==1){
                    $("#msg").html('<div class="alert alert-success fade in"><button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-check"></i><strong>Success</strong>  Record Saved.</div>')
                }else{
                    $("#msg").html('<div class="alert alert-danger fade in"><button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-times b"></i><strong>Unexpected error</strong>  Record not save</div>')
                }
            });

            request.fail(function(){
                alert("Request failed: ")
            })
        })

        $(".well").one("mouseover",function(e){
            $(".datadel").each(function(){
                $(this).click(function(){
                    var d = $(this).attr("dal");
                    console.log(d);
                    var bdmsg = "#mbody"+d;
                    //alert(d)
                    pgid =($(this).attr("mspostid"))
                    var n =$("#imgname"+d).val()
                    $("#mbody"+d).html("<img src='"+getRootUrl()+"/img/ajax-loader.gif' style='text-align: center'> ")

                    var u =getRootUrl()+"/backend/sliders/index/"+pgid
                    $("#myModal"+d).modal("hide")
                    $(this).hide();
                    p.modal("show")
                    $.ajax({url: u,type: 'post',data: {action:"delete main slider item",_token: $('meta[name="csrf_token"]').attr('content'),postid:pgid,id:d},dataType: 'json',
                        success:function(data){
                            if(data.status==200){
                                $("#accordion").html(data.data)
                                $("div#transProcess").html(data.msg)
                                p.modal("show")
                            }else if(data.status == 400){
                                $("div#transProcess").html(data.msg)
                                p.modal("show")
                            }else if(data['status']==500){
                                $("div#transProcess").html(data.msg)
                                p.modal("show")
                            }
                        }
                    });
                    //return false
                })
            })

            $(".update").each(function(){
                $(this).click(function(){
                    var d = $(this).attr("dal");
                    pgid =($(this).attr("mspostid"))
                    var u =getRootUrl()+"/backend/sliders/index/"+pgid
                    var title = $("#title"+d).val()
                    var descrip = $("#description"+d).val()
                    var link = $("#permalink"+d).val()

                    p.modal("show")
                    $.ajax({url: u,type: 'post',data: {action:"update main slider item",_token: $('meta[name="csrf_token"]').attr('content'),postid:pgid,id:d,title:title,descript:descrip,link:link},dataType: 'json',
                        success:function(data){
                            if(data.status==200){
                                $("#accordion").html(data.data)
                                $("div#transProcess").html(data.msg)
                                p.modal("show")
                            }else if(data.status == 400){
                                $("div#transProcess").html(data.msg)
                                p.modal("show")
                            }else if(data['status']==500){
                                $("div#transProcess").html(data.msg)
                                p.modal("show")
                            }
                        }
                    });
                })
            })
            e.preventDefault()
        })

        /** Enable and disable widget*/
        /**
         * Click action to enable widget for creating and manage menu
         */
        $(".create-menu").on("click",function(e){
            $(".well").removeClass("widget-disabled");$(".well").addClass("widget-enabled");
            $("div.widget-enabled input[type='checkbox'],div.widget-enabled input[type='button'],div.widget-enabled a").removeAttr("disabled");
            $("#slideshowtab").addClass("active").addClass("in");$("#slideitemstab").removeClass("active");$("#slideTab1").addClass("active").addClass("in");$("#slideTab2").removeClass("active")
            $("#slideTab1 input[id='title']").val("");$("#slideTab1 div form#regCategory textarea#p_content").val("");$("#accordion").html("")
            $("#postid").val("")
        });
        $(".edt").each(function(e){
            p.css("top","25% !important").css("left","25% !important");
            $(this).on("click",function(e){
                var id = $(this).attr("rel-data");
                var u =""+getRootUrl()+"/backend/sliders/index/"+$(this).attr("rel-data");
                p.modal("show")
                $.ajax({url: u,type: 'get',data: {id:id,action:"edit",_token: $('meta[name="csrf_token"]').attr('content')},dataType: 'json',
                    success:function(data){
                        console.log(data)
                        if(data["status"] == 200){
                            $("#title").val(data.data.mypost.title);
                            $("#permalink").val(data.data.mypost.permalink);
                            $("#p_content").val(data.data.mypost.p_content);
                            $("#description").val(data.data.mypost.description);
                            $("#postid").val(data.data.mypost.id);
                            item['postid'] = data.data.mypost.id
                            if(data.data.mypost.type =="homeslider") {
                                $(".homeslider").attr("checked",true);
                            }
                            if(data.data.mypost.type =="productslider") {
                                $(".productslider").attr("checked",true);
                            }
                            if(data.data.mypost.type =="inpageslider") {
                                $(".inpageslider").attr("checked",true);
                            }
                            pgid = $("#postid").val();
                            $(".well").removeClass("widget-disabled");$(".well").addClass("widget-enabled");  $("div.widget-enabled input[type='checkbox'],div.widget-enabled input[type='button'],div.widget-enabled a").removeAttr("disabled");
                            $("#accordion").html(data.data.accordion);

                        }
                        p.modal("hide");
                    }
                })
                return false;
            })

        })
    })

    var progressbox     = $('#progressbox');
    var progressbar     = $('#progressbar');
    var statustxt       = $('#statustxt');
    var completed       = '0%';

    var options = {
        target:   '#output',   // target element(s) to be updated with server response
        beforeSubmit:  beforeSubmit,  // pre-submit callback
        uploadProgress: OnProgress,
        success:       afterSuccess,  // post-submit callback
        resetForm: true        // reset the form after successful submit
    };

    $('#MyUploadForm').submit(function() {
        $(this).ajaxSubmit(options);
        // return false to prevent standard browser submit and page navigation
        return false;
    });

    //when upload progresses
    function OnProgress(event, position, total, percentComplete){
        //Progress bar
        progressbar.width(percentComplete + '%') //update progressbar percent complete
        statustxt.html(percentComplete + '%'); //update status text
        if(percentComplete>50)
        {
            statustxt.css('color','#fff'); //change status text to white after 50%
        }
    }

    //after succesful upload
    function afterSuccess(data)
    {

        $('#submit-btn').show(); //hide submit button
        $('#loading-img').hide(); //hide submit button
        //alert(data)

        if(data.status == 200){
            var md = data.img.split("@@");
            $("#image").val(md[1])
            $("#imgg").html("<img src='"+getRootUrl()+"/uploads/images/"+md[1]+ "' height='100' weight='100'>")
            $("#output").html("<img src='"+getRootUrl()+"/uploads/images/"+md[1]+ "' height='100' weight='100'>")
        }else if(data.status ==400){
            $('#submit-btn').show();
        }

    }

    //function to check file size before uploading.
    function beforeSubmit(){
        //check whether browser fully supports all File API
        if (window.File && window.FileReader && window.FileList && window.Blob)
        {

            if( !$('#imageInput').val()) //check empty input filed
            {
                $("#output").html("Oops please load a file?");
                return false
            }

            var fsize = $('#imageInput')[0].files[0].size; //get file size
            var ftype = $('#imageInput')[0].files[0].type; // get file type

            //allow only valid image file types
            switch(ftype)
            {
                case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
                default:
                    $("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                    return false
            }

            //Allowed file size is less than 1 MB (1048576)
            if(fsize>1048576)
            {
                $("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                return false
            }

            //Progress bar
            progressbox.show(); //show progressbar

            progressbar.width(completed); //initial value 0% of progressbar
            statustxt.html(completed); //set status text
            statustxt.css('color','#000'); //initial color of status text


            $('#submit-btn').hide(); //hide submit button
            $('#loading-img').show(); //hide submit button
            $("#output").html("");
        }
        else
        {
            //Output error to older unsupported browsers that doesn't support HTML5 File API
            $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
            return false;
        }
    }

    //function to format bites bit.ly/19yoIPO
    function bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Bytes';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }

</script>
<div class="modal" id="myProcess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div id="transProcess" style=' width:317px; margin:10px auto' ><img src='<?= url('');?>/img/ajax-loader.gif'  ><h4>Processing Request... Please Wait!</h4></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@stop




