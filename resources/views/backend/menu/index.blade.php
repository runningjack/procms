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
$page_nav["posts"]["sub"]["addnew"]["active"] = false;

$breadcrumbs["Posts"] =url('')."/backend/posts/index";
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


    <div id="dialog_simple" title="Dialog Simple Title">
        <div id="msg"></div>
        <p>
            {{ Form::open(array('url'=>'backend/posts/addnew/', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) }}

        <div class="row">
            <div class="col-md-3">
                <h5>Menu Title</h5>
            </div>
            <div class="col-md-9">


                <div class="input-group">
                    <input type="text" name="title" placeholder="Menu title" class="form-control" >
                    <span class="input-group-addon"><i class="fa fa-ticket"></i></span>
                </div>

                <!--<p class="help-block alert-warning">
                    Select a date if date is not the same as today. If this field is empty the system assigns current date
                </p>-->
            </div>
        </div>


        <div class="row">
            <div class="col-md-3">
                <h5>Url</h5>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <input type="hidden" id="type" name="type" value="custom menu" >
                    <input type="hidden" id="description" name="description">
                    <input type="hidden" id="p_content" name="p_content">
                    <input type="hidden" id="parent_id" name="parent_id">
                    <input type="hidden" id="meta_keyword" name="meta_keyword">
                    <input type="hidden" id="meta_description" name="meta_description">
                    <input type="hidden" id="meta_title" name="meta_title">

                    <input type="text" id="permalink" name="permalink" class="form-control input">
                    <span class="input-group-addon"><i class="fa fa-anchor"></i></span>
                    <!--<textarea class="form-control" id="description" name="description" placeholder="Decription" rows="4"></textarea>-->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-9">
                <section>
                    <p>&nbsp;</p>
                    <button class="btn btn-success" type="submit" id="submit" name="submit" ><i class='fa fa-save'></i> Save</button>

                </section>
            </div>
        </div>

        </form>
        </p>
    </div>

</div>
<div class="row">
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-code"></i> Menu <span>>
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
            <h2><strong>Menus</strong> <i></i></h2>

                    <span class="jarviswidget-loader" style="display: none;"><!--<i class="fa fa-refresh fa-
spin"></i></span>--></header>

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
                    <button  class="btn btn-info create-menu">Create Menu</button>
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
                        <h2>Memu Manager </h2>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget content -->
                        <div class="vfd">
                            <ul id="myTab2" class="nav nav-tabs bordered">
                                <li class="active">
                                    <a href="#v1" data-toggle="tab"><i class="fa fa-fw fa-lg fa-upload"></i>Menu Details</a>
                                </li>
                                <li id="mmenu">
                                    <a  href="#v2" data-toggle="tab"><i class="fa fa-fw fa-lg fa-camera"></i>Menu Management</a>
                                </li>
                            </ul>
                            <div id="myTabContent2" class="tab-content padding-10">
                                <div class="tab-pane fade in active" id="v1">
                                    <div class="row">
                                        {{ Form::open(array('action'=>array('Backend\PostsController@postAddNew', ""), 'method'=>'POST', 'class'=>'form-horizontal', "id"=>"regCategory")) }}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                            <h4 class="modal-title">Add New Menu Category</h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="row">
                                                <div class="col-md-3">
                                                    <input type="hidden" id="pgid" name="pgid">
                                                    <h5>Menu Title</h5>
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
                                                        <input type="hidden" id="post_type" name="post_type" value="menu category" >
                                                        <input type="hidden" name="description">
                                                        <textarea class="form-control textarea" id="p_content" name="p_content" placeholder="Description" rows="4"></textarea>
                                                        <span class="glyphicon glyphicon-comments form-control-feedback"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Menu Type</div>
                                                <div class="col-md-9">
                                                    <div class="form-group has-feedback">
                                                    <div class="radio">
                                                        <label>
                                                            <input type="radio" class="radiobox style-0 mainmenu" id="type" name="type" @if(isset($thisMenu) && $thisMenu->type =="mainmenu"){{"checked"}} @endif  value="mainmenu">
                                                            <span>Top of Page Menu</span>
                                                        </label>
                                                    </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="radiobox style-0 sidebar" id="type" name="type" @if(isset($thisMenu) && $thisMenu->type =="sidebar"){{"checked"}} @endif  value="sidebar">
                                                                <span>Side Bar Menu</span>
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="radiobox style-0 footer" id="type" name="type" @if(isset($thisMenu) && $thisMenu->type =="footer"){{"checked"}} @endif  value="footer">
                                                                <span>Footer Quick Link Menu</span>
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label>
                                                                <input type="radio" class="radiobox style-0 inpage" id="type" name="type" @if(isset($thisMenu) && $thisMenu->type =="inpage"){{"checked"}} @endif  value="inpage">
                                                                <span>In-Page Menu</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" >Save </button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="v2">
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-4">
                                            <div class="jarviswidget jarviswidget-sortable" id="wid-id-13" data-widget-
                                                 load="#" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-
                                                 togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-
                                                 custombutton="false" role="widget">

                                                <header role="heading" class=""><div class="jarviswidget-ctrls" role="menu"><a
                                                            href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" data-loading-
                                                            text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-
                                                            title="Refresh"><i class="fa fa-refresh"></i></a>     </div>
                                                    <h2><strong>Categories</strong> <i></i></h2>

                        <span class="jarviswidget-loader" style="display: none;"><!--<i class="fa fa-refresh fa-
    spin"></i></span>--></header>

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
                                                            @foreach($categories as $category)
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="checkbox style-0 cat" data-val="{{$category->title}}?#?{{$category->id}}?#?posts/{{$category->permalink}}">
                                                                    <span>{{$category->title}}</span>
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                            <a id="addcat" class="btn btn-info">Add Categories as Menu</a>
                                                            <p>&nbsp;</p>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- end widget div -->

                                            </div>

                                            <div class="jarviswidget jarviswidget-sortable" id="wid-id-12" data-widget-
                                                 load="ajax/demowidget.php" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-
                                                 togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-
                                                 custombutton="false" role="widget">

                                                <header role="heading" class=""><div class="jarviswidget-ctrls" role="menu"><a
                                                            href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" data-loading-
                                                            text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-
                                                            title="Refresh"><i class="fa fa-refresh"></i></a>     </div>
                                                    <h2><strong>Pages</strong> <i></i></h2>

                        <span class="jarviswidget-loader" style="display: none;"><!--<i class="fa fa-refresh fa-
    spin"></i></span>--></header>

                                                <!-- widget div-->
                                                <div role="content" class="">

                                                    <!-- widget edit box -->
                                                    <div class="jarviswidget-editbox">
                                                        <!-- This area used as dropdown edit box -->

                                                    </div>
                                                    <!-- end widget edit box -->

                                                    <!-- widget content -->
                                                    <div class="widget-body">
                                                        <a href="#" id="dialog_link" class="btn btn-labeled btn-success">
                                                            <span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span> Add New Custom link </a>
                                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="checkbox style-0 pg" data-val="Home?#?0?#?/">
                                                                    <span>Home</span>
                                                                </label>
                                                            </div>
                                                            @foreach($pages as $page)
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="checkbox style-0 pg" data-val="{{$page->title}}?#?{{$page->id}}?#?pages/{{$page->permalink}}">
                                                                    <span>{{$page->title}}</span>
                                                                </label>
                                                            </div>
                                                            @endforeach

                                                            @foreach($customs as $category)
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="checkbox style-0 pg" data-val="{{$category->title}}?#?{{$category->id}}?#?{{$category->permalink}}">
                                                                    <span>{{$category->title}}</span>
                                                                </label>
                                                            </div>
                                                            @endforeach
                                                            <span><a id="addpag" class="btn btn-info ">Add Pages as Menu</a></span>
                                                            <p>&nbsp;</p>
                                                        </div>

                                                    </div>

                                                </div>
                                                <!-- end widget div -->

                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-4" id="menuc">

                                            <h6></h6>
                                            <div id="msg"></div>
                                            <div class="dd" id="nestable2">
                                                <ol class="dd-list" id="ppp">
                                                    <?php
                                                    if($menus){
                                                        echo $menus;
                                                    }
                                                    ?>
                                                </ol>
                                            </div>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <div class="form-group">
                                                <!--<button  class="btn btn-primary"><i class="fa fa-cog"></i>Save &amp; Publish</button>-->
                                                <a class="btn btn-primary" id="savemenu" href="javascript:void(0);"><i class="fa fa-save"></i> Save Menu</a>
                                            </div>
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
        <input type="hidden" id="nestable2-output" rows="3" class="form-control font-md" value="{{$menupos->menu_jsondata}}">
        <!-- end row -->
    </section>
</div>
<!-- End section nine -->
</div>

<!-- PAGE RELATED PLUGIN(S) -->


<script type="text/javascript">
    function disableTab2(){
        if($("#menuc h6").html() == ""){$("#mmenu a").attr("disabled","true")}
    }

    function getRootUrl(){
        var curLocation = location.href;
        var domain;
        //find & remove protocol (http, ftp, etc.) and get domain
        if (curLocation.indexOf("://") > -1) {domain = curLocation.split('/')[2];}else {domain = curLocation.split('/')[0];}
        //find & remove port number
        domain = domain.split(':')[0];
        return "http://"+domain;
    }
    $(document).ready(function() {
        // PAGE RELATED SCRIPTS
        var l,p;
        var d=$(".myDelete");l=$("a.del");p=$("#myProcess")
        $(".datadel").each(function(){
            $(this).click(function(){
                var d = $(this).attr("dal")
                var bdmsg = "#mbody"+d;
                //alert(d)
                var pgid =($("#pgid"+d).val())
                var n =$("#imgname"+d).val()
                $("#mbody"+d).html("<img src='"+getRootUrl()+"/img/ajax-loader.gif' style='text-align: center'> ")
                $(this).hide();
                var u =""+getRootUrl()+"/backend/pages/edit/"+pgid

                $.ajax({url: u,type: 'post',data: {id:pgid,action:"delete",_token: $('meta[name="csrf_token"]').attr('content')},dataType: 'json',
                    success:function(data){  if(data.status==200){ $(bdmsg).html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data['data']+"</div>")}else if(data.status == 400){$(bdmsg).html("<div class='alert alert-error fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data.data+"</div>")}
                    else if(data['status']==500){$(bdmsg).html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data['data']+"</div>")} setInterval(window.location.reload(),50000)  }});
                //return false
            })

        })
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
            title : "<div class='widget-header'><h4><i class='fa fa-warning'></i> Add New Custom Menu</h4></div>"

        });

        $(".inline2").colorbox({inline:true, width:"80%",height:"80%"});

        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target), output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));
                //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 2
        $('#nestable2').nestable({
            group : 1
        }).on('change', updateOutput);

        // output initial serialised data

        updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        $("#addcat").on("click",function(){

            var pg = $(this).parents("div").find("input.cat:checked")
            $.each(pg,function(index,elem){

                var itemdata = $(this).attr("data-val");
                itemdata = itemdata.split("?#?");
                var mitem = $('<li class="dd-item" data-title="'+itemdata[0]+'" data-menu-id="'+$("#pgid").val()+'" data-post-id="'+itemdata[1]+'" data-parent-id="0" data-link="'+itemdata[2]+'" ><div class="dd-handle">'+itemdata[0]+'</div><i style="border-radius:13px; float:right; margin-top:-50px" class=" b fa fa-times-circle"></i></li>')
                $("#ppp").append(mitem);
            })
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        });

        $("#addpag").on("click",function(){

            var pg = $(this).parents("div").find("input.pg:checked")
            $.each(pg,function(index,elem){

                var itemdata = $(this).attr("data-val");
                itemdata = itemdata.split("?#?");
                var mitem = $('<li class="dd-item" data-title="'+itemdata[0]+'" data-menu-id="'+$("#pgid").val()+'" data-post-id="'+itemdata[1]+'" data-parent-id="0" data-link="'+itemdata[2]+'" ><div class="dd-handle">'+itemdata[0]+'</div><i style="border-radius:13px; float:right; margin-top:-50px" class=" b fa fa-times-circle"></i></li>')
                $("#ppp").append(mitem);
            })
            updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        });

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

                updateOutput($('#nestable2').data('output', $('#nestable2-output')));
            });

            request.fail(function(){
                alert("Request failed: ")
            })

            updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        })
        $("#menuc").on("click",".b",function(e){
            var mli =($(this).parents("li"))
            var id = mli.attr("data-id")
            var t = mli.attr("data-title")
            if(jQuery.type(id) === "undefined"){
                // alert(mli.attr("data-title"))
                mli.remove()
                updateOutput($('#nestable2').data('output', $('#nestable2-output')));
            }else{

                var request = $.ajax({
                    url:"index",
                    type:"post",
                    data: {id:id,title:t,val:$("#nestable2-output").val(),_token:$('meta[name="csrf_token"]').attr('content')},
                    dataType: "html"
                });

                request.done(function(msg){
                    //$("<span>updating</span>").insertAfter($(this))
                    updateOutput($('#nestable2').data('output', $('#nestable2-output')));

                    mli.remove()
                    /*if(msg==1){
                     $("#msg").html('<div class="alert alert-success fade in"><button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-check"></i><strong>Success</strong>  Record Saved.</div>')
                     }else{
                     $("#msg").html('<div class="alert alert-danger fade in"><button class="close" data-dismiss="alert">×</button><i class="fa-fw fa fa-times b"></i><strong>Unexpected error</strong>  Record not save</div>')
                     }
                     */
                    window.location.reload();

                });

                request.fail(function(){
                    alert("Request failed: ")
                })
                //alert(mli.attr("data-id"))
            }
        })

        /** Enable and disable widget*/


        /**
         * Click action to enable widget for creating and manage menu
         */
        $(".create-menu").on("click",function(e){ $(".well").removeClass("widget-disabled");$(".well").addClass("widget-enabled");  $("div.widget-enabled input[type='checkbox'],div.widget-enabled input[type='button'],div.widget-enabled a").removeAttr("disabled");});
        $(".edt").each(function(e){
            p.css("top","25% !important").css("left","25% !important");
            $(this).on("click",function(e){
                var pgid = $(this).attr("rel-data");
                var u =""+getRootUrl()+"/backend/menu/index/"+$(this).attr("rel-data");


                p.modal("show")
                $.ajax({url: u,type: 'get',data: {id:pgid,action:"edit",_token: $('meta[name="csrf_token"]').attr('content')},dataType: 'json',
                    success:function(data){
                        if(data["status"] == 200){
                            $("#title").val(data.data.title);
                            $("#permalink").val(data.data.permalink);
                            $("#p_content").val(data.data.p_content);
                            $("#description").val(data.data.description);
                            $("#pgid").val(data.data.id);
                            if(data.data.type =="mainmenu") {
                                $(".mainmenu").attr("checked",true);
                            }
                            if(data.data.type =="sidebar") {
                                $(".sidebar").attr("checked",true);
                            }
                            if(data.data.type =="footer") {
                                $(".footer").attr("checked",true);
                            }
                            if(data.data.type =="inpage") {
                                $(".inpage").attr("checked",true);
                            }
                            $(".well").removeClass("widget-disabled");$(".well").addClass("widget-enabled");  $("div.widget-enabled input[type='checkbox'],div.widget-enabled input[type='button'],div.widget-enabled a").removeAttr("disabled");
                            $("#ppp").html(data.menus);
                        }
                        p.modal("hide");
                        updateOutput($('#nestable2').data('output', $('#nestable2-output')));
                    }
                })
                return false;
            })

        })



    })

</script>
<div class="modal" id="myProcess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="transProcess" style=' width:317px; margin:10px auto' ><img src='<?= url('');?>/img/ajax-loader.gif'  ><h4>Processing Request... Please Wait!</h4></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@stop




