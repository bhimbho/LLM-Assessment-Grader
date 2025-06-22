@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Create New User</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Add a new user to the system</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user-management.index') }}">User Management</a></li>
                <li class="breadcrumb-item active">Create User</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-8 mx-auto">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">person_add</i> Create New User</h5>
            </div>
            <div class="widget">
                <div class="widget-body">
                    @include('components.alert')
                    
                    <form action="{{ route('user-management.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="staff_id">Staff ID</label>
                                <input type="text" name="staff_id" id="staff_id" class="form-control @error('staff_id') is-invalid @enderror" value="{{ old('staff_id') }}" required>
                                @error('staff_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">Select Role</option>
                                    <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="firstname">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname') }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="lastname">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname') }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="othername">Other Name (Optional)</label>
                                <input type="text" name="othername" id="othername" class="form-control @error('othername') is-invalid @enderror" value="{{ old('othername') }}">
                                @error('othername')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Password must be at least 8 characters long</small>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="profile_image">Profile Image (Optional)</label>
                                <div class="custom-file">
                                    <input type="file" name="profile_image" id="profile_image" class="custom-file-input @error('profile_image') is-invalid @enderror" accept="image/*">
                                    <label class="custom-file-label" for="profile_image">Choose file</label>
                                </div>
                                @error('profile_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Upload a profile image (JPEG, PNG, JPG, GIF up to 2MB)</small>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather feather-save"></i> Create User
                            </button>
                            <a href="{{ route('user-management.index') }}" class="btn btn-secondary ml-2">
                                <i class="feather feather-arrow-left"></i> Back to Users
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer') 