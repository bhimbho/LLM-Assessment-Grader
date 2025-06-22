@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">User Management</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Manage system users</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">User Management</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">people</i> All Users</h5>
                <div class="widget-actions">
                    <a href="{{ route('user-management.create') }}" class="btn btn-primary">
                        <i class="feather feather-plus"></i> Add New User
                    </a>
                </div>
            </div>
            <div class="widget-bg">
                <div class="widget-body pb-0">
                    @include('components.alert')
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" data-toggle="datatables">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">S/N</th>
                                    <th width="8%">Profile</th>
                                    <th width="12%">Staff ID</th>
                                    <th width="20%">Full Name</th>
                                    <th width="20%">Email</th>
                                    <th width="8%">Role</th>
                                    <th width="8%">Status</th>
                                    <th width="12%">Created Date</th>
                                    <th width="7%" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <img src="{{ $user->profile_image_url }}" class="rounded-circle" width="40" height="40" alt="Profile">
                                        </td>
                                        <td>{{ $user->staff_id }}</td>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'info' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($user->is_banned)
                                                <span class="badge badge-danger">Banned</span>
                                            @else
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group-vertical btn-group-sm" role="group">
                                                <a href="{{ route('user-management.show', $user->id) }}" class="btn btn-info btn-sm" title="View Details">
                                                    <i class="feather feather-eye"></i>
                                                </a>
                                                <a href="{{ route('user-management.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="feather feather-edit"></i>
                                                </a>
                                                
                                                @if($user->id !== auth()->id())
                                                    @if($user->is_banned)
                                                        <form action="{{ route('user-management.unban', $user->id) }}" method="post" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm" title="Unban User" onclick="return confirm('Are you sure you want to unban this user?')">
                                                                <i class="feather feather-check"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('user-management.ban', $user->id) }}" method="post" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning btn-sm" title="Ban User" onclick="return confirm('Are you sure you want to ban this user?')">
                                                                <i class="feather feather-x"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <form action="{{ route('user-management.destroy', $user->id) }}" method="post" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete User" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                            <i class="feather feather-trash-2"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="btn btn-secondary btn-sm disabled" title="Current User">
                                                        <i class="feather feather-user"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No users found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.table-responsive {
    overflow-x: auto;
}

.btn-group-vertical .btn,
.btn-group-vertical form .btn,
.btn-group-vertical button {
    display: flex !important;
    width: 100%;
    margin-bottom: 0;
    border-radius: 0 !important;
    border: 1px solid rgba(255,255,255,0.1);
    min-height: 32px;
    align-items: center !important;
    justify-content: center !important;
    position: relative;
    text-align: center;
}

/* Center icons specifically */
.btn-group-vertical .btn i,
.btn-group-vertical form .btn i,
.btn-group-vertical button i {
    display: inline-block;
    text-align: center;
    width: 100%;
    line-height: 1;
}

/* Remove any default button styling that might cause curves */
.btn-group-vertical .btn,
.btn-group-vertical .btn:focus,
.btn-group-vertical .btn:active,
.btn-group-vertical form .btn,
.btn-group-vertical form .btn:focus,
.btn-group-vertical form .btn:active,
.btn-group-vertical button,
.btn-group-vertical button:focus,
.btn-group-vertical button:active {
    border-radius: 0 !important;
    outline: none !important;
    box-shadow: none !important;
}

.table th, .table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
}

/* Bootstrap button group pill styling */
.btn-group-vertical {
    border-radius: 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 40px;
    margin: 0 auto;
    border: 1px solid rgba(255,255,255,0.1);
}

/* Ensure consistent button sizing */
.btn-group-vertical .btn,
.btn-group-vertical form .btn,
.btn-group-vertical button {
    flex: 1;
    min-height: 28px;
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border-left: none;
    border-right: none;
    border-top: none;
}

.btn-group-vertical .btn:first-child,
.btn-group-vertical form:first-child .btn,
.btn-group-vertical form:first-child button {
    border-top: 1px solid rgba(255,255,255,0.1);
}

/* Dark mode button visibility */
.btn-info {
    background-color: #17a2b8 !important;
    border-color: #17a2b8 !important;
    color: white !important;
}

.btn-warning {
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
    color: #212529 !important;
}

.btn-success {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    color: white !important;
}

.btn-danger {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: white !important;
}

.btn-secondary {
    background-color: #6c757d !important;
    border-color: #6c757d !important;
    color: white !important;
}

/* Hover effects */
.btn-info:hover {
    background-color: #138496 !important;
    border-color: #138496 !important;
    color: white !important;
}

.btn-warning:hover {
    background-color: #e0a800 !important;
    border-color: #e0a800 !important;
    color: #212529 !important;
}

.btn-success:hover {
    background-color: #218838 !important;
    border-color: #218838 !important;
    color: white !important;
}

.btn-danger:hover {
    background-color: #c82333 !important;
    border-color: #c82333 !important;
    color: white !important;
}

.btn-secondary:hover {
    background-color: #5a6268 !important;
    border-color: #5a6268 !important;
    color: white !important;
}

@media (max-width: 768px) {
    .btn-group-vertical {
        display: flex;
        flex-direction: row;
        gap: 2px;
        border-radius: 0;
        max-width: none;
        border: none;
    }
    
    .btn-group-vertical .btn,
    .btn-group-vertical form .btn,
    .btn-group-vertical button {
        margin-bottom: 0;
        border-radius: 0 !important;
        border: 1px solid rgba(255,255,255,0.1);
        flex: 1;
        min-height: 28px;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }
    
    .btn-group-vertical .btn i,
    .btn-group-vertical form .btn i,
    .btn-group-vertical button i {
        display: inline-block;
        text-align: center;
        width: 100%;
        line-height: 1;
    }
}
</style>

@include('layouts.footer') 