@extends('admin.master')
@section('content')
    <div class="card m-2 p-2" style="box-shadow: 0px 0px 5px 5px rgba(194,215,236,0.63)">
        <div class="card-header d-flex justify-content-between">

        </div>
        <div class="card-body">

                <h1 class="text text-center text-dark">Jarayon</h1>
                <hr>
                <h3 class="text text-dark"><span class="fw-bolder badge text-primary">Mavzu: </span> {{$process->theme->name}}</h3>
                <hr>
                <h4 class="text text-dark"><span class="fw-bolder badge text-primary">Izoh: </span> {!! $process->theme->description !!}</h4>
                <hr>
                <h4 class=" text-dark"><span class="fw-bolder badge text-primary">Talaba: </span> {{$process->theme->student_name}}</h4>
                <hr>
                <h4 class=" text-dark"><span class="fw-bolder badge text-primary">Guruh: </span>{{$process->theme->level}} {{$process->theme->group_name}} </h4>
                <hr>
            <div class="d-flex">
            <div class="m-2">
            @if($process->link != null)
                    <a href="{{$process->link}}" class="btn btn-primary"> Guthub repository</a>
                @else
                    <h4 class=" text-dark"><span class="fw-bolder badge text-primary">Github link: </span> <span class="badge bg-danger">Yuklanmagan</span> </h4>

            @endif
            </div>
            <div class="m-2">
            @if($process->file != null)


                    <a href="{{asset($process->file)}}" class="btn btn-primary">Yuklangan fayl</a>

                @else
                    <h4 class=" text-dark"><span class="fw-bolder badge text-primary">Fayl: </span> <span class="badge bg-danger">Yuklanmagan</span> </h4>
            @endif
            </div>
            </div>
                <hr>
                <form action="{{route('update-process')}}" method="post" class="card p-3  border-primary border-2">@csrf
                    <input type="hidden" name="id" value="{{$process->id}}">
                    <div class="mb-3">
                        <label for="student_textarea " class="fw-bolder badge fs-4 text-primary">Mundarija:</label>
                        <textarea name="process" id="student_textarea" cols="30" rows="10"  class="form-control">

                        {!!   $process->content !!}

                    </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="percentage" class="fw-bolder badge fs-4 text-primary">Bajarilgan ish foizi:</label>
                        <select name="percentage" id="percentage" class="form-select">
                            @for($i=0;$i<101;$i+=5)
                                <option value="{{$i}}" @if($process->theme->percentage==$i) selected @endif>{{$i}}%</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="statusi" class="fw-bolder badge fs-4 text-primary">Holati:</label>
                        <select name="status" id="statusi" class="form-select">
                            <option value="process" @if($process->theme->status=="process") selected @endif>Jarayonda</option>
                            <option value="end" @if($process->theme->status=="end") selected @endif>Topshirildi</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary p-2">O'zgarishlarni saqlash</button>
                    </div>

                </form>

        </div>
    </div>




@endsection

