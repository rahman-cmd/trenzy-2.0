@php
    $categories = App\Models\Category::with('subcategory')->whereStatus(1)->orderby('serial', 'asc')->take(8)->get();
@endphp


<!-- Menu Bar -->
<div id="bar align-items-center">
    {{-- <button class="open-sidebar-btn" onclick="toggleSidebar()">☰</button> --}}
    <button class="open-sidebar-btn" onclick="toggleSidebar()">
        <h5><i class="icon-align-justify fs-4"></i></h5>
    </button>
</div>

<div id="category-sidebar" class="category-sidebar">
    <div class="category-header">
        <!-- User Icon -->
        @if (!Auth::user())
            <a href="{{ route('user.login') }}" class="text-dark">
                <i class="icon-user fs-4 user-icon"></i><span class="user-log-text">LOG IN</span>
            </a>
        @else
            <div class="dropdown">
                <a href="#" class="text-dark dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="icon-user fs-4"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                            <i class="icon-chevron-right"></i> {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('user.logout') }}">
                            <i class="icon-chevron-right"></i> {{ __('Logout') }}
                        </a>
                    </li>
                </ul>
            </div>
        @endif
        <button class="close-sidebar" onclick="toggleSidebar()">×</button>
    </div>
    <div class="category-list">
        @foreach ($categories as $key => $pcategory)
            <div class="c-item">
                <a style="border-bottom: 1px solid #ddd;" class="d-block navi-link"
                    href="{{ route('front.catalog') . '?category=' . $pcategory->slug }}">
                    {{-- <img class="lazy" data-src="{{ asset('assets/images/' . $pcategory->photo) }}" alt=""> --}}
                    <span class="text-uppercase">{{ $pcategory->name }}</span>

                    {{-- @if ($pcategory->subcategory->count() > 0)
                        <i class="icon-chevron-right"></i>
                    @endif --}}
                </a>

                @if ($pcategory->subcategory->count() > 0)
                    <div class="sub-c-box">
                        @foreach ($pcategory->subcategory as $scategory)
                            <div class="child-c-box">
                                <a style="" class="title text-uppercase"
                                    href="{{ route('front.catalog') . '?subcategory=' . $scategory->slug }}">
                                    {{ $scategory->name }}

                                    {{-- @if ($scategory->childcategory->count() > 0)
                                        <i class="icon-chevron-right"></i>
                                    @endif --}}
                                </a>
                                @if ($scategory->childcategory->count() > 0)
                                    <div class="child-category">
                                        @foreach ($scategory->childcategory as $childcategory)
                                            <a style="" class="text-uppercase"
                                                href="{{ route('front.catalog') . '?childcategory=' . $childcategory->slug }}">
                                                {{ $childcategory->name }}

                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
        <a href="{{ route('front.catalog') }}" class="d-block navi-link view-all-category">
            <img class="lazy" data-src="{{ asset('assets/images/category.jpg') }}" alt="">
            <span class="text-gray-dark">{{ __('All Categories') }}</span>
        </a>
    </div>
</div>

<script>
    // Toggle the sidebar open/close
    function toggleSidebar() {
        const sidebar = document.getElementById('category-sidebar');
        const menuBar = document.querySelector('.open-sidebar-btn'); // Reference to the menu bar button

        sidebar.classList.toggle('open');
        document.body.classList.toggle('sidebar-open'); // Add a class to track the open state

        // Hide or show the menu bar based on the sidebar's state
        if (sidebar.classList.contains('open')) {
            menuBar.style.display = 'none'; // Hide the menu bar
        } else {
            menuBar.style.display = 'block'; // Show the menu bar
        }
    }

    // Close the sidebar when clicking outside or on the close button
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('category-sidebar');
        const menuBar = document.querySelector('.open-sidebar-btn'); // Reference to the menu bar button
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isSidebarToggle = event.target.closest('.open-sidebar-btn') || event.target.closest(
            '.close-sidebar');

        // If the click is outside the sidebar and not on the toggle button, close it
        if (!isClickInsideSidebar && !isSidebarToggle && sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
            document.body.classList.remove('sidebar-open');

            // Show the menu bar when the sidebar is closed
            menuBar.style.display = 'block';
        }
    });
</script>
