@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Assess Student</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Create Assessment</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('assessment.show', $question->id) }}">Question Bank</a>
                </li>
                <li class="breadcrumb-item active">Create Assessment</li>
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
                <h5 class="widget-title">Create Assessment for {{ $question->course_code }} - {{ $question->session }} - Level {{ $question->level }}</h5>
                <!-- /.widget-actions -->
            </div>
            <!-- /.widget-heading -->
            <div class="widget">
                <div class="widget-body pb-0">
                    @include('components.alert')
                    <form action="{{ route('assessment.store', $question->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                        <label for="assessment_files">Student Assessment File (This can be a screenshot of the student's assessment or pdf file) 
                            {{-- <span class="tooltip-top" data-toggle="tooltip" data-placement="top" title="only upload a file containing the question(s) if question text is not provided"> --}}
                            {{-- <i class="feather feather-info text-warning"></i> --}}
                            {{-- </span> --}}
                        </label>
                            <input type="file" name="assessment_files[]" id="assessment_files" accept="image/*, application/pdf" class="form-control" multiple>
                        </div>
                        <div>
                            <label for="llm_model">LLM Model</label>
                            <select name="llm_model" id="llm_model" class="form-control">
                                <option value="">Select LLM Model</option>
                                <option value="gpt-4o">GPT-4o</option>
                                <option value="gemini-pro">Gemini Pro</option>
                                <option value="claude-3-5-sonnet">Claude 3.5 Sonnet</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload Assessment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
