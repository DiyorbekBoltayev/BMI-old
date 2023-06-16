@extends('admin.master')
@section('content')
    <div class="card m-2 p-2" style="box-shadow: 0px 0px 5px 5px rgba(194,215,236,0.63)">
        <div class="card-header d-flex justify-content-between">

        </div>
        <div class="card-body">
            @if($process)
                <h1 class="text text-center text-dark">Jarayon</h1>
                <hr>
                <h3 class="text text-dark"><span
                            class="fw-bolder badge text-primary">Mavzu: </span> {{$process->theme->name}}</h3>
                <hr>
                <h4 class="text text-dark"><span
                            class="fw-bolder badge text-primary">Izoh: </span> {!!  $process->theme->description!!}</h4>
                <hr>
                <h4 class=" text-dark"><span
                            class="fw-bolder badge text-primary">Ilmiy rahbar: </span> {{$process->theme->teacher->name}}
                </h4>
                <hr>
                <h4 class=" text-dark"><span
                            class="fw-bolder badge text-primary">Bajarilgan ish: </span> {{$process->theme->percentage}} % (Ilmiy rahbar tomonidan belgilangan)
                </h4>
                <hr>
                <form action="{{route('update-process')}}" method="post" class="card p-3  border-primary border-2"
                      enctype="multipart/form-data">@csrf
                    <input type="hidden" name="id" value="{{$process->id}}">
                    <div class="mb-3">

                        <label for="student_textarea " class="fw-bolder badge fs-4 text-primary">Mundarija:</label>
                        <textarea name="process" id="student_textarea" cols="30" rows="10" class="form-control">
                        {!! $process->content !!}
                    </textarea>
                    </div>
                    @if($process->file != null)
                        <div class="mb-3">

                            <a href="{{asset($process->file)}}" class="btn btn-primary">Yuklangan faylni ko'rish</a>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="file" class="fw-bolder fs-4 text-primary">Yangi fayl
                            yuklash {{strtolower(" (.zip formatida)")}}:</label>
                        <input type="file" accept=".zip" class="form-control" name="file">
                    </div>

                    <div class="mb-3">
                        <label for="link" class="fw-bolder fs-4 text-primary">Github repository link</label>
                        <input type="text" id="link" name="link" class="form-control"
                               placeholder="https://github.com/kimdir/nimadir" value="{{$process->link}}">
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary p-2">O'zgarishlarni saqlash</button>
                    </div>

                </form>
            @else
                <h1 class="text text-center text-dark "><span> Sizda mavzu tanlanmagan</span></h1>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-primary d-flex align-items-center" href="{{route('themes')}}">Mavzu tanlash <i
                                class="m-1 bx bx-link-external"></i></a>
                </div>
            @endif

        </div>
    </div>
    <!-- Button trigger modal -->

@endsection

