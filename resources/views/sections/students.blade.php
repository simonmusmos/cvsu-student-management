@extends('layouts.app-master')

@section('content')
<div class="card mt-4">
                <div class="card-body">
                    <!-- Grid row -->
                    <div class="row">
                        <!-- Grid column -->
                        <div class="col-md-12">
                            <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">{{ $section->name }} Students</h2>
                            <div class="float-left mb-4 mr-3">
                            @if(request()->t != 0 || request()->t != '')
                                <a href="{{ route('teachers.sections', [request()->t]) }}" class="btn btn-danger me-2 ml-4">Back</a>
                            @else
                                <a href="{{ route('sections.index') }}" class="btn btn-danger me-2 ml-4">Back</a>
                            @endif
                            
                            <!-- <a href="{{ route('teachers.create') }}" class="btn btn-success me-2 ml-4">Add Teacher</a> -->
                            </div>
                            <form id="search">
                                <div class="input-group md-form form-sm form-2 pl-0">
                                    <input class="form-control my-0 py-1 pl-3 purple-border" value="{{ request()->search }}" name="search" type="text" placeholder="Search something here..." aria-label="Search">
                                    <span class="input-group-addon waves-effect purple lighten-2" id="basic-addon1"><a><i class="fa fa-search white-text" aria-hidden="true"></i></a></span>
                                </div>
                            </form>
                            
                        </div>
                        <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                    <!--Table-->
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <table class="table table-striped">
                        <!--Table head-->
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Student Number</th>
                                <th>Email</th>
                                <th>Section</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            @forelse($students as $student)
                            <tr>
                                <th scope="row">{{ $student->id }}</th>
                                <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                <td>{{ $student->student_number }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->section->name }}</td>
                                <td>
                                    <form id="delete" method="POST" action="{{ route('students.destroy', [$student->id]) }}" class="m-0">
                                        @csrf
                                        @if(request()->t != 0 || request()->t != '')
                                            <a href="{{ route('students.edit', [$student->id]) }}?b={{ $section->id}}&t={{ request()->t }}" class="btn btn-success me-2ml-0">Edit</a>
                                        @else
                                            <a href="{{ route('students.edit', [$student->id]) }}?b={{ $section->id}}" class="btn btn-success me-2ml-0">Edit</a>
                                        @endif
                                        <input type="submit" value="Delete" class="btn btn-danger me-2 ml-4">
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='6' class='text-center'>No data available.</td>
                            </tr>
                            @endforelse
                            <!-- <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr> -->
                        </tbody>
                        <!--Table body-->
                    </table>
                    <!--Table-->
                </div>
            </div>
@endsection