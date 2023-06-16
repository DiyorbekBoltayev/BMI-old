@extends('admin.master')
@section('content')
    <div class="card m-3 p-2" style="box-shadow: 0px 0px 5px 5px rgba(227,227,244,0.79)">
        <h1 class="text text-center text-dark">Foydalanuvchi haqida ma'lumot</h1>

            <div class="card-body " >
                <div class="row">
                    <div class="col-10 p-2" style="box-shadow: 0px 0px 5px 5px rgba(227,227,244,0.79)">
                        <h4 class="text text-dark">F.I.Sh : {{session('hemisaboutme')->second_name}} {{session('hemisaboutme')->first_name}} {{session('hemisaboutme')->third_name}}</h4>
                        <h4 class="text text-dark">Guruh : {{session('hemisaboutme')->group->name}}</h4>
                        <h4 class="text text-dark">Kurs : {{session('hemisaboutme')->level->name}}</h4>
                        <h4 class="text text-dark">Semester : {{session('hemisaboutme')->semester->name}}</h4>
                        <h4 class="text text-dark">Davomi bor ...</h4>

                    </div>
                </div>
            </div>

    </div>
@endsection