@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">User Details</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">View user information</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user-management.index') }}">User Management</a></li>
                <li class="breadcrumb-item active">User Details</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-8">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">person</i> User Information</h5>
                <div class="widget-actions">
                    <a href="{{ route('user-management.edit', $user->id) }}" class="btn btn-warning btn-sm">
                        <i class="feather feather-edit"></i> Edit User
                    </a>
                </div>
            </div>
            <div class="widget">
                <div class="widget-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Staff ID:</strong></td>
                                    <td>{{ $user->staff_id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Full Name:</strong></td>
                                    <td>{{ $user->full_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td>
                                        <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : 'info' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        @if($user->is_banned)
                                            <span class="badge badge-danger">Banned</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Member Since:</strong></td>
                                    <td>{{ $user->created_at->format('F d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Last Updated:</strong></td>
                                    <td>{{ $user->updated_at->format('F d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <img src="{{ $user->profile_image_url }}" class="rounded-circle" width="120" height="120" alt="Profile">
                                <h5 class="mt-3">{{ $user->full_name }}</h5>
                                <p class="text-muted">{{ $user->email }}</p>
                                
                                @if($user->id !== auth()->id())
                                    <div class="mt-3">
                                        @if($user->is_banned)
                                            <form action="{{ route('user-management.unban', $user->id) }}" method="post" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Are you sure you want to unban this user?')">
                                                    <i class="feather feather-check"></i> Unban User
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('user-management.ban', $user->id) }}" method="post" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to ban this user?')">
                                                    <i class="feather feather-x"></i> Ban User
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('user-management.destroy', $user->id) }}" method="post" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                <i class="feather feather-trash-2"></i> Delete User
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <span class="badge badge-secondary">Current User</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="widget-holder widget-outside-header col-lg-4">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">info</i> Quick Actions</h5>
            </div>
            <div class="widget">
                <div class="widget-body">
                    <div class="list-group">
                        <a href="{{ route('user-management.edit', $user->id) }}" class="list-group-item list-group-item-action">
                            <i class="feather feather-edit mr-2"></i> Edit User
                        </a>
                        <a href="{{ route('user-management.index') }}" class="list-group-item list-group-item-action">
                            <i class="feather feather-arrow-left mr-2"></i> Back to Users
                        </a>
                        <a href="{{ route('dashboard.index') }}" class="list-group-item list-group-item-action">
                            <i class="feather feather-home mr-2"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer') 