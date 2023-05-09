@extends('layouts.app-master')

@section('content')
<div class="card mt-4">
                <div class="card-body">
                    <!-- Grid row -->
                    <div class="row">
                        <!-- Grid column -->
                        <div class="col-md-12">
                            <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">Rooms</h2>
                            <div class="float-right mb-4 mr-3">
                            <a href="{{ route('rooms.create') }}" class="btn btn-success me-2 ml-4">Add Room</a>
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
                                <th>Room Name</th>
                                <th>Date Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <!--Table head-->
                        <!--Table body-->
                        <tbody>
                            @forelse($rooms as $room)
                            <tr>
                                
                                <th scope="row">{!! QrCode::generate($room->id); !!}</th>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->created_at->format('M d, Y') }}</td>
                                <td>
                                    
                                    <form id="delete" method="POST" action="{{ route('rooms.destroy', [$room->id]) }}" class="m-0">
                                        @csrf
                                        <a href="{{ route('rooms.edit', [$room->id]) }}" class="btn btn-success me-2ml-0">Edit</a>
                                        <a href="{{ route('rooms.seat', [$room->id]) }}" class="btn btn-success me-2ml-0">View Seats</a>
                                        <a href="{{ route('rooms.download-qr', [$room->id]) }}" class="btn btn-success me-2ml-0">Download QR Code</a>
                                        <input type="submit" value="Delete" class="btn btn-danger me-2">
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan='4' class='text-center'>No data available.</td>
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