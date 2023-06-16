@extends('admin.master')
@section('content')
    <div class="card m-3 p-2" style="box-shadow: 0px 0px 5px 5px rgba(227,227,244,0.79)">

        <div class="card-body " >
            <div class="row">
                <h2 class="text text-dark text-center">Profil sozlamalari</h2>

            </div>
            <div class="row">
                <form action="{{route('update-profile',$user)}}" method="post">@csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Ism</label>
                        <input type="text" value="{{$user->name}}" required name="name"
                               class="form-control" id="name" >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" value="{{$user->email}}" required name="email"
                               class="form-control" id="email" >
                    </div>
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                </form>
                    <hr class="m-2" style="color: darkblue">
                    <h3 class="text text-dark text-center">Parolni o'zgartirish</h3>
                <form action="{{route('update-password',$user)}}" method="post">@csrf
                    <div class="mb-3">
                        <label for="password" class="form-label">Parol</label>
                        <input type="password" value="" required name="password"
                               class="form-control" id="password" >
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Parolni tasdiqlash</label>
                        <input type="password" value="" required name="password_confirmation"
                               class="form-control" id="password_confirmation" >
                    </div>
                    <button type="submit" class="btn btn-primary">Saqlash</button>
                </form>
            </div>
        </div>

    </div>
@endsection