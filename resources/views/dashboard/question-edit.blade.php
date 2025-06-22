@include('layouts.header')
<main class="main-wrapper clearfix">
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <h6 class="page-title-heading mr-0 mr-r-5">Question Bank</h6>
            <p class="page-title-description mr-0 d-none d-md-inline-block">Edit Question</p>
        </div>
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('question-bank.index') }}">Question Bank</a>
                </li>
                <li class="breadcrumb-item active">Edit Question</li>
            </ol>
        </div>
    </div>

    <div class="widget-list row">
        <div class="widget-holder widget-outside-header col-lg-12">
            <div class="widget-heading">
                <h5 class="widget-title"><i class="material-icons mr-2">edit</i> Edit Question</h5>
                <div class="widget-actions">
                    <a href="{{ route('question-bank.index') }}" class="btn btn-secondary">Back to Questions</a>
                </div>
            </div>
            <div class="widget">
                <div class="widget-body pb-0">
                    @include('components.alert')
                    <form action="{{ route('question-bank.update', $question->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="course_code">Course Code</label>
                                <input type="text" name="course_code" id="course_code" class="form-control" value="{{ old('course_code', $question->course_code) }}">
                                @error('course_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="session">Session</label>
                                <select name="session" id="session" class="form-control">
                                    <option value="">Select Session</option>
                                    <option value="2024/2025" {{ old('session', $question->session) == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                                    <option value="2025/2026" {{ old('session', $question->session) == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                                    <option value="2026/2027" {{ old('session', $question->session) == '2026/2027' ? 'selected' : '' }}>2026/2027</option>
                                    <option value="2027/2028" {{ old('session', $question->session) == '2027/2028' ? 'selected' : '' }}>2027/2028</option>
                                    <option value="2028/2029" {{ old('session', $question->session) == '2028/2029' ? 'selected' : '' }}>2028/2029</option>
                                    <option value="2029/2030" {{ old('session', $question->session) == '2029/2030' ? 'selected' : '' }}>2029/2030</option>
                                    <option value="2030/2031" {{ old('session', $question->session) == '2030/2031' ? 'selected' : '' }}>2030/2031</option>
                                    <option value="2031/2032" {{ old('session', $question->session) == '2031/2032' ? 'selected' : '' }}>2031/2032</option>
                                    <option value="2032/2033" {{ old('session', $question->session) == '2032/2033' ? 'selected' : '' }}>2032/2033</option>
                                </select>
                                @error('session')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="semester">Semester</label>
                                <select name="semester" id="semester" class="form-control">
                                    <option value="">Select Semester</option>
                                    <option value="1" {{ old('semester', $question->semester) == '1' ? 'selected' : '' }}>1st</option>
                                    <option value="2" {{ old('semester', $question->semester) == '2' ? 'selected' : '' }}>2nd</option>
                                    <option value="3" {{ old('semester', $question->semester) == '3' ? 'selected' : '' }}>3rd</option>
                                    <option value="4" {{ old('semester', $question->semester) == '4' ? 'selected' : '' }}>4th</option>
                                </select>
                                @error('semester')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="level">Level</label>
                                <select name="level" id="level" class="form-control">
                                    <option value="">Select Level</option>
                                    <option value="100" {{ old('level', $question->level) == '100' ? 'selected' : '' }}>100</option>
                                    <option value="200" {{ old('level', $question->level) == '200' ? 'selected' : '' }}>200</option>
                                    <option value="300" {{ old('level', $question->level) == '300' ? 'selected' : '' }}>300</option>
                                    <option value="400" {{ old('level', $question->level) == '400' ? 'selected' : '' }}>400</option>
                                    <option value="500" {{ old('level', $question->level) == '500' ? 'selected' : '' }}>500</option>
                                    <option value="600" {{ old('level', $question->level) == '600' ? 'selected' : '' }}>600</option>
                                    <option value="700" {{ old('level', $question->level) == '700' ? 'selected' : '' }}>700</option>
                                </select>
                                @error('level')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="max_total">Max Total</label>
                                <input type="number" name="max_total" id="max_total" class="form-control" value="{{ old('max_total', $question->max_total) }}">
                                @error('max_total')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="difficulty">Strictness Level</label>
                                <select name="difficulty" id="difficulty" class="form-control">
                                    <option value="">Select Difficulty</option>
                                    <option value="strict" {{ old('difficulty', $question->difficulty) == 'strict' ? 'selected' : '' }}>Strict</option>
                                    <option value="medium" {{ old('difficulty', $question->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="lenient" {{ old('difficulty', $question->difficulty) == 'lenient' ? 'selected' : '' }}>Lenient</option>
                                </select>
                                @error('difficulty')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label for="question_text">Question Text<span class="tooltip-top" data-toggle="tooltip" data-placement="top" title="provide the question text if you don't want to upload a file"><i class="feather feather-info text-warning"></i></span></label>
                                <textarea name="question_text" id="question_text" class="form-control" rows="7">{{ old('question_text', $question->question_text) }}</textarea>
                                @error('question_text')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            @if($question->questionUpload)
                            <div class="form-group col-md-12">
                                <label>Current Question File</label>
                                <div class="alert alert-info">
                                    <strong>Current file:</strong> 
                                    <a href="{{ Storage::url($question->questionUpload->url) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="feather feather-download"></i> View Current File
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            <div class="form-group col-md-12">
                                <label for="question_file">New Question File (Optional)
                                    <span class="tooltip-top" data-toggle="tooltip" data-placement="top" title="only upload a file containing the question(s) if question text is not provided">
                                    <i class="feather feather-info text-warning"></i>
                                    </span>
                                </label>
                                <input type="file" name="question_file" id="question_file" class="form-control" accept="image/*,application/pdf">
                                @error('question_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            @if($question->answerUpload)
                            <div class="form-group col-md-12">
                                <label>Current Answer File</label>
                                <div class="alert alert-info">
                                    <strong>Current file:</strong> 
                                    <a href="{{ Storage::url($question->answerUpload->url) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="feather feather-download"></i> View Current File
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            <div class="form-group col-md-12">
                                <label for="answer_file">New Answer File (Optional)</label>
                                <input type="file" name="answer_file" id="answer_file" class="form-control" accept="image/*,application/pdf">
                                @error('answer_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-primary">Update Question</button>
                                <a href="{{ route('question-bank.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@include('layouts.footer') 