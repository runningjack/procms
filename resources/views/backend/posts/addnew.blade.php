@extends("backend.layouts.default")
@section("content")
<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 9/9/16
 * Time: 12:44 PM
 */
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["posts"]["sub"]["addnew"]["active"] = true;
$breadcrumbs["posts"] =""
?>
<script src="{{url('')}}/js/app.config.js"></script>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<?php
//configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
//$breadcrumbs["New Crumb"] => "http://url.com"
//$breadcrumbs["Pages"] = "";
include("inc/ribbon.php");
?>
<?php //$user = \Toddish\Verify\Models\User::find(\Auth::user()->id); ?>
<!-- MAIN CONTENT -->

<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-code"></i> Posts <span>> Add New</span></h1>
    </div>
</div>

<section id="widget-grid">
    <section>
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <div class="text-left">
            {!! HTML::decode(HTML::linkRoute('postslisting','<span class="btn-label"><i class="glyphicon glyphicon-back"></i> Back to Posts'))!!}
        </div>
    </div>
    </section>


<div class="row">
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
{{ Form::open(array('', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) }}

<div class="col-sm-9">
    <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" role="widget" style="">

        <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus"></i></a>  </div>
            <span class="widget-icon"> <i class="fa fa-arrows-v"></i> </span>
            <h2 class="font-md"><strong>Set </strong> <i>Content</i></h2>

            <span class="jarviswidget-loader" style="display: none;"><!--<i class="fa fa-refresh fa-spin"></i>--></span>
        </header>

        <!-- widget div-->

        <div role="content" style="display: block;">

            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->

            </div>
            <!-- end widget edit box -->

            <!-- widget content -->
            <div class="widget-body">

                <fieldset>
                    <legend></legend>
                    @if($errors->has("title"))
                    <div class="alert alert-danger fade in">
                        <button class="close" data-dismiss="alert">×</button>
                        <i class="fa-fw fa fa-times"></i>{{$errors->first("title",":message")}}

                    </div>

                    @endif
                    @if($errors->has("permalink"))
                    <div class="alert alert-danger fade in">
                        <button class="close" data-dismiss="alert">×</button>
                        <i class="fa-fw fa fa-times"></i>{{$errors->first("permalink",":message")}}

                    </div>

                    @endif
                    @if($errors->has("p_content"))
                    <div class="alert alert-danger fade in">
                        <button class="close" data-dismiss="alert">×</button>
                        <i class="fa-fw fa fa-times"></i>{{$errors->first("p_content",":message")}}
                    </div>

                    @endif

                    <div class="form-group">
                        <label class="col-md-1 control-label">Title</label>
                        <div class="col-md-11">
                            <input class="form-control" placeholder="New Page Title" id="title" name="title" type="text" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-1 control-label">Url</label>
                        <div class="col-md-11">
                            <input class="form-control" placeholder="Page Url" id="permalink" name="permalink" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-1 control-label">Caption</label>
                        <div class="col-md-11">
                            <textarea class="form-control"  id="description" name="description" rows="4"></textarea>
                        </div>
                    </div>
                </fieldset>

                <input type="hidden" id="created_by" name="created_by">
                <input type="hidden" id="type" name="type" value="post">

            </div>
            <!-- end widget content -->

            <!-- widget content -->
            <div class="widget-body ">
                <textarea id="p_content" name="p_content"></textarea>
            </div>
            <!-- end widget content -->
            <div class="widget-body">
                <div class="col-sm-12">

                    <fieldset>
                        <legend>Meta Setting</legend>
                        <div class="form-group">
                            <label >Meta Title</label>

                            <textarea id="meta_title" name="meta_title" class="form-control" placeholder="Title" rows="4"></textarea>

                        </div>
                        <div class="form-group">
                            <label class="">Meta Keyword</label>

                            <textarea id="meta_keyword" name="meta_keyword" class="form-control" placeholder="Keyword" rows="4"></textarea>

                        </div>
                        <div class="form-group">
                            <label class="">Meta Description</label>

                            <textarea class="form-control" placeholder="Description" rows="4" name="meta_description" id="meta_description"></textarea>

                        </div>
                    </fieldset>

                </div>
            </div>
        </div>

        <!-- end widget div -->

    </div>
</div>
<div class="col-sm-3">
    <div class="jarviswidget jarviswidget-sortable" id="wid-id-12"  data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" role="widget">
        <header role="heading" class=""><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" data-loading-text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-title="Refresh"><i class="fa fa-refresh"></i></a>     </div>
            <h2><strong>Publish &amp;</strong> <i>Page Sttings</i></h2>
            <span class="jarviswidget-loader" style="display: none;"><!--<i class="fa fa-refresh fa-spin"></i></span>--></header>
        <!-- widget div-->
        <div role="content" class="">
            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->
            </div>
            <!-- end widget edit box -->
            <!-- widget content -->
            <div class="widget-body">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group"><?php //$user = \Toddish\Verify\Models\User::find(\Auth::user()->id); ?>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-cog"></i>
                            {{--@if($user->is("Editor"))
                            {{"Save"}}
                            @elseif($user->is(array("CMS Manager","Administrator","Moderator")))
                            @endif --}}
                            {{"Save &amp; Publish"}}
                        </button>
                        <!--<a class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-cog"></i> Save &amp; Publish</a>-->
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Select Layout</label>
                        <select class="form-control" id="layout" name="layout">
                            <option>default</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6" style="margin: 0; padding: 0">
                            <input class="form-control" id="sortorder" name="sortorder" placeholder="Sort Order" type="text">
                        </div>
                        <div class="col-md-6" >
                            <label class="checkbox-inline">
                                <input type="checkbox" id="view_status" name="view_status" value="visible" class="checkbox style-0">
                                <span>Hide</span>
                            </label>
                        </div>
                    </div>
                    <hr>
                </div>

            </div>
            <!-- end widget content -->
        </div>
        <!-- end widget div -->
    </div>
    <div class="jarviswidget jarviswidget-sortable" id="wid-id-13"  data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" role="widget">

        <header role="heading" class=""><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" data-loading-text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-title="Refresh"><!--<i class="fa fa-refresh"></i>--></a>     </div>
            <h2><strong>Categories</strong> <i></i></h2>

            <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span></header>

        <!-- widget div-->
        <div role="content" class="">

            <!-- widget edit box -->
            <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->

            </div>
            <!-- end widget edit box -->

            <!-- widget content -->
            <div class="widget-body">
                @foreach($categories as $category)
                <div class="radio">
                    <label>
                        <input type="radio" class="radiobox style-0" id="parent_id" name="parent_id"  value="{{$category->id}}">
                        <span>{{$category->title}}</span>
                    </label>
                </div>
                <!--<div class="form-group">
                    <div class="col-md-6" style="margin: 0; padding: 0">
                        <label class="radio">
                            <input type="radio" id="parent_id" name="parent_id" value="" class="radio smart-style-1">
                            <span></span>
                        </label>
                    </div>
                </div>-->
                @endforeach
            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>

    <div class="jarviswidget jarviswidget-sortable" id="wid-id-14"  data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" role="widget">

        <header role="heading" class=""><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" data-loading-text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-title="Refresh"><!--<i class="fa fa-refresh"></i>--></a>     </div>
            <h2><strong>Media</strong> <i></i></h2></header>
        <!-- widget div-->
        <div role="content" class="">
            <!-- widget content -->
            <div class="widget-body">
                <h4>Featured Image</h4>
                <div class="col-md-12" style="margin: 0; padding: 0">
                    <div id="imgg" style="background-color: #c3c3c3; padding: 10px; text-align: center">
                        <i class="fa fa-camera fa-5x"></i>
                    </div>
                    <a class="inline2" href="#inline_content2" >Browse</a>

                    <input type="hidden" id="image" name="image" value="">
                </div>
                <hr>
                <p>&nbsp;</p>
                <h4>Video Url</h4>
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <input class="form-control" id="video" name="video" placeholder="https://vimeo.com/78468485" type="text" value="">
                    </div>
                </div>

                <hr>
                <p>&nbsp;</p>
                <h4>Document <small>(.PDF,.DOC,.DOCX)</small></h4>
                <div class="col-12 col-md-12 col-lg-12">


                    <div class="form-group">

                        <div >
                            <input type="file" id="document" name="document" class="btn btn-default" style="width: 100%">
                            <p class="help-block">
                                Upload document here.
                            </p>
                        </div>
                    </div>

                </div>

            </div>
            <!-- end widget content -->

        </div>
        <!-- end widget div -->

    </div>
</div>

</form>
</div>

</section>
<div style='display:none'>
    <div id='inline_content2' style='padding:10px; background:#fff;'>

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
                {{Form::open(array('action'=>array('Backend\PostsController@postAddNew', ""), 'method'=>'post', 'class'=>'form-horizontal', 'files'=>true,"onSubmit"=>"return false","enctype"=>"multipart/form-data","id"=>"MyUploadForm")) }}
                <input name="image_file" id="imageInput" type="file" />
                <input type="hidden" name="faction" id="faction" value="featured image">
                <input type="submit"  id="submit-btn" value="Upload" />
                <img src="{{url('')}}/img/loading.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
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
                    $dir = opendir("./uploads/images/");

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
                        echo "<li><label><input class='form-control radio radimg' type='radio' id='input$i' name='inpute' value='$filelist[$i]'><img
                                  src='".url('')."/uploads/images/".$filelist[$i] ."' width='100' height='100'></label></li>";
                    }
                    echo "</ul>";
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
</div>
<script src="{{url('')}}/js/plugin/ckeditor/ckeditor.js"></script>
<script src="{{url('')}}/js/plugin/ckeditor/ckeditor.js"></script>
<script src="{{url('')}}/js/jquery.form.min.js"></script>
<link href="{{url('')}}/js/plugin/colorbox/example4/colorbox.css">
<script src="{{url('')}}/js/plugin/colorbox/jquery.colorbox-min.js"></script>


