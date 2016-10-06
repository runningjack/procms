<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 9/8/16
 * Time: 11:59 AM
 */
?>

<meta charset="utf-8">
<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

<title>{{$page_title}} </title>
<meta name="description" content="">
<meta name="author" content="">
<meta name="csrf_token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<!-- Basic Styles -->
<link rel="stylesheet" type="text/css" media="screen" href="{{url('')}}/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="{{url('')}}/css/font-awesome.min.css">

<!-- SmartAdmin Styles : Please note (smartadmin-production.css) was created using LESS variables -->
<link rel="stylesheet" type="text/css" media="screen" href="{{url('')}}/css/smartadmin-production.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="{{url('')}}/css/smartadmin-skins.min.css">

<!-- SmartAdmin RTL Support is under construction-->
<link rel="stylesheet" type="text/css" media="screen" href="{{url('')}}/css/smartadmin-rtl.min.css">
<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
<link rel="stylesheet" type="text/css" media="screen" href="{{url('')}}/css/demo.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="{{url('')}}/js/plugin/colorbox/example4/colorbox.css">

<!-- FAVICONS -->
<link rel="shortcut icon" href="{{url('')}}/img/favicon/favicon.ico" type="image/x-icon">
<link rel="icon" href="{{url('')}}/img/favicon/favicon.ico" type="image/x-icon">
<!-- Specifying a Webpage Icon for Web Clip
     Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
<link rel="apple-touch-icon" href="{{url('')}}/img/splash/sptouch-icon-iphone.png">
<link rel="apple-touch-icon" sizes="76x76" href="{{url('')}}/img/splash/touch-icon-ipad.png">
<link rel="apple-touch-icon" sizes="120x120" href="{{url('')}}/img/splash/touch-icon-iphone-retina.png">
<link rel="apple-touch-icon" sizes="152x152" href="{{url('')}}/img/splash/touch-icon-ipad-retina.png">

<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">

<!-- Startup image for web apps -->
<link rel="apple-touch-startup-image" href="{{url('')}}/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
<link rel="apple-touch-startup-image" href="{{url('')}}/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
<link rel="apple-touch-startup-image" href="{{url('')}}/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
<script src="{{url('')}}/js/libs/jquery-2.0.2.min.js"></script>
<script src="{{url('')}}/js/libs/jquery-ui-1.10.3.min.js"></script>
<style type="text/css" >
    ul.imglist{
        list-style: none;
        list-style-image: none;
    }
    ul.imglist li{
        float:left;
        margin: 5px;
    }
    .widget-disabled  {
        opacity: 0.5;
    }
    @media (min-width: 992px) {
        .modal-lg {
            width: 1000px;
        }
    }
</style>

