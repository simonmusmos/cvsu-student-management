@extends('layouts.app-master')

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12">
                    <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">Add Student</h2>
                    <div class="float-left mb-4 ml-3">
                    @if(request()->t != 0 || request()->t != '')
                        <a href="{{ (request()->b != 0 || request()->b != '') ? route('sections.students', [request()->b]) : route('students.index') }}?t={{ request()->t }}" class="btn btn-danger me-2 ml-4">Back</a>
                    @else
                        <a href="{{ (request()->b != 0 || request()->b != '') ? route('sections.students', [request()->b]) : route('students.index') }}" class="btn btn-danger me-2 ml-4">Back</a>
                    @endif
                    
                    </div>
                    
                </div>
                <!-- Grid column -->
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            <form id="update" method="POST" action="{{ route('students.update', [$student->id]) }}">
            @csrf
                <div class="m-4 row">
                    <!-- Grid column -->
                    <div class="col-md-7">
                        <div class="form-group">
							<label for="email">Student First Name</label>
							<input type="text" id="first_name" value="{{ $student->first_name ?? '' }}" name="first_name" class="form-control" placeholder="Student First Name">
						</div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
							<label for="email">Student First Name</label>
							<input type="text" id="last_name" value="{{ $student->last_name ?? '' }}" name="last_name" class="form-control" placeholder="Student Last Name">
						</div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
							<label for="email">Student Number</label>
							<input type="text" id="student_number" value="{{ $student->student_number ?? '' }}" name="student_number" class="form-control" placeholder="Student Number">
						</div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
							<label for="email">Email</label>
							<input type="text" id="email" value="{{ $student->email ?? '' }}" name="email" class="form-control" placeholder="Email">
						</div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
							<label for="email">Section</label>
							<select id="section" name="section" class="form-control">
                                <option disabled selected>Select Section</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->id }}" {{ $student->section_id == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                @endforeach
                            </select>
						</div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <input type="submit" class="btn btn-success">
						</div>
                    </div>
                    <!-- Grid column -->
                </div>
                
            </form>
        </div>
    </div>
@endsection