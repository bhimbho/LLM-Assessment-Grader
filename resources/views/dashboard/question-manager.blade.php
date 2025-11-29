@include('layouts.header')
<main class="main-wrapper clearfix">
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Question Bank</h6>
        </div>
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Question Bank</li>
            </ol>
        </div>
    </div>

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">error_outline</i> All Questions</h5>
                <div class="widget-actions">
                    <a href="{{ route('question-bank.create') }}" class="btn btn-primary">Add Question</a>
                </div>
            </div>
            <div class="widget-bg">
                <div class="widget-body pb-0">
                    @include('components.alert')
                    <table class="table table-bordered table-responsive" data-toggle="datatables" data-plugin-options='{"searching": false}'>
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Course Code</th>
                                <th>Session</th>
                                <th>Semester</th>
                                <th>Level</th>
                                <th>Difficulty</th>
                                <th>Question</th>
                                <th>Question & Answer File</th>
                                <th>Max Attainable Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($questions as $question)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $question->course_code }}</td>
                                    <td>{{ $question->session }}</td>
                                    <td>{{ $question->semester }}</td>
                                    <td>{{ $question->level }}</td>
                                    <td>{{ $question->difficulty }}</td>
                                    <td>
                                        @if (empty($question->question_text))
                                            <i class="material-icons text-danger" title="No question provided" data-toggle="tooltip">close</i>
                                        @else
                                            {{ substr($question->question_text, 0, 100) }}{{ strlen($question->question_text) > 100 ? '...' : '' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($question->questionUpload)
                                            <a href="{{ Storage::url($question->questionUpload->url) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="feather feather-download"></i> Question
                                            </a>
                                        @endif
                                        @if ($question->answerUpload)
                                            <a href="{{ Storage::url($question->answerUpload->url) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="feather feather-download"></i> Answer
                                            </a>
                                        @endif
                                        @if (!$question->questionUpload && !$question->answerUpload)
                                            <span class="text-muted">No files uploaded</span>
                                        @endif
                                    </td>
                                    <td>{{ $question->max_total }}</td>
                                    <td class="text-center">
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            <a href="{{ route('question-bank.edit', $question->id) }}" class="btn btn-info btn-sm" title="Edit Question">
                                                <i class="feather feather-edit"></i>
                                            </a>
                                            <a href="{{ route('assessment.show', $question->id) }}" class="btn btn-warning btn-sm" title="View Assessments">
                                                <i class="feather feather-eye"></i>
                                            </a>
                                            <form action="{{ route('question-bank.destroy', $question->id) }}" method="post" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Question" onclick="return confirm('Are you sure you want to delete this question? This will also delete all related assessments and their uploads. This action cannot be undone.')">
                                                    <i class="feather feather-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No questions found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <hr>
</main>

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

.btn-warning {
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
    color: #212529 !important;
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

.btn-warning:hover {
    background-color: #e0a800 !important;
    border-color: #e0a800 !important;
    color: #212529 !important;
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
</style>

@include('layouts.footer')