<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title', 'Default Title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--
    =========================================================
    * ArchitectUI HTML Theme Dashboard - v1.0.0
    =========================================================
    * Product Page: https://dashboardpack.com
    * Copyright 2019 DashboardPack (https://dashboardpack.com)
    * Licensed under MIT (https://github.com/DashboardPack/architectui-html-theme-free/blob/master/LICENSE)
    =========================================================
    * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    -->
<link rel="stylesheet" href="{{ asset('Dashboard/main.css') }}">


<!-- Inside your layouts.app head -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
<script src="https://kit.fontawesome.com/yourkitid.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    
            <div class="app-header__content">
                <div>
                    <h4 style="text-align: center; font-weight: bold;">Fleet Management Module</h4>
                </div>
            </div>

            @auth
            <div class="user-info" style="display: inline-block; padding: 10px; position: relative; font-size: 16px; vertical-align: middle;">
                <span style="white-space: nowrap;">
                    {{ auth()->user()->name }}<br>
                    <small style="color: #6c757d; font-size: 12px;">{{ auth()->user()->role->name }}</small>
                </span>
            </div>
            @endauth

            <div class="notification-container" style="display: inline-block; cursor: pointer; padding: 10px; font-size: 24px; position: relative;" title="Notifications">
                <i class="fas fa-bell" id="notification-bell"></i>
                <span id="notification-count" class="badge badge-danger" style="position: absolute; top: -5px; right: -5px; display: none;"></span>
            </div>

            <div id="notification-dropdown" class="dropdown-menu dropdown-menu-right" style="display: none; position: absolute; top: 100%; right: 0; z-index: 1000; width: 300px; max-height: 400px; overflow-y: auto; background: white; border: 1px solid #ccc; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                <div class="dropdown-header" style="padding: 10px; border-bottom: 1px solid #eee; font-weight: bold;">Notifications</div>
                <div id="notification-list" style="padding: 10px;"></div>
                <div class="dropdown-divider" style="margin: 0;"></div>
                <a class="dropdown-item text-center" href="#" onclick="markAllRead()" style="padding: 10px; cursor: pointer;">Mark all as read</a>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline; padding: 10px; position: relative; font-size: 20px;">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <!-- Example logout icon -->
                </a>
            </form>
              
        </div>        
        <div class="ui-theme-settings">
            <!--<button type="button" id="TooltipDemo" class="btn-open-options btn btn-warning">
                <i class="fa fa-cog fa-w-16 fa-spin fa-2x"></i>
            </button> -->
            <div class="theme-settings__inner">
                <div class="scrollbar-container">
                    <div class="theme-settings__options-wrapper">
                        <h3 class="themeoptions-heading">Layout Options
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-header">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Header
                                                </div>
                                                <div class="widget-subheading">Makes the header top fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-sidebar">
                                                    <div class="switch-animate switch-on">
                                                        <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Sidebar
                                                </div>
                                                <div class="widget-subheading">Makes the sidebar left fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="widget-content p-0">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left mr-3">
                                                <div class="switch has-switch switch-container-class" data-class="fixed-footer">
                                                    <div class="switch-animate switch-off">
                                                        <input type="checkbox" data-toggle="toggle" data-onstyle="success">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Fixed Footer
                                                </div>
                                                <div class="widget-subheading">Makes the app footer bottom fixed, always visible!
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>
                                Header Options
                            </div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-header-cs-class" data-class="">
                                Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-header-cs-class" data-class="bg-primary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-header-cs-class" data-class="bg-secondary header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-header-cs-class" data-class="bg-success header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-header-cs-class" data-class="bg-info header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-header-cs-class" data-class="bg-warning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-header-cs-class" data-class="bg-danger header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-header-cs-class" data-class="bg-light header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-header-cs-class" data-class="bg-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-header-cs-class" data-class="bg-focus header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-header-cs-class" data-class="bg-alternate header-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-header-cs-class" data-class="bg-vicious-stance header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-header-cs-class" data-class="bg-midnight-bloom header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-header-cs-class" data-class="bg-night-sky header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-header-cs-class" data-class="bg-slick-carbon header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-header-cs-class" data-class="bg-asteroid header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-header-cs-class" data-class="bg-royal header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-header-cs-class" data-class="bg-warm-flame header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-header-cs-class" data-class="bg-night-fade header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-header-cs-class" data-class="bg-sunny-morning header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-header-cs-class" data-class="bg-tempting-azure header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-header-cs-class" data-class="bg-amy-crisp header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-header-cs-class" data-class="bg-heavy-rain header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-header-cs-class" data-class="bg-mean-fruit header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-header-cs-class" data-class="bg-malibu-beach header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-header-cs-class" data-class="bg-deep-blue header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-header-cs-class" data-class="bg-ripe-malin header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-header-cs-class" data-class="bg-arielle-smile header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-header-cs-class" data-class="bg-plum-plate header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-header-cs-class" data-class="bg-happy-fisher header-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-header-cs-class" data-class="bg-happy-itmeo header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-header-cs-class" data-class="bg-mixed-hopes header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-header-cs-class" data-class="bg-strong-bliss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-header-cs-class" data-class="bg-grow-early header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-header-cs-class" data-class="bg-love-kiss header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-header-cs-class" data-class="bg-premium-dark header-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-header-cs-class" data-class="bg-happy-green header-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <h3 class="themeoptions-heading">
                            <div>Sidebar Options</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto btn btn-focus btn-sm switch-sidebar-cs-class" data-class="">
                                Restore Default
                            </button>
                        </h3>
                         <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Choose Color Scheme
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div class="swatch-holder bg-primary switch-sidebar-cs-class" data-class="bg-primary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-secondary switch-sidebar-cs-class" data-class="bg-secondary sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-success switch-sidebar-cs-class" data-class="bg-success sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-info switch-sidebar-cs-class" data-class="bg-info sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-warning switch-sidebar-cs-class" data-class="bg-warning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-danger switch-sidebar-cs-class" data-class="bg-danger sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-light switch-sidebar-cs-class" data-class="bg-light sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-dark switch-sidebar-cs-class" data-class="bg-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-focus switch-sidebar-cs-class" data-class="bg-focus sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-alternate switch-sidebar-cs-class" data-class="bg-alternate sidebar-text-light">
                                        </div>
                                        <div class="divider">
                                        </div>
                                        <div class="swatch-holder bg-vicious-stance switch-sidebar-cs-class" data-class="bg-vicious-stance sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-midnight-bloom switch-sidebar-cs-class" data-class="bg-midnight-bloom sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-night-sky switch-sidebar-cs-class" data-class="bg-night-sky sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-slick-carbon switch-sidebar-cs-class" data-class="bg-slick-carbon sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-asteroid switch-sidebar-cs-class" data-class="bg-asteroid sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-royal switch-sidebar-cs-class" data-class="bg-royal sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-warm-flame switch-sidebar-cs-class" data-class="bg-warm-flame sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-night-fade switch-sidebar-cs-class" data-class="bg-night-fade sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-sunny-morning switch-sidebar-cs-class" data-class="bg-sunny-morning sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-tempting-azure switch-sidebar-cs-class" data-class="bg-tempting-azure sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-amy-crisp switch-sidebar-cs-class" data-class="bg-amy-crisp sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-heavy-rain switch-sidebar-cs-class" data-class="bg-heavy-rain sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-mean-fruit switch-sidebar-cs-class" data-class="bg-mean-fruit sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-malibu-beach switch-sidebar-cs-class" data-class="bg-malibu-beach sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-deep-blue switch-sidebar-cs-class" data-class="bg-deep-blue sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-ripe-malin switch-sidebar-cs-class" data-class="bg-ripe-malin sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-arielle-smile switch-sidebar-cs-class" data-class="bg-arielle-smile sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-plum-plate switch-sidebar-cs-class" data-class="bg-plum-plate sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-fisher switch-sidebar-cs-class" data-class="bg-happy-fisher sidebar-text-dark">
                                        </div>
                                        <div class="swatch-holder bg-happy-itmeo switch-sidebar-cs-class" data-class="bg-happy-itmeo sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-mixed-hopes switch-sidebar-cs-class" data-class="bg-mixed-hopes sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-strong-bliss switch-sidebar-cs-class" data-class="bg-strong-bliss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-grow-early switch-sidebar-cs-class" data-class="bg-grow-early sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-love-kiss switch-sidebar-cs-class" data-class="bg-love-kiss sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-premium-dark switch-sidebar-cs-class" data-class="bg-premium-dark sidebar-text-light">
                                        </div>
                                        <div class="swatch-holder bg-happy-green switch-sidebar-cs-class" data-class="bg-happy-green sidebar-text-light">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div> 
                        <h3 class="themeoptions-heading">
                            <div>Main Content Options</div>
                            <button type="button" class="btn-pill btn-shadow btn-wide ml-auto active btn btn-focus btn-sm">Restore Default
                            </button>
                        </h3>
                        <div class="p-3">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h5 class="pb-2">Page Section Tabs
                                    </h5>
                                    <div class="theme-settings-swatches">
                                        <div role="group" class="mt-2 btn-group">
                                            <button type="button" class="btn-wide btn-shadow btn-primary btn btn-secondary switch-theme-class" data-class="body-tabs-line">
                                                Line
                                            </button>
                                            <button type="button" class="btn-wide btn-shadow btn-primary active btn btn-secondary switch-theme-class" data-class="body-tabs-shadow">
                                                Shadow
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="app-main">
                <div class="app-sidebar sidebar-shadow">
                    <div class="app-header__logo">
                        <div class="logo-src"></div>
                        <div class="header__pane ml-auto">
                            <div>
                                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="app-header__mobile-menu">
                        <div>
                            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="app-header__menu">
                        <span>
                            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                                <span class="btn-icon-wrapper">
                                    <i class="fa fa-ellipsis-v fa-w-6">s</i>
                                </span>
                            </button>
                        </span>
                    </div>    
                    <div class="scrollbar-sidebar">
                        <div class="app-sidebar__inner">
                            <ul class="vertical-nav-menu">
                                <li class="app-sidebar__heading"></li>
                                <li>
                                    <a href="index.html" class="mm-active">
                                        <i>Dashboards</i> 
                                    </a>
                                </li>
                                <li class="app-sidebar__heading">Navigation</li>
                                <li>
                                    <a href="#">
                                        <img src="{{ asset('assets/car.png') }}" style="padding:1px; 24px; height: 24px; margin-right: 10px;">
                                       Master Data
                                       <img src="{{ asset('assets/add-button.png') }}" style="width: 24px; height: 24px; margin-left: 55px;">
                                        
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('vehicle-types.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                    Vehicle Type 
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-allocation-type.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Vehicle Allocation Type
                                                </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-category.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Vehicle Category
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-sub-category.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Vehicle Sub Category
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-tire-sizes.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                </i>Vehicle Tire sizes
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-make.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                </i>Vehicle Make
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-models.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                </i>Vehicle Model
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-engine-capacity.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Vehicle Engine Capacity
                                            </a>

                                        </li>
                                        <li>
                                            <a href="{{ route('fuel-types.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                </i>Fuel Type
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-color.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                </i>Vehicle Color
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle-status.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                </i>Vehicle Status
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('workshops.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                </i>Workshop
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('establishments.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                </i>Establishment
                                            </a>
                                    </ul>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="{{ asset('assets/appeals.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                       Request by Vehicle
                                        <img src="{{ asset('assets/add-button.png') }}" style="width: 24px; height: 24px; margin-left: 10px;">
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="{{ route('vehicle.request.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                    Vehicle Request 
                                                </a>
                                        </li>
                                        <li>
                                            <a href="/request-vehicle-2">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                    Vehicle Request 2 
                                            </a>
                                            <ul>
                                                <li>
                                                    <a href="/request-vehicle-2">
                                                        <img src="{{ asset('assets/car.png') }}" style="width: 20px; height: 20px; margin-right: 8px;">
                                                        Vehicle Request 2 
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/vehicle-approved">
                                                        <img src="{{ asset('assets/car.png') }}" style="width: 20px; height: 20px; margin-right: 8px;">
                                                        Approved
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/vehicle-rejected">
                                                        <img src="{{ asset('assets/car.png') }}" style="width: 20px; height: 20px; margin-right: 8px;">
                                                        Rejected
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/vehicle-forwarded">
                                                        <img src="{{ asset('assets/car.png') }}" style="width: 20px; height: 20px; margin-right: 8px;">
                                                        Forwarded
                                                    </a>
                                                </li>
                                            </ul>
                                            
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle.request.all') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                All Requests
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('vehicle.inspection.index') }}">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Vehicle Inspection request
                                            </a>

                                        </li>

                                        <li>
                                            <a href="/vehicle-inspection-form2">
                                                <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Vehicle Inspection form 02
                                            </a>
                                        </li>
                                        
                                </li>
                                </ul>
                                <li>
                                    <a href="">
                                        <img src="{{ asset('assets/amendment.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                       Driver Amendment
                                        <img src="{{ asset('assets/add-button.png') }}" style="width: 24px; height: 24px; margin-left: 12px;">
                                    </a>
                                <ul>
                                    <li>
                                        <a href="/all-drivers">
                                            <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Drivers
                                        </a>
                                    </li>
                                </ul>
                                <li>
                                    <a href="">
                                        <img src="{{ asset('assets/group.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                       User
                                        <img src="{{ asset('assets/add-button.png') }}" style="width: 24px; height: 24px; margin-left: 102.5px;">
                                    </a>
                                <ul>
                                    <li>
                                        <a href="/user-roles">
                                            <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                User Role
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/user-creation">
                                            <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                User Creation 
                                        </a>
                                    </li>
                                </ul>
                                <li>
                                    <a href="">
                                        <img src="{{ asset('assets/fleet-management.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                       Vehicle
                                        <img src="{{ asset('assets/add-button.png') }}" style="width: 24px; height: 24px; margin-left: 85px;">
                                    </a>
                                <ul>
                                    
                                    <li>
                                        <a href="/all-vehicle-info">
                                            <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Vehicle Registration
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/army-vehicle-reg">
                                            <img src="{{ asset('assets/car.png') }}" style="width: 24px; height: 24px; margin-right: 10px;">
                                                Army Vehicle Registration
                                        </a>
                                    </li>

                                
                                
                            
                        </div>
                    </div>
                </div>    
                <div class="app-main__outer">
                    <div class="app-main__inner">
                        @yield('content')
                    </div>
                </div>
                <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        </div>
    </div>
  <script src="{{ asset('Dashboard/main.js') }}"></script>
    <script>

            document.addEventListener('DOMContentLoaded', function() {
            // Load initial unread count
            fetch('/api/notifications/unread-count')
                .then(response => response.json())
                .then(data => updateBadge(data.count));

            // Poll for new notifications every 30 seconds
            setInterval(() => {
                fetch('/api/notifications/unread-count')
                    .then(response => response.json())
                    .then(data => {
                        updateBadge(data.count);
                        if (data.count > 0) {
                            // Optionally reload notifications if dropdown is open
                            if (document.getElementById('notification-dropdown').style.display === 'block') {
                                loadNotifications();
                            }
                        }
                    });
            }, 30000);
        });

        document.getElementById('notification-bell').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notification-dropdown');
            if (dropdown.style.display === 'none' || dropdown.style.display === '') {
                document.getElementById('notification-list').innerHTML = '<div class="dropdown-item text-center text-muted">Loading...</div>';
                loadNotifications();
                dropdown.style.display = 'block';
            } else {
                dropdown.style.display = 'none';
            }
        });

        document.addEventListener('click', function(e) {
            const container = document.querySelector('.notification-container');
            const dropdown = document.getElementById('notification-dropdown');
            if (container && !container.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });

        function loadNotifications() {
            console.log('Loading notifications...');
            fetch('/api/notifications', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Fetch failed: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                displayNotifications(data.notifications);
                updateBadge(data.unread_count);
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                document.getElementById('notification-list').innerHTML = '<div class="dropdown-item text-center text-danger">Error: ' + error.message + '</div>';
            });
        }
        function displayNotifications(notifications) {
            const list = document.getElementById('notification-list');
            list.innerHTML = '';
            if (notifications.length === 0) {
                list.innerHTML = '<div class="dropdown-item text-center text-muted">No notifications</div>';
                return;
            }
            notifications.forEach(notification => {
                const item = document.createElement('a');
                item.className = 'dropdown-item';
                item.style.padding = '8px 12px';
                item.style.borderBottom = '1px solid #eee';
                item.style.cursor = 'pointer';
                item.href = notification.link || '#';
                item.innerHTML = `
                    <div>
                        <strong style="color: #333;">${notification.title}</strong>
                        ${!notification.is_read ? '<span class="badge badge-primary float-right" style="font-size: 0.75em;">New</span>' : ''}
                        <br>
                        <small class="text-muted" style="font-size: 0.875em;">${notification.message}</small>
                        <br>
                        <small class="text-muted" style="font-size: 0.75em;">${new Date(notification.created_at).toLocaleString()}</small>
                    </div>
                `;
                item.onclick = (e) => {
                    e.preventDefault();
                    markAsRead(notification.id);
                    if (notification.link) {
                        window.location.href = notification.link;
                    }
                };
                list.appendChild(item);
            });
        }

        function markAsRead(id) {
            fetch(`/api/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications(); // Reload to update UI
                }
            })
            .catch(error => console.error('Error marking as read:', error));
        }

        function markAllRead() {
            fetch('/api/notifications/read-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadNotifications();
                }
            })
            .catch(error => console.error('Error marking all as read:', error));
        }

        function updateBadge(count) {
            const badge = document.getElementById('notification-count');
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.style.display = 'inline';
            } else {
                badge.style.display = 'none';
            }
        }
    </script>
</body>
</html>
