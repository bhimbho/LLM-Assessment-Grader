@include('layouts.header')
<main class="main-wrapper clearfix">
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Edit Assessment</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Update assessment details</p>
        </div>
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('question-bank.index') }}">Question Bank</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('assessment.show', $assessment->question->id) }}">Assessments</a>
                </li>
                <li class="breadcrumb-item active">Edit Assessment</li>
            </ol>
        </div>
    </div>

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-8">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">edit</i> Edit Assessment</h5>
                <div class="widget-actions">
                    <a href="{{ route('assessment.show', $assessment->question->id) }}" class="btn btn-secondary">
                        <i class="feather feather-arrow-left"></i> Back to Assessments
                    </a>
                </div>
            </div>
            <div class="widget-bg">
                <div class="widget-body">
                    @include('components.alert')
                    
                    <form action="{{ route('assessment.update', $assessment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="score">Score <span class="text-danger">*</span></label>
                                    <input type="number" 
                                           class="form-control @error('score') is-invalid @enderror" 
                                           id="score" 
                                           name="score" 
                                           value="{{ old('score', $assessment->score) }}" 
                                           min="0" 
                                           max="100" 
                                           step="0.01" 
                                           required>
                                    @error('score')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Score out of {{ $assessment->question->max_total }}</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="student_id">Student ID</label>
                                    <select class="form-control @error('student_id') is-invalid @enderror" 
                                            id="student_id" 
                                            name="student_id">
                                        <option value="">Select Student</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->student_id }}" 
                                                    {{ old('student_id', $assessment->student_id) == $student->student_id ? 'selected' : '' }}>
                                                {{ $student->student_id }} - {{ $student->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('student_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Leave empty if student is not in the system</small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Current Percentage</label>
                                    <div class="form-control-plaintext">
                                        <span class="badge badge-{{ $assessment->percentage >= 70 ? 'success' : ($assessment->percentage >= 50 ? 'warning' : 'danger') }}">
                                            {{ number_format($assessment->percentage, 2) }}%
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="feather feather-save"></i> Update Assessment
                                </button>
                                <a href="{{ route('assessment.show', $assessment->question->id) }}" class="btn btn-secondary">
                                    <i class="feather feather-x"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="widget-holder widget-outside-header col-lg-4">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">info</i> Assessment Details</h5>
            </div>
            <div class="widget-bg">
                <div class="widget-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Question:</strong></td>
                            <td>{{ substr($assessment->question->question_text, 0, 50) }}{{ strlen($assessment->question->question_text) > 50 ? '...' : '' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Course Code:</strong></td>
                            <td>{{ $assessment->question->course_code }}</td>
                        </tr>
                        <tr>
                            <td><strong>Session:</strong></td>
                            <td>{{ $assessment->question->session }}</td>
                        </tr>
                        <tr>
                            <td><strong>Level:</strong></td>
                            <td>{{ $assessment->question->level }}</td>
                        </tr>
                        <tr>
                            <td><strong>Semester:</strong></td>
                            <td>{{ $assessment->question->semester }}</td>
                        </tr>
                        <tr>
                            <td><strong>Max Score:</strong></td>
                            <td>{{ $assessment->question->max_total }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge badge-{{ $assessment->status === 'completed' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($assessment->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $assessment->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>

                    @if($assessment->uploads->count() > 0)
                        <div class="mt-3">
                            <h6>Uploaded Files:</h6>
                            @foreach($assessment->uploads as $upload)
                                <a href="{{ Storage::url($upload->url) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                    <i class="feather feather-download"></i> File {{ $loop->iteration }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scoreInput = document.getElementById('score');
    const maxScore = {{ $assessment->question->max_total }};
    
    scoreInput.addEventListener('input', function() {
        const score = parseFloat(this.value);
        if (score > maxScore) {
            this.setCustomValidity(`Score cannot exceed ${maxScore}`);
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>

@include('layouts.footer') 