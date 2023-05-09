@extends('layouts.app-master')

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12">
                    <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">Add Section</h2>
                    <div class="float-left mb-4 ml-3">
                    <a href="{{ route('sections.index') }}" class="btn btn-danger me-2 ml-4">Back</a>
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

            <form id="create" method="POST" action="{{ route('sections.add') }}">
            @csrf
                <div class="m-4 row">
                    <!-- Grid column -->
                    <div class="col-md-7">
                        <div class="form-group">
							<label for="email">Section Name</label>
							<input type="text" id="name" value="{{ old('name') ?? '' }}" name="name" class="form-control" placeholder="Section Name">
						</div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
							<label for="email">Teacher</label>
							<select id="teacher" name="teacher" class="form-control">
                                <option disabled selected>Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher') == $teacher->id ? 'selected' : '' }}>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
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