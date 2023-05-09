@extends('layouts.app-master')

@section('scripts')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".seats").on("click", function() {
            if($(this).attr('data-action') == "remove") {
                remove($(this).attr('id'));
            } else {
                add($(this).attr('id'));
            }
            
        });
       
        function add(seat) {
            $.ajax({
                url: "{{route('rooms.seat.add', [$room->id])}}",
                method: "post",
                data: {
                    'seat': seat,
                },
                success:function(data) {
                    $("#" + data.id).attr('data-action', 'remove');
                    $("#" + data.id).removeClass('seat');
                    $("#" + data.id).addClass('seat-taken');
                }
            });
        }

        function remove(seat) {
            $.ajax({
                url: "{{route('rooms.seat.remove', [$room->id])}}",
                method: "post",
                data: {
                    'seat': seat,
                },
                success:function(data) {
                    $("#" + data.id).attr('data-action', 'add');
                    $("#" + data.id).addClass('seat');
                    $("#" + data.id).removeClass('seat-taken');
                }
            });
        }
    </script>
@endsection
@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12">
                    <h2 class="pt-3 pb-4 text-center font-bold font-up deep-purple-text">{{ $room->name }} Seat Arrangement</h2>
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
                    <div class="col-5 mr-2 row mx-auto" style="padding: 0">
                        @for($i = 1; $i <= $max_row; $i++)
                            @for($k = 01; $k <= $seat_per_row; $k++)
                                <div data-action = "{{ (in_array('a-'.$i.'-'.$k, $seats) ? 'remove' : 'add') }}" class="{{ (in_array('a-'.$i.'-'.$k, $seats) ? 'seat-taken' : 'seat') }} seats" id="a-{{ $i }}-{{ $k }}" style="background-color: red; width: 18%; height: 0; position: relative; padding-bottom: 20%; margin-left: 5px; margin-bottom: 5px">

                                </div>
                            @endfor
                        @endfor
                    </div>
                    <div class="col-5 ml-2 row mx-auto" style="padding:0">
                        @for($i = 1; $i <= $max_row; $i++)
                            @for($k = 01; $k <= $seat_per_row; $k++)
                                <div data-action = "{{ (in_array('a-'.$i.'-'.$k, $seats) ? 'remove' : 'add') }}" class="{{ (in_array('b-'.$i.'-'.$k, $seats) ? 'seat-taken' : 'seat') }} seats" id="b-{{ $i }}-{{ $k }}" style="background-color: red; width: 18%; height: 0; position: relative; padding-bottom: 20%; margin-left: 5px; margin-bottom: 5px">

                                </div>
                            @endfor
                        @endfor
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection