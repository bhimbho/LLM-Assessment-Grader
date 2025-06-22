@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Profile Management</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Manage your account information</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-8">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">person</i> Profile Information</h5>
            </div>
            <div class="widget">
                <div class="widget-body">
                    @include('components.alert')
                    
                    <form action="{{ route('account.profile.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
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
                            
                            <div class="form-group col-md-6">
                                <label for="staff_id">Staff ID</label>
                                <input type="text" id="staff_id" class="form-control" value="{{ $user->staff_id }}" readonly>
                                <small class="form-text text-muted">Staff ID cannot be changed</small>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="role">Role</label>
                                <input type="text" id="role" class="form-control" value="{{ ucfirst($user->role) }}" readonly>
                                <small class="form-text text-muted">Role cannot be changed</small>
                            </div>
                            
                            <div class="form-group col-md-12">
                                <label for="profile_image">Profile Image</label>
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
                                <i class="feather feather-save"></i> Update Profile
                            </button>
                            <a href="{{ route('account.change-password') }}" class="btn btn-secondary ml-2">
                                <i class="feather feather-lock"></i> Change Password
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="widget-holder widget-outside-header col-lg-4">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">info</i> Account Information</h5>
            </div>
            <div class="widget">
                <div class="widget-body">
                    <div class="media">
                        <div class="media-left">
                            <img src="{{ $user->profile_image_url }}" class="media-object rounded-circle" width="64" height="64" alt="Profile" id="profile-preview">
                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">{{ $user->full_name }}</h5>
                            <p class="text-muted">{{ $user->email }}</p>
                            <p class="text-muted">Staff ID: {{ $user->staff_id }}</p>
                            <p class="text-muted">Role: {{ ucfirst($user->role) }}</p>
                            <p class="text-muted">Member since: {{ $user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('profile_image');
    const preview = document.getElementById('profile-preview');
    const fileLabel = document.querySelector('.custom-file-label');
    
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            fileLabel.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            fileLabel.textContent = 'Choose file';
        }
    });
});
</script>

@include('layouts.footer') 