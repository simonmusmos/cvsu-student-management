@extends('layouts.app-master')

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12">
                    <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">Edit Room</h2>
                    <div class="float-left mb-4 ml-3">
                    <a href="{{ route('rooms.index') }}" class="btn btn-danger me-2 ml-4">Back</a>
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

            <form id="update" method="POST" action="{{ route('rooms.update', [$room->id]) }}">
            @csrf
                <div class="m-4 row">
                    <!-- Grid column -->
                    <div class="col-md-7">
                        <div class="form-group">
							<label for="email">Room Name</label>
							<input type="text" id="name" name="name" value="{{ $room->name }}" class="form-control" placeholder="Room Name">
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