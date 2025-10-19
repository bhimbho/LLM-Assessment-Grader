@include('layouts.header')
<main class="main-wrapper clearfix">
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Add New Student</h6>
        </div>
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('student-management.index') }}">Student Management</a></li>
                <li class="breadcrumb-item active">Add Student</li>
            </ol>
        </div>
    </div>

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">person_add</i> Add New Student</h5>
                <div class="widget-actions">
                    <a href="{{ route('student-management.index') }}" class="btn btn-secondary">
                        <i class="feather feather-arrow-left"></i> Back to Students
                    </a>
                </div>
            </div>
            <div class="widget-bg">
                <div class="widget-body">
                    @include('components.alert')
                    
                    <form action="{{ route('student-management.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstname" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('firstname') is-invalid @enderror" 
                                           id="firstname" 
                                           name="firstname" 
                                           value="{{ old('firstname') }}" 
                                           required>
                                    @error('firstname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('lastname') is-invalid @enderror" 
                                           id="lastname" 
                                           name="lastname" 
                                           value="{{ old('lastname') }}" 
                                           required>
                                    @error('lastname')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="othername" class="form-label">Other Name</label>
                                    <input type="text" 
                                           class="form-control @error('othername') is-invalid @enderror" 
                                           id="othername" 
                                           name="othername" 
                                           value="{{ old('othername') }}">
                                    @error('othername')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('student_id') is-invalid @enderror" 
                                           id="student_id" 
                                           name="student_id" 
                                           value="{{ old('student_id') }}" 
                                           required>
                                    @error('student_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    <small class="form-text text-muted">Login credentials will be sent to this email address.</small>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="material-icons mr-2">info</i>
                            <strong>Note:</strong> A default password will be automatically generated and sent to the student's email address. The student can use their Student ID and this password to log in to the student portal.
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="feather feather-save"></i> Add Student
                            </button>
                            <a href="{{ route('student-management.index') }}" class="btn btn-secondary ml-2">
                                <i class="feather feather-x"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
