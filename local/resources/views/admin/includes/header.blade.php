{{! $user = auth()->user() }}
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><img height="40" src="{{ cdnLink('logo/logo.png', true) }}" /></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><img height="40" src="{{ cdnLink('logo/logo.png', true) }}" /></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" department="button">
            <span class="sr-only">{{ cpTrans('toggle_navigation') }}</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li style="padding-top:0px; padding-right:7px; padding-left:7px;">
                    <button type="button" data-lang="{{ App::getLocale() == 'en' ? 'ar' : 'en' }}" class="switch-lang btn bg-purple margin btn-flat">{{ App::getLocale() == 'en' ? \Lang::choice("admin.arabic", 0, [], 'ar') : \Lang::choice("admin.english", 0, [], 'ar') }}</button>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                         <!-- The user image in the navbar-->
                         @if(@$user->profile_image)
                            <img src="{{ buildFileLink($user->profile_image, 'admin') }}" class="user-image">
                         @else 
                            <img src="{{ cdnLink('logo/user.png', true) }}" class="user-image">
                        @endif
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"> {{ $user->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            @if($user->profile_image)
                                <img src="{{ buildFileLink($user->profile_image, 'admin') }}" class="img-circle">
                            @else 
                                <img src="{{ cdnLink('logo/user.png', true) }}" class="img-circle">
                            @endif
                            <p>
                                {{ $user->name }}
                                <small>{{ cpTrans('member_since') }} {{ date("M. Y", strtotime($user->created_at)) }}</small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ route('admin.admin.update.profile', ['id' => $user->id]) }}" class="btn btn-default btn-flat" data-target="#remote_model" data-toggle="modal">{{ cpTrans('profile') }}</a>
                                <a href="{{ route('admin.admin.change-password', ['id' => $user->id]) }}" class="btn btn-default btn-flat" data-target="#remote_model" data-toggle="modal">{{ cpTrans('change_password') }}</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">{{ cpTrans('sign_out') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>