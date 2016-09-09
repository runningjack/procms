<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 9/8/16
 * Time: 11:10 AM
 */
?>
<!DOCTYPE html>
<html lang="en-us" <?php //echo implode(' ', array_map(function($prop, $value) {
    //return $prop.'="'.$value.'"';
//}, array_keys($page_html_prop), $page_html_prop)) ;?>>
@include("backend.includes.header")
<head>
@include("backend.includes.head")
</head>
<body <?php //echo implode(' ', array_map(function($prop, $value) {
    //return $prop.'="'.$value.'"';
//}, array_keys($page_body_prop), $page_body_prop)) ;?>>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">

    @yield("breadcrumb")
    @include("backend.includes.ribbon")


    <!-- MAIN CONTENT -->
    <div id="content">

    @yield("content")

    </div>
    <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->
@include("backend.includes.footer")
</body>
</html>