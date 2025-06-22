@include('layouts.header')
<main class="main-wrapper clearfix">
    <!-- Page Title Area -->
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Question Bank</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Create Question</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('question-bank.index') }}">Question Bank</a>
                </li>
                <li class="breadcrumb-item active">Create Question</li>
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
            <div class="widget">
                <div class="widget-body pb-0">
                    @include('components.alert')
                    <form action="{{ route('question-bank.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="course_code">Course Code</label>
                                <input type="text" name="course_code" id="course_code" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="session">Session</label>
                                <select name="session" id="session" class="form-control">
                                    <option value="">Select Session</option>
                                    <option value="2024/2025">2024/2025</option>
                                    <option value="2025/2026">2025/2026</option>
                                    <option value="2026/2027">2026/2027</option>
                                    <option value="2027/2028">2027/2028</option>
                                    <option value="2028/2029">2028/2029</option>
                                    <option value="2029/2030">2029/2030</option>
                                    <option value="2030/2031">2030/2031</option>
                                    <option value="2031/2032">2031/2032</option>
                                    <option value="2032/2033">2032/2033</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="semester">Semester</label>
                                <select name="semester" id="semester" class="form-control">
                                    <option value="">Select Semester</option>
                                    <option value="1">1st</option>
                                    <option value="2">2nd</option>
                                    <option value="3">3rd</option>
                                    <option value="4">4th</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="level">Level</label>
                                <select name="level" id="level" class="form-control">
                                    <option value="">Select Level</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                    <option value="500">500</option>
                                    <option value="600">600</option>
                                    <option value="700">700</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="max_total">Max Total</label>
                                <input type="number" name="max_total" id="max_total" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="difficulty">Strictness Level</label>
                                <select name="difficulty" id="difficulty" class="form-control">
                                    <option value="">Select Difficulty</option>
                                    <option value="strict">Strict</option>
                                    <option value="medium">Medium</option>
                                    <option value="lenient">Lenient</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="question_text">Question Text<span class="tooltip-top" data-toggle="tooltip" data-placement="top" title="provide the question text if you don't want to upload a file"><i class="feather feather-info text-warning"></i></span></label>
                                <textarea name="question_text" id="question_text" class="form-control" rows="7"></textarea>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="text-center">OR</div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="question_file">Question File
                                    <span class="tooltip-top" data-toggle="tooltip" data-placement="top" title="only upload a file containing the question(s) if question text is not provided">
                                    <i class="feather feather-info text-warning"></i>
                                    </span>
                                </label>
                                <input type="file" name="question_file" id="question_file" class="form-control" accept="image/*,application/pdf">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="answer_file">Answer File (Optional)</label>
                                <input type="file" name="answer_file" id="answer_file" class="form-control" accept="image/*,application/pdf">
                            </div>
                            <button type="submit" class="btn btn-primary">Create Question</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer')
