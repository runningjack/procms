@extends("backend.layouts.default")
@section("content")
<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 9/8/16
 * Time: 11:11 AM
 */
//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["posts"]["sub"]["addnew"]["active"] = true;

$breadcrumbs["Posts"] =""
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
        <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-code"></i> Pages <span>> All Listing</span></h1>
    </div>

</div>

<!-- widget grid -->
<section id="widget-grid" class="">

    <!-- row -->
    <div class="row">

        <article class="col-md-12">
        <section>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <div class="text-left">
                    {!! HTML::decode(HTML::linkRoute('pageslisting','<span class="btn-label"><i class="glyphicon glyphicon-back"></i> Back to Pages'))!!}
                </div>
            </div>
        </section>
        {{Form::open(array('', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) }}
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
            <div class="col-sm-9">
                <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" role="widget" style="">
                    <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus"></i></a>  </div>
                        <span class="widget-icon"> <i class="fa fa-arrows-v"></i> </span>
                        <h2 class="font-md"><strong>Set </strong> <i>Content</i></h2>
                        <!--<span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span>-->
                    </header>
                    <!-- widget div-->
                    <div role="content" style="display: block;">
                            <input type="hidden" id="created_by" name="created_by">
                            <input type="hidden" id="type" name="type" value="page">
                        <!-- widget content -->
                        <div class="widget-body ">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Title </label>
                                <div class="col-md-10">
                                    <input class="form-control" placeholder="New Page Title" id="title" name="title" type="text" required="required" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Url</label>
                                <div class="col-md-10">
                                    <input class="form-control" placeholder="Page Url" id="permalink" name="permalink" type="text" required="required" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-2 control-label">Page Description</label>
                                <div class="col-md-10">
                                    <input class="form-control input-lg" placeholder="Page Description" id="description" name="description" type="text">
                                </div>
                            </div>


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


                        <!-- widget content -->
                        <div class="widget-body">

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group"><?php //$user = \Toddish\Verify\Models\User::find(\Auth::user()->id); ?>
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-cog"></i>
                                        Save &amp; Publish
                                    </button>
                                    <!--<a class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-cog"></i> Save &amp; Publish</a>-->

                                </div>
                                <hr>

                                <div class="form-group">
                                    <label>Select Parent</label>
                                    <select class="form-control" id="parent_id" name="parent_id">
                                        <option value="">--SELECT PARENT PAGE--</option>
                                        @if(count($pages)>0)
                                        @foreach($pages as $page)
                                        <option value="{{$page->id}}">{{$page->title}}</option>
                                        @endforeach
                                        @endif

                                    </select>
                                </div>
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


            </div>
        </div>
        </form>
        </article>
        <!-- WIDGET END -->
    </div>
    <!-- end row -->
</section>
<!-- end widget grid -->
<!-- ==========================CONTENT ENDS HERE ========================== -->
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

        return domain;
    }


    $(document).ready(function() {
        CKEDITOR.replace( 'p_content',
            {
                height: '380px', startupFocus : true,
                filebrowserBrowseUrl :''+getRootUrl+'/js/plugin/ckeditor/filemanager/browser/default/browser.html?Connector='+getRootUrl+'/js/plugin/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserImageBrowseUrl :''+getRootUrl +'/js/plugin/ckeditor/filemanager/browser/default/browser.html?Type=Image&amp;Connector='+getRootUrl+'/js/plugin/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserFlashBrowseUrl :''+getRootUrl +'/js/plugin/ckeditor/filemanager/browser/default/browser.html?Type=Flash&amp;Connector='+getRootUrl+'/js/plugin/ckeditor/filemanager/connectors/php/connector.php',
                filebrowserUploadUrl  :''+getRootUrl +'/js/plugin/ckeditor/filemanager/connectors/php/upload.php?Type=File',
                filebrowserImageUploadUrl :''+getRootUrl +'/js/plugin/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
                filebrowserFlashUploadUrl : ''+getRootUrl +'/js/plugin/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
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
    });
</script>
@stop