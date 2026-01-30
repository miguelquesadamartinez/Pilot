<!-- BEGIN: Page Level CSS-->
@if(!empty($configData['mainLayoutType']) && isset($configData['mainLayoutType']))
<link rel="stylesheet" type="text/css"
  href="{{asset('css/themes/'.$configData['mainLayoutType'].'-template/materialize.css')}}">
<link rel="stylesheet" type="text/css"
  href="{{asset('css/themes/horizontal-menu-template/style.css')}}">

@if($configData['mainLayoutType'] === 'horizontal-menu')
{{-- horizontal style file only for horizontal layout --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/layouts/style-horizontal.css')}}">
@endif
@else
<h1>mainLayoutType option is either empty or not set in config custom.php file.</h1>
@endif

@yield('page-style')

@if($configData['direction'] === 'rtl')
{{-- rtl style file for rtl version --}}
<link rel="stylesheet" type="text/css" href="{{asset('css/style-rtl.css')}}">
@endif
<!-- END: Page Level CSS-->
<!-- BEGIN: Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('css/laravel-custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/custom/custom.css')}}?<?php echo(strtotime(now())); ?>">
<!-- END: Custom CSS-->