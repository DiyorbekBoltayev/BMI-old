@extends('admin.master')
@section('content')
    <div class="card">
        <div class="">
            <form action="{{route('filtered-themes')}}" method="get"
                  class="form-group d-flex justify-content-between align-items-center m-3">
                <h1 class="text text-center">Mavzular ro'yhati</h1>

                <table class="text-center m-2">
                    <tr>
                        <th>
                            <label for="select0">Semestr</label>
                        </th>
                        <th>
                            <label for="select1">Guruh</label>
                        </th>
                        <th>
                            <label for="select2">O'qituvchi</label>
                        </th>
                        <th>
                            <label for="select3">Holat</label>
                        </th>
                        <th>
                            <label for="select4">Amal</label>
                        </th>
                    </tr>
                    <tr>
                        <th>

                            <select name="semester" class="form-select" id="select0">
                                <option selected value="0">Barchasi</option>
                                <option @if($options->semester=="5-semestr") selected @endif value="5-semestr">
                                    5-semestr
                                </option>
                                <option @if($options->semester=="6-semestr") selected @endif value="6-semestr">
                                    6-semestr
                                </option>
                                <option @if($options->semester=="7-semestr") selected @endif value="7-semestr">
                                    7-semestr
                                </option>
                                <option @if($options->semester=="8-semestr") selected @endif value="8-semestr">
                                    8-semestr
                                </option>
                                <option @if($options->semester=="9-semestr") selected @endif value="9-semestr">
                                    9-semestr
                                </option>
                                <option @if($options->semester=="10-semestr") selected @endif value="10-semestr">
                                    10-semestr
                                </option>
                            </select>
                        </th>
                        <th>

                            <select name="group_name" class="form-select" id="select1">
                                <option selected value="0">Barchasi</option>
                                @foreach($groups as $key=>$group)
                                    <option @if($options->group_name==$group) selected
                                            @endif value="{{$group}}">{{$group}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>

                            <select name="teacher_id" class="form-select" id="select2">
                                <option selected value="0">Barchasi</option>
                                @foreach($teachers as $id=>$teacher)
                                    <option @if($options->teacher_id==$id) selected
                                            @endif value="{{$id}}">{{$teacher}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>

                            <select name="status" class="form-select" id="select3">
                                <option selected value="0">Barchasi</option>
                                <option @if($options->status=="new") selected @endif value="new">Yangi</option>
                                <option @if($options->status=="process") selected @endif value="process">Jarayonda
                                </option>
                                <option @if($options->status=="end") selected @endif value="end">Topshirilgan</option>
                            </select>
                        </th>
                        <th>
                            <button type="submit" class="btn btn-primary "><i class="bx bx-filter-alt"></i>Filtr
                            </button>
                        </th>
                    </tr>
                </table>
            </form>
        </div>

        <div class="card-body border-top border-2 border-primary">

            <table class="table ">
                <tr>
                    <th>#</th>
                    <th>Mavzu</th>
                    <th>Talaba</th>
                    <th>Guruh</th>
                    <th>Semestr</th>
                    <th>O'qtuvchi</th>
                    <th>Holat</th>
                </tr>
                @foreach($themes as $key=>$theme)
                    <!-- Modal batafsil  -->
                    <div class="modal fade" id="batafsilModal{{$theme->id}}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div style="" class="modal-content">
                                <div class="modal-header border-top border-2" style="border-color: #121466">

                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mavzu haqida ma'lumot</h1>


                                    <button type="button" class="btn-close " data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>


                                <div class="modal-body">

                                    <div class="mb-3 border-primary border-top p-2 border-2 card">
                                        <label for="name" class="form-label">Mavzu nomi</label>
                                        <p>{{$theme->name}}</p>
                                    </div>
                                    <div class="mb-3  border-primary border-top p-2 border-2 card">
                                        <label for="description" class="form-label">Izoh</label>
                                        <p>{!! $theme->description!!}</p>
                                    </div>
                                    @if( isset($theme->process->id))
{{--                                        <div class="mb-3  border-primary border-top border p-2 border-2 card">--}}
{{--                                            <label for="description" class="form-label">Jarayon mundarijasi</label>--}}
{{--                                            @if($theme->process->content==null or $theme->process->content=="Hozircha kiritilmagan" )--}}
{{--                                                <p>Hozircha kiritilmagan</p>--}}
{{--                                            @else--}}
{{--                                                <p>{!! $theme->process->content!!}</p>--}}
{{--                                            @endif--}}

{{--                                        </div>--}}
                                        <div class="card mb-3  border-primary border-top border p-2 border-2 ">
                                            <div class="">
                                                <div class="float-start">
                                                    <label for="description" class="form-label">Github link </label>
                                                    @if($theme->process->link==null or $theme->process->link=="Hozircha kiritilmagan" )
                                                        <p>Hozircha kiritilmagan</p>
                                                    @else
                                                        <a href="{{$theme->process->link}}" target="_blank"
                                                           class="btn btn-primary btn-sm m-2"> <i
                                                                    class="bx bx-log-in"></i> Ko'rish </a>
                                                    @endif
                                                </div>
                                                <div class=" float-end ">
                                                    <label for="description" class="form-label">Fayl </label>
                                                    @if($theme->process->file==null or $theme->process->file=="Hozircha kiritilmagan" )
                                                        <p>Hozircha kiritilmagan</p>
                                                    @else
                                                        <a href="{{asset($theme->process->file)}}"
                                                           class="btn btn-primary btn-sm m-2"><i
                                                                    class="bx bx-download"></i> Yuklab olish</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                    <tr>

                        <td>{{$loop->index+1}}</td>
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#batafsilModal{{$theme->id}}" type="button"
                                    class="btn btn-outline-dark">Batafsil
                            </button>
                        </td>


                        <td>{{$theme->student_name}}
                            @if($theme->student_name == null)
                                Tanlamagan
                            @endif
                        </td>
                        <td>{{$theme->group_name}}</td>
                        <td>{{$theme->semester}}</td>

                        <td>{{$theme->teacher->name}}</td>
                        <td>
                            @if($theme->status == 'new')
                                <span class="badge bg-primary">Yangi</span>
                            @elseif($theme->status == 'process')
                                <span class="badge bg-warning">Jarayonda</span>
                            @else
                                <span class="badge bg-success">Topshirilgan</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="mt-3">
                {{ $themes->appends([
                    'semester' => $options->semester,
                    'group_name' => $options->group_name,
                    'teacher_id'=> $options->teacher_id,
                    'status' => $options->status,
                    ])->links() }}

            </div>
        </div>
    </div>
@endsection
