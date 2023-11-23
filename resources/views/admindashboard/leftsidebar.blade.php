<aside id="sidebar" class=" colored sidebar ">
    @php
    $user = Auth::guard('admin')->user();
    @endphp
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item"> <a class="nav-link disabled" href="{{ url('admin/dashboard') }}"> <i class="bi bi-bank "></i> <span>Dashboard</span> </a></li>



        @if(Auth::guard('admin')->user()->type!=="vendor")

        @if ($user->hasPermissionByRole('view_permission') || $user->hasPermissionByRole('view_role') || $user->hasPermissionByRole('view_admin'))

        <li class="{{ request()->is('admin/permissions')?'nav-item active':'' }} {{ request()->is('admin/all-delivery-boys')?'nav-item active':'' }} {{ request()->is('admin/delivery-boy/*')?'nav-item active':'' }} {{ request()->is('admin/permissions/create')?'nav-item active':'' }} {{ request()->is('admin/roles')?'nav-item active':'' }} {{ request()->is('admin/roles/*')?'nav-item active':'' }}  {{ request()->is('admin/all-admins')?'nav-item active':'' }}">
            <a class="nav-link " data-bs-target="#manage-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-people-fill "></i><span>Role and Permissions</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="manage-nav" class=" nav-content collapse {{ request()->is('admin/permissions')?'show':'' }} {{ request()->is('admin/all-delivery-boys')?'show':'' }}  {{ request()->is('admin/delivery-boy/*')?'show':'' }} {{ request()->is('admin/role*')?'show':'' }} {{ request()->is('admin/roles*')?'show':'' }} {{ request()->is('admin/permissions/*')?'show':'' }} {{ request()->is('admin/roles')?'show':'' }} {{ request()->is('admin/all-admins')?'show':'' }}" data-bs-parent="#sidebar-nav">
                @if ($user && $user->hasPermissionByRole('view_permission'))
                <li> <a href="{{ route('permissions.index') }}" class="{{ request()->is('admin/permissions')?'nav-link active':'' }} {{ request()->is('admin/permissions/*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All Permissions </span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_role'))
                <li> <a href="{{ route('roles.index') }}" class="{{ request()->is('admin/roles')?'nav-link active':'' }} {{ request()->is('admin/role*')?'nav-link active':'' }}  {{ request()->is('admin/roles/*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>All Roles</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_admin'))
                <li> <a href="{{ route('all-admins.index') }}" class="{{ request()->is('admin/all-admins')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All admins</span></a></li>
                @endif

            </ul>
        </li>
        @endif

        @if ($user->hasPermissionByRole('view_admin') || $user->hasPermissionByRole('create_admin'))
        <li class="{{ request()->is('admin/add_admin')?'nav-item active':'' }} {{ request()->is('admin/edit_admin/*')?'nav-item active':'' }} ">
            <a class="nav-link " data-bs-target="#manageadmin-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-people-fill "></i><span>Admin Managements</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="manageadmin-nav" class=" nav-content collapse {{ request()->is('admin/displayall')?'show':'' }} {{ request()->is('admin/edit_admin/*')?'show':'' }}  {{ request()->is('admin/add_admin')?'show':'' }}" data-bs-parent="#sidebar-nav">
                @if ($user && $user->hasPermissionByRole('view_admin'))
                <li> <a href="{{ route('displayall') }}" class="{{ request()->is('admin/displayall*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>All</span></a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('create_admin'))
                <li> <a href="{{ url('admin/add_admin') }}" class="{{ request()->is('admin/add_admin*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Add Admins/Subadmins</span></a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_users'))
        <li class=" {{ request()->is('admin/users')?'nav-item active':'' }} {{ request()->is('admin/edit_user*')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#"> <i class=" ri-group-2-fill"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="users-nav" class="nav-content collapse   {{ request()->is('admin/edit_user*')?'show':'' }}   {{ request()->is('admin/users')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('users') }}" class="{{ request()->is('admin/users*')?'nav-link active':'' }} {{ request()->is('admin/edit_user*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Users</span></a></li>

            </ul>
        </li>
        @endif


        
        <li class=" {{ request()->is('admin/products*')?'nav-item active':'' }} {{ request()->is('admin/coupons*')?'nav-item active':'' }} {{ request()->is('admin/section*')?'nav-item active':'' }} {{ request()->is('admin/categories*')?'nav-item active':'' }} {{ request()->is('admin/groups*')?'nav-item active':'' }} {{ request()->is('admin/subcategories*')?'nav-item active':'' }} {{ request()->is('admin/brands*')?'nav-item active':''}} {{ request()->is('admin/filters*')?'nav-item active':''}}">
            <a class="nav-link " data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#" aria-expanded="false"> <i class="ri-gift-2-fill"></i><span>Catelog Managements</span><i class="bi bi-chevron-down  ms-auto"></i> </a>
            <ul id="charts-nav" class="nav-content collapse {{ request()->is('admin/products*')?'show':'' }} {{ request()->is('admin/subcategories*')?'show':'' }} {{ request()->is('admin/section*')?'show':'' }} {{ request()->is('admin/categories*')?'show':'' }} {{ request()->is('admin/groups*')?'show':'' }} {{ request()->is('admin/brands*')?'show':'' }}{{ request()->is('admin/filters*')?'show':'' }}{{ request()->is('admin/coupons*')?'show':'' }}" data-bs-parent="" style="">
                @if ($user && $user->hasPermissionByRole('view_group'))
                <li> <a href="{{ route('groups') }}" class="{{ request()->is('admin/groups*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Groups</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_category'))
                <li> <a href="{{ route('categories') }}" class=" {{ request()->is('admin/categories*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Categories</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_brand'))
                <li> <a href="{{ route('brands') }}" class=" {{ request()->is('admin/brand*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Brands</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_filters'))
                <li> <a href="{{ route('filters') }}" class=" {{ request()->is('admin/filters*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Filters</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_coupon'))
                <li> <a href="{{ route('coupons') }}" class=" {{ request()->is('admin/coupons*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Coupons</span> </a></li>
                @endif
                @if ($user && $user->hasPermissionByRole('view_product'))
                <li> <a href="{{ route('products') }}" class=" {{ request()->is('admin/products*')?' nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Products</span> </a></li>
                @endif
            </ul>
        </li>

        @if ($user && $user->hasPermissionByRole('view_advertisment'))
        <li class=" {{ request()->is('admin/adverstisements')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#adv-nav" data-bs-toggle="collapse" href="#"> <i class=" ri-layout-top-2-line"></i><span>Adverstisements </span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="adv-nav" class="nav-content collapse  {{ request()->is('admin/adverstisements')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('adverstisements') }}" class="{{ request()->is('admin/adverstisements*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>All Adverstisements</span> </a></li>
            </ul>
        </li>
        @endif

        @if ($user && $user->hasPermissionByRole('view_banners'))
        <li class=" {{ request()->is('admin/banners')?'nav-item active':'' }}  ">
            <a class="nav-link" data-bs-target="#banner-nav" data-bs-toggle="collapse" href="#"> <i class=" ri-layout-top-2-line"></i><span>Banner Managements</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="banner-nav" class="nav-content collapse  {{ request()->is('admin/banners')?'show':'' }}  " data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('banners') }}" class="{{ request()->is('admin/banners*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Slider Banners</span> </a></li>
            </ul>
        </li>
        @endif

        @endif
        <li class="nav-heading">My Settings</li>
        <li class=" {{ request()->is('admin/update_admin_password')?'nav-item active':'' }} {{ request()->is('admin/updateadmindetails')?'nav-item active':'' }} ">
            <a class="nav-link" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#"> <i class="bi bi-person-bounding-box  "></i><span>My Setting</span><i class="bi bi-chevron-down ms-auto"></i> </a>
            <ul id="settings-nav" class="nav-content collapse  {{ request()->is('admin/update_admin_password')?'show':'' }}  {{ request()->is('admin/updateadmindetails')?'show':'' }}" data-bs-parent="#sidebar-nav">
                <li> <a href="{{ route('update_admin_password') }}" class="{{ request()->is('admin/update_admin_password*')?'nav-link active':'' }}"> <i class=" bi bi-circle active "></i><span>Update Password</span> </a></li>
                <li> <a href="{{ route('updateadmindetails') }}" class="{{ request()->is('admin/updateadmindetails*')?'nav-link active':'' }}"> <i class="bi bi-circle"></i><span>Update Details</span></a></li>
            </ul>
        </li>
    </ul>
</aside>

