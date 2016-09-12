@extends("backend.layouts.default")
@section("content")
<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 9/8/16
 * Time: 11:10 AM
 */

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["pages"]["sub"]["list"]["active"] = false;

$breadcrumbs["pages"] =""
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

                <!-- NEW WIDGET START -->

                <!-- WIDGET END -->

                <!-- NEW WIDGET START -->
                <article class="col-md-12">

                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget jarviswidget-color-blue" id="wid-id-2" data-widget-collapsed="false" data-widget-editbutton="false" data-widget-fullscreenbutton="true" data-widget-colorbutton="true">

                        <header>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>All Pages </h2>

                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body no-padding">

                                <div class="text-right">
                                    {{--@if($user->can('create_post'))--}}
                                    {!!HTML::decode(HTML::linkRoute('addnewpage','<span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span> Add New','new',array("class"=>"btn btn-labeled btn-primary")))!!}
                                    {{--@endif--}}
                                </div>
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Sn</th>
                                        <th>Title</th>
                                        <th>Permalink</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Last Modified</th>
                                        <th>Action</th>
                                        <th>s</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {{--*/ $x = 1 /*--}}
                                    @foreach($pages as $page)
                                    <tr>
                                        <td>{{$x }}</td>
                                        <td>{{$page->title}}</td>
                                        <td>{{$page->permalink}}</td>
                                        <td>{{$page->status}}</td>
                                        <td>{{date_format(date_create($page->created_at),"Y/m/d")}}</td>
                                        <td>{{date_format(date_create($page->updated_at),"Y/m/d")}}</td>
                                        <td>

                                            {!! HTML::decode(HTML::linkRoute('editpage','<i class="fa fa-edit"></i> Edit',$page->id)) !!}

                                        </td>
                                        <td>


                                            <a href="#" data-toggle="modal" data-target="#myModal{{$page->id}}"><i class="fa fa-trash"> Delete</a></i> <!-- Modal -->
                                            <div class='modal fade' id='myModal{{$page->id}}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                                <div class='modal-dialog'>
                                                    <div class='modal-content'>
                                                        <div class='modal-header  ' style="background-color: #3276B1; color:#fff">
                                                            <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
                                                                &times;
                                                            </button>
                                                            <h1 class='modal-title' id='myModalLabel'>Remove Page {{$page->title}}</h1>
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


                                        </td>
                                    </tr>
                                    {{--*/ $x++ /*--}}
                                    @endforeach
                                    </tbody>
                                </table>
                                {{$pages->links()}}
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
        </section>
        <!-- end widget grid -->
<!-- ==========================CONTENT ENDS HERE ========================== -->
@stop