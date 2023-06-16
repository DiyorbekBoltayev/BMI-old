@extends('admin.master')
@section('content')

    <div class="card mt-3">
        <h2 class="text text-center mt-2"> Xabarlar</h2>
        <div class="card-body m-3 ">


            @foreach($messages as $message)
                    @if($message->type == 0)
                        <div class="card w-75 float-start m-2" style="box-shadow: 0px 0px 4px 4px #dbdcde; border-radius: 0px 25px 25px 50px; border: 2px solid darkblue  ">
                            <div class="p-3">
                                <p style="color: darkblue;" ><i class="bx bx-user-circle" style="font-size: 30px;"></i> {{ $student_name }}</p>
                                <p style="color: black">{{ $message->message }}
                                    <span class="float-end"><i class="bx bx-time-five"></i> {{ date('d/m/y H:i', strtotime($message->created_at)) }}</span>
                                </p>
                            </div>
                        </div>

                    @else
                        <div class="card w-75 float-end m-2 chat" style="box-shadow: 0px 0px 4px 4px #e1e3e5;border-radius: 25px 50px 0px 25px; border: 2px solid darkblue">
                            <div class="p-3">
                                <p style="color: darkblue"><i class="bx bx-user-circle" style="font-size: 30px;"></i> {{ $teacher_name }}</p>
                                <p style="color: black">{{ $message->message }}
                                    <span class="float-end"> <i class="bx bx-time-five"></i> {{ date('d/m/y H:i', strtotime($message->created_at)) }}
                                        @if($message->is_read)
                                            <i class="float- bx bx-check-double" style="font-size: 25px;"></i>
                                        @else
                                            <i class="bx bx-check" style="font-size: 25px;"></i>
                                        @endif
            </span>
                                </p>
                            </div>
                        </div>

                    @endif
                @endforeach
        </div>
    </div>
    <div class="card">
        <form action="{{route('send-message')}}" class="m-3 border-1 border-primary" method="post">
            @csrf
            <input type="hidden" name="chat_id" value="{{$chat_id}}">
            <input type="hidden" name="type" value="1">
            <div class="input-group">
                <input class="form-control border-2 border-primary" placeholder="Xabar matni..." type="text" name="message">
                <button class=" btn btn-primary" type="submit"> <i class="bx bxl-telegram"></i> Yuborish </button>
            </div>
        </form>
    </div>
    <script>
        window.scrollTo(0, document.body.scrollHeight);
    </script>
@endsection