@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Question Bank</h6>
            {{-- <p class="page-title-description mr-0 d-none d-md-inline-block">statistics, charts and events</p> --}}
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Question Bank</li>
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
                <h5 class="widget-title"><i class="material-icons mr-2">error_outline</i> All Questions</h5>
                <div class="widget-actions">
                    <a href="{{ route('question-bank.create') }}" class="btn btn-primary">Add Question</a>
                </div>
                <!-- /.widget-actions -->
            </div>
            <!-- /.widget-heading -->
            <div class="widget-bg">
                <div class="widget-body pb-0">
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
                                    <td>{{ substr($question->question_text, 0, 100) }}</td>
                                    @if ($question->uploads !== null || $question->answerUpload !== null)
                                        <td>
                                            @if ($question->uploads !== null)
                                                <a href="{{ asset('storage/'.$question->uploads?->url) }}" target="download"><i class="feather feather-download"></i></a>
                                            @endif
                                            @if ($question->answerUpload !== null)
                                                <a href="{{ asset('storage/'.$question->answerUpload?->url) }}" target="download"><i class="feather feather-download"></i></a>
                                            @endif
                                        </td>
                                    @else
                                        <td>No question or answer uploaded</td>
                                    @endif
                                    <td>{{ $question->max_total }}</td>
                                    <td>
                                        <a href="{{ route('question-bank.edit', $question->id) }}">
                                            <i class="feather feather-edit"></i>
                                        </a>
                                        <a href="{{ route('question-bank.destroy', $question->id) }}">
                                            <i class="feather feather-trash-2"></i>
                                        </a>
                                        {{-- add upload button --}}
                                        <a href="{{ route('assessment.show', $question->id) }}">
                                            <i class="feather feather-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No questions found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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
<!-- /.main-wrappper -->
</div>
<!-- /.content-wrapper -->
@include('layouts.footer')