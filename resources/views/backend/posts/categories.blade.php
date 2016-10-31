@extends("backend.layouts.default")
@section("content")
<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 9/15/16
 * Time: 12:02 PM
 */

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
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
        <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-code"></i>Posts Categories <span>> Listing</span></h1>
    </div>
</div>

<!-- widget grid -->
<section id="widget-grid" class="">
    <!-- row -->
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
        <article class="col-md-12">

            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget jarviswidget-color-blue" id="wid-id-2" data-widget-editbutton="false">
                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>All Categories </h2>
                </header>
                <!-- widget div-->
                <div>
                    <!-- widget content -->
                    <div class="widget-body no-padding">
                        <div class="text-right">
                            <a href="return false" class="btn btn-primary btn-labeled" data-toggle="modal" data-target="#myModalCategoryNew" ><span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span>Add New</a>
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Sn</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Last Modified</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{--*/ $x = 1 /*--}}
                            @foreach($categories as $category)
                            <tr>
                                <td>{{$x}}</td>
                                <td>{{$category->title}}</td>
                                <td>{{$category->description}}</td>
                                <td>{{$category->status}}</td>
                                <td>{{$category->created_at}}</td>
                                <td>{{$category->updated_at}}</td>
                                <!-- <td><a href="#">Edit</a> </td>-->
                                <td><a href="#" data-toggle="modal" data-target="#myModal{{$category->id}}"><i class="fa fa-trash">Delete</a></i> <!-- Modal -->
                                    <div class='modal fade' id='myModal{{$category->id}}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header  ' style="background-color: #3276B1; color:#fff">
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
                                                        &times;
                                                    </button>
                                                    <h1 class='modal-title' id='myModalLabel'>Remove Page {{$category->title}}</h1>
                                                </div>
                                                <div class='modal-body' id="mbody{{$category->id}}">

                                                    <div class='row' >
                                                        <div class='col-md-12'>

                                                            <input type="hidden" id="pgid{{$category->id}}" name="pgid" value="{{$category->id}}">

                                                            <h2>Are you sure you want to remove <b>{{$category->title}} Category</b> from the database ?</h2>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='button' class='btn btn-default' data-dismiss='modal'>
                                                        Cancel
                                                    </button>
                                                    <button type='button' class='btn btn-primary datadel' dal="{{$category->id}}">
                                                        Delete
                                                    </button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal --> </td>
                            </tr>
                            {{--*/ $x++ /*--}}
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                    <!-- end widget content -->
                </div>
                <!-- end widget div -->
            </div>
            <!-- end widget -->
        </article>
        <!-- WIDGET END -->
        <!-- NEW WIDGET START -->
        <!-- WIDGET END -->
    </div>

    <!-- end row -->

</section>
<!-- end widget grid -->
<div class="modal fade" id="myModalCategoryNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            {{ Form::open(array('', 'method'=>'POST', 'class'=>'form-horizontal', "id"=>"regCategory")) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Add New Category</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-3">
                        <h5>Category Title</h5>
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
                        <h5>Url</h5>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control"  id="permalink" name="permalink"  required="required" value="">
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
                            <input type="hidden" id="type" name="type" value="post category" >
                            <input type="hidden" name="description">
                            <textarea class="form-control textarea" id="p_content" name="p_content" placeholder="Description" rows="4"></textarea>
                            <span class="glyphicon glyphicon-comments form-control-feedback"></span>
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
</div>

<div class="modal" id="myProcess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div id="transProcess" style=' width:317px; margin:10px auto' ><img src='<?= url('');?>/img/ajax-loader.gif'  ><h4>Processing Request... Please Wait!</h4></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

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

        var l,p;
        var d=$(".myDelete");l=$("a.del");p=$("#myProcess")

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
                $.ajax({url: ''+getRootUrl()+'/backend/posts/categories',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){ console.log(data);if(data){$("div#transProcess").html(data)};setInterval(window.location.reload(),5000);}});
            },errorPlacement : function(error, element) {
                error.insertAfter(element.parent());
            }
        });
        // PAGE RELATED SCRIPTS
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

        $("#title").keyup(function(){

            perma = $(this).val()
            perma = perma.replace(/\s/g,"-")
            perma = perma.toLowerCase()
            //alert("all good")
            $("#permalink").val(perma)
        })

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
                    else if(data['status']==500){$(bdmsg).html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data['data']+"</div>")}setInterval(window.location.reload(),500000);}} );
                //return false
            })
        })
    })

</script>
@stop