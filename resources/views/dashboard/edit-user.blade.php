@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Edit User</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Update user information</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user-management.index') }}">User Management</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-8 mx-auto">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">edit</i> Edit User: {{ $user->full_name }}</h5>
            </div>
            <div class="widget">
                <div class="widget-body">
                    @include('components.alert')
                    
                    <form action="{{ route('user-management.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="staff_id">Staff ID</label>
                                <input type="text" name="staff_id" id="staff_id" class="form-control @error('staff_id') is-invalid @enderror" value="{{ old('staff_id', $user->staff_id) }}" required>
                                @error('staff_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="">Select Role</option>
                                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="firstname">First Name</label>
                                <input type="text" name="firstname" id="firstname" class="form-control @error('firstname') is-invalid @enderror" value="{{ old('firstname', $user->firstname) }}" required>
                                @error('firstname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="lastname">Last Name</label>
                                <input type="text" name="lastname" id="lastname" class="form-control @error('lastname') is-invalid @enderror" value="{{ old('lastname', $user->lastname) }}" required>
                                @error('lastname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="othername">Other Name (Optional)</label>
                                <input type="text" name="othername" id="othername" class="form-control @error('othername') is-invalid @enderror" value="{{ old('othername', $user->othername) }}">
                                @error('othername')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <small class="form-text text-muted">Upload a profile image (JPEG, PNG, JPG, GIF up to 2MB). Leave empty to keep current image.</small>
                                
                                @if($user->profile_image_url !== asset('demo/users/use.jpg'))
                                    <div class="mt-2">
                                        <small class="text-muted">Current profile image:</small><br>
                                        <img src="{{ $user->profile_image_url }}" class="rounded-circle mt-1" width="50" height="50" alt="Current Profile">
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather feather-save"></i> Update User
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