@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Change Password</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Update your account password</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('account.profile') }}">Profile</a></li>
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-6 mx-auto">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">lock</i> Change Password</h5>
            </div>
            <div class="widget">
                <div class="widget-body">
                    @include('components.alert')
                    
                    <form action="{{ route('account.change-password.update') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Password must be at least 8 characters long</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather feather-save"></i> Change Password
                            </button>
                            <a href="{{ route('account.profile') }}" class="btn btn-secondary ml-2">
                                <i class="feather feather-arrow-left"></i> Back to Profile
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer') 