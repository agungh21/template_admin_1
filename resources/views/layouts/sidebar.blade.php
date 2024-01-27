    <!-- ! Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-start">
            <div class="text-center">
                <button class="sidebar-toggle transparent-btn mb-3" title="Menu" type="button">
                    <span class="sr-only">Toggle menu</span>
                    <span class="icon menu-toggle" aria-hidden="true"></span>
                </button>
            </div>
            <div class="sidebar-head">
                <a href="/" class="logo-wrapper" title="Home">
                    <span class="sr-only">Home</span>
                    <span class="icon logo" aria-hidden="true"></span>
                    <div class="logo-text">
                        <span class="logo-title">{{ $settings['umum']['name_app'] }}</span>
                    </div>

                </a>
            </div>
            <div class="sidebar-body">
                <ul class="sidebar-body-menu">
                    <li>
                        <a class="active" href="{{ route('admin') }}"><span class="icon home" aria-hidden="true"></span> Dashboard</a>
                    </li>
                    <li>
                        <a class="show-cat-btn" href="#">
                            <span class="icon master" aria-hidden="true"></span> Master
                            <span class="category__btn transparent-btn" title="Open list">
                                <span class="sr-only">Open list</span>
                                <span class="icon arrow-down" aria-hidden="true"></span>
                            </span>
                        </a>
                        <ul class="cat-sub-menu">
                            <li>
                                <a href="{{ route('admin.user') }}">User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.campaign') }}"><span class="icon campaign" aria-hidden="true"></span> Campaign</a>
                    <li>
                        <a href="{{ route('admin.campaign_target') }}"><span class="icon campaign-target" aria-hidden="true"></span> Campaign Target</a>
                    </li>
                    <li>
                        <a class="show-cat-btn" href="#">
                            <span class="icon pengaturan" aria-hidden="true"></span> Pengaturan
                            <span class="category__btn transparent-btn" title="Open list">
                                <span class="sr-only">Open list</span>
                                <span class="icon arrow-down" aria-hidden="true"></span>
                            </span>
                        </a>
                        <ul class="cat-sub-menu">
                            <li>
                                <a href="{{ route('admin.setting.common') }}">Umum</a>
                            </li>
                        </ul>
                    </li>
                    <hr class="text-white">
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><span class="icon logout" aria-hidden="true"></span> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