<script src="{{url('')}}/js/plugin/ckeditor/ckeditor.js"></script>
<script>
function getRootUrl(){
    var curLocation = location.href;
    var domain;
    //find & remove protocol (http, ftp, etc.) and get domain
    if (curLocation.indexOf("://") > -1) {
        domain = curLocation.split('/')[2];
    }
    else {
        domain = curLocation.split('/')[0];
    }
    //find & remove port number
    domain = domain.split(':')[0];
    return "http://"+domain;
}


    $(document).ready(function() {
        CKEDITOR.replace( 'p_content',
            {
                height: '380px', startupFocus : true,
                filebrowserBrowseUrl :''+getRootUrl()+'/js/plugin/ckeditor/filemanager/browser/default/browser.html?Connector='+getRootUrl()+'/js/plugin/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserImageBrowseUrl :''+getRootUrl() +'/js/plugin/ckeditor/filemanager/browser/default/browser.html?Type=Image&amp;Connector='+getRootUrl()+'/js/plugin/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserFlashBrowseUrl :''+getRootUrl() +'/js/plugin/ckeditor/filemanager/browser/default/browser.html?Type=Flash&amp;Connector='+getRootUrl()+'/js/plugin/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserUploadUrl  :''+getRootUrl() +'/js/plugin/ckeditor/filemanager/connectors/php/upload.php?Type=File',
                filebrowserImageUploadUrl :''+getRootUrl() +'/js/plugin/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
                filebrowserFlashUploadUrl : ''+getRootUrl() +'/js/plugin/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
            }
        );
        //CKEDITOR.replace( 'p_content', { height: '380px', startupFocus : true} );
        var perma =""
        // PAGE RELATED SCRIPTS

        // switch style change
        $('input[name="checkbox-style"]').change(function() {
            //alert($(this).val())
            $this = $(this);
            if ($this.attr('value') === "switch-1") {
                $("#switch-1").show();
                $("#switch-2").hide();
            } else if ($this.attr('value') === "switch-2") {
                $("#switch-1").hide();
                $("#switch-2").show();
            }
        });

        // tab - pills toggle
        $('#show-tabs').click(function() {
            $this = $(this);
            if($this.prop('checked')){
                $("#widget-tab-1").removeClass("nav-pills").addClass("nav-tabs");
            } else {
                $("#widget-tab-1").removeClass("nav-tabs").addClass("nav-pills");
            }

        });
        $("#title").keyup(function(){
            perma = $(this).val()
            perma = perma.replace(/\s/g,"-")
            perma = perma.toLowerCase()
            //alert("all good")
            $("#permalink").val(perma)
        })



        $(".inline2").colorbox({inline:true, width:"60%",height:"80%"});


        $(".radimg").each(function(){
            $(this).click(function(){
                $("#image").val($(this).val())
                $("#imgg").html("<img src='"+getRootUrl()+"/uploads/images/"+$(this).val()+ "' height='100' weight='100'>")
                return false
            })
        })


        // tab - pills toggle
        $('#show-tabs').click(function() {
            $this = $(this);
            if($this.prop('checked')){
                $("#widget-tab-1").removeClass("nav-pills").addClass("nav-tabs");
            } else {
                $("#widget-tab-1").removeClass("nav-tabs").addClass("nav-pills");
            }

        });


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
        function OnProgress(event, position, total, percentComplete)
        {
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
            var md = data.split("@@");
            $("#image").val(md[1])

            $("#imgg").html("<img src='"+getRootUrl()+"/uploads/images/"+md[1]+ "' height='100' weight='100'>")

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


    });
</script>
@stop