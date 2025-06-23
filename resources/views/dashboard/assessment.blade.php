@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr/-r-5">Assessment Manager</h6>
            {{-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> --}}
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('question-bank.index') }}">Question Bank</a>
                </li>
                <li class="breadcrumb-item active">Assessment</li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>
    <!-- /.page-title -->
    <!-- =================================== -->
    <!-- Different data widgets ============ -->
    <!-- =================================== -->

    <div class="widget-list row">
        <!-- /.widget-holder -->
        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">error_outline</i> All Assessments for {{ $question->course_code }} - {{ $question->session }} - Level {{ $question->level }}</h5>
                <div class="widget-actions">
                    <a href="{{ route('assessment.export', $question->id) }}" class="btn btn-success mr-2">
                        <i class="feather feather-download"></i> Export CSV
                    </a>
                    <a href="{{ route('assessment.create', $question->id) }}" class="btn btn-primary">Add Assessment</a>
                </div>
                <!-- /.widget-actions -->
            </div>
            <!-- /.widget-heading -->
            <div class="widget-bg">
                <div class="widget-body pb-0">
                    @include('components.alert')
                    <table class="table table-bordered table-responsive" data-toggle="datatables">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Course Code</th>
                                <th>Student ID</th>
                                <th>Score</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Other Data</th>
                                <th>Uploaded Files</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assessments as $assessment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $assessment->question->course_code }}</td>
                                    <td>
                                        @if($assessment->student_id)
                                            <span class="badge badge-success">{{ $assessment->student_id }}</span>
                                        @else
                                            @php
                                                $response = json_decode($assessment->response, true);
                                                $aiStudentId = $response['student_id'] ?? 'AI Could not Determine';
                                            @endphp
                                            <span class="badge badge-warning">{{ $aiStudentId }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $assessment->score >= 70 ? 'success' : ($assessment->score >= 50 ? 'warning' : 'danger') }}">
                                            {{ $assessment->score ?? '0' }}/{{ $assessment->question->max_total }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $assessment->percentage >= 70 ? 'success' : ($assessment->percentage >= 50 ? 'warning' : 'danger') }}">
                                            {{ number_format($assessment->percentage ?? 0, 1) }}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $assessment->status === 'completed' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($assessment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($assessment->response)
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-info" 
                                                    data-toggle="modal" 
                                                    data-target="#responseModal{{ $assessment->id }}"
                                                    title="View Response Data">
                                                <i class="feather feather-eye"></i>
                                            </button>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assessment->uploads->count() > 0)
                                            @foreach($assessment->uploads as $upload)
                                                <a href="{{ Storage::url($upload->url) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                                    <i class="feather feather-download"></i> File {{ $loop->iteration }}
                                                </a>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No files</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            <a href="{{ route('assessment.edit', $assessment->id) }}" class="btn btn-info btn-sm" title="Edit Assessment">
                                                <i class="feather feather-edit"></i>
                                            </a>
                                            <form action="{{ route('assessment.destroy', $assessment->id) }}" method="post" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Assessment" onclick="return confirm('Are you sure you want to delete this assessment? This action cannot be undone.')">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No assessments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-center mt-3">
                        {{ $assessments->links() }}
                    </div>
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-bg -->
        </div>
        <!-- /.widget-holder -->
    </div>
    <!-- /.widget-list -->
    <hr>
</main>

<!-- Response Detail Modals -->
@foreach($assessments as $assessment)
    @if($assessment->response)
        <div class="modal fade" id="responseModal{{ $assessment->id }}" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel{{ $assessment->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="responseModalLabel{{ $assessment->id }}">
                            Assessment Response Details - {{ $assessment->question->course_code }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Student ID:</strong> 
                                @if($assessment->student_id)
                                    <span class="badge badge-success">{{ $assessment->student_id }}</span>
                                @else
                                    @php
                                        $response = json_decode($assessment->response, true);
                                        $aiStudentId = $response['student_id'] ?? 'AI Could not Determine';
                                    @endphp
                                    <span class="badge badge-warning">{{ $aiStudentId }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <strong>Score:</strong> 
                                <span class="badge badge-{{ $assessment->score >= 70 ? 'success' : ($assessment->score >= 50 ? 'warning' : 'danger') }}">
                                    {{ $assessment->score ?? '0' }}/{{ $assessment->question->max_total }}
                                </span>
                            </div>
                        </div>
                        
                        @php
                            $responseData = json_decode($assessment->response, true);
                            $explanation = $responseData['explanation'] ?? '';
                            $analysis = $responseData['analysis of the student answer'] ?? '';
                            $improvements = $responseData['area to improve on'] ?? '';
                        @endphp
                        
                        <div class="response-data">
                            <h6><i class="feather feather-database mr-2"></i>Complete AI Response Data:</h6>
                            @if(is_array($responseData))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            @if($explanation)
                                                <tr class="table-info">
                                                    <td><strong><i class="feather feather-info mr-1"></i>Explanation:</strong></td>
                                                    <td>{{ $explanation }}</td>
                                                </tr>
                                            @endif
                                            @if($analysis)
                                                <tr class="table-warning">
                                                    <td><strong><i class="feather feather-search mr-1"></i>Analysis of Student Answer:</strong></td>
                                                    <td>{{ $analysis }}</td>
                                                </tr>
                                            @endif
                                            @if($improvements)
                                                <tr class="table-danger">
                                                    <td><strong><i class="feather feather-alert-triangle mr-1"></i>Areas to Improve On:</strong></td>
                                                    <td>{{ $improvements }}</td>
                                                </tr>
                                            @endif
                                            @foreach($responseData as $key => $value)
                                                @if(!in_array($key, ['explanation', 'analysis of the student answer', 'area to improve on']))
                                                    <tr>
                                                        <td><strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong></td>
                                                        <td>{{ is_string($value) ? $value : json_encode($value) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <pre>{{ $assessment->response }}</pre>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<style>
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

.btn-group-vertical .btn i,
.btn-group-vertical form .btn i,
.btn-group-vertical button i {
    display: inline-block;
    text-align: center;
    width: 100%;
    line-height: 1;
}

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

.btn-info {
    background-color: #17a2b8 !important;
    border-color: #17a2b8 !important;
    color: white !important;
}

.btn-danger {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: white !important;
}

.btn-info:hover {
    background-color: #138496 !important;
    border-color: #138496 !important;
    color: white !important;
}

.btn-danger:hover {
    background-color: #c82333 !important;
    border-color: #c82333 !important;
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

.response-data pre {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    padding: 1rem;
    white-space: pre-wrap;
    word-wrap: break-word;
    max-height: 300px;
    overflow-y: auto;
}

.explanation-text {
    white-space: pre-wrap;
    word-wrap: break-word;
    line-height: 1.6;
    font-size: 0.95rem;
}
</style>

<!-- /.content-wrapper -->
@include('layouts.footer')