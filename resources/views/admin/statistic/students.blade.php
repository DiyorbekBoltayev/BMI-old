@extends('admin.master')
@section('content')
    <div class="card">
        <div class="">
            <form action="{{route('statistics-student')}}" method="get"
                  class="form-group d-flex justify-content-between align-items-center m-3">
                <h1 class="text text-center">Talabalar ro'yhati</h1>

                <table class="text-center m-2">
                    <tr>
                        <th>
                            <label for="select1">Guruh</label>
                        </th>
                        <th>
                            <label for="select0">Semestr</label>
                        </th>

                        <th>
                            <label for="select2">Tartib</label>
                        </th>
                        <th>
                            <label for="select4">Amal</label>
                        </th>
                    </tr>
                    <tr>
                        <th>

                            <select name="group" class="form-select" id="select1">
                                @foreach($groups as $group)
                                    <option @if($options->group==$group) selected
                                            @endif value="{{$group}}">{{$group}}</option>
                                @endforeach
                            </select>
                        </th>
                        <th>

                            <select name="semester" class="form-select" id="select0">
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
                            </select>
                        </th>
                        <th>

                            <select name="sort" class="form-select" id="select0">
                                <option @if($options->sort=='DESC') selected @endif value="DESC">
                                    Kamayish
                                </option>
                                <option @if($options->sort=='ASC') selected @endif value="ASC">
                                    O'sish
                                </option>
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

        <div class="card-body border-top border-2 border-primary overflow-auto">

            <table class="table ">
                <tr>
                    <th>#</th>
                    <th>Talaba</th>
                    <th>Bajarilgan</th>
                    <th>O'qituvchi</th>
                    <th>Holat</th>
                </tr>
                @foreach($students as $student)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$student->student_name}}</td>
                        <td>{{$student->percentage}}%</td>
                        <td>{{$student->teacher->name}}</td>
                        @if($student->status=='end') <td><span class="bg-success badge">Topshirilgan</span></td>
                        @else
                            <td><span class="bg-warning badge">Jarayonda</span></td>
                        @endif
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection

