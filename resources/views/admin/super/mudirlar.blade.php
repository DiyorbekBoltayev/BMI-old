@extends('admin.master')
@section('content')
    <div class="card m-2 p-2" style="box-shadow: 0px 0px 5px 5px rgba(194,215,236,0.63)">
        <div class="card-header d-flex justify-content-between">
            <h1 class="text text-center text-dark">Mudirlar ro'yhati</h1>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bx bx-plus"></i> Qo'shish
            </button>


        </div>
        <div class="card-body">
            <table class="table overflow-auto">
                <tr>
                    <th>#</th>
                    <th>F.I.Sh</th>
                    <th>Email</th>
                    <th>Amallar</th>
                </tr>
                @foreach($users as $teacher)
                    <tr class="align-items-center">
                        <td>{{$loop->index+1}}</td>
                        <td>{{$teacher->name}}</td>
                        <td>{{$teacher->email}}</td>
                        <td class="">
                            <button data-bs-toggle="modal" data-bs-target="#editModal{{$teacher->id}}" type="button"
                                    class="btn btn-warning"><i class="bx bx-pencil"></i></button>
                            <button data-bs-toggle="modal" data-bs-target="#deleteModal{{$teacher->id}}" type="button"
                                    class="btn btn-danger"><i class="bx bx-trash"></i></button>
                        </td>

                    </tr>

                    <!-- Modal edit -->
                    <div class="modal fade" id="editModal{{$teacher->id}}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tahrirlash</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <form action="{{route('update-mudir',$teacher->id)}}" method="post">@csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">F.I.Sh</label>
                                            <input type="text" required name="name" class="form-control" value="{{$teacher->name}}" id="name"
                                                   placeholder="Familya Ism Sharif">
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Kafedra nomi</label>
                                            <input type="text" required name="kafedra_name" class="form-control" value="{{$teacher->kafedra->name?? "nono"}}" id="name"
                                                   placeholder="Nomi">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" required name="email" class="form-control" value="{{$teacher->email}}" id="email"
                                                   placeholder="someone@example.com">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Parol</label>
                                            <input type="password" required name="password" class="form-control" id="password"
                                                   placeholder="Parol kiriting">
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Parol takroriy</label>
                                            <input type="password" required name="password_confirmation" class="form-control" id="password_confirmation"
                                                   placeholder="Parolni takroriy kiriting">
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish
                                        </button>
                                        <button type="submit" class="btn btn-primary">Saqlash</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Modal delete -->
                    <div class="modal fade" id="deleteModal{{$teacher->id}}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">Haqiqatdan ham ushbu o'qituvchini
                                        o'chirib tashlamoqchimisiz ?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <form action="{{route('delete-mudir',$teacher->id)}}" method="post">@csrf
                                    @method('DELETE')

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish
                                        </button>
                                        <button type="submit" class="btn btn-danger">O'chirish</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                @endforeach
            </table>
        </div>
    </div>
    <!-- Button trigger modal -->


    <!-- Modal create -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">O'qituvchi yaratish</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('create-mudir')}}" method="post">@csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">F.I.Sh</label>
                            <input type="text" required name="name" class="form-control" id="name"
                                   placeholder="Familya Ism Sharif">
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Kafedra nomi</label>
                            <input type="text" required name="kafedra_name" class="form-control" id="name"
                                   placeholder="Nomi">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" required name="email" class="form-control" id="email"
                                   placeholder="someone@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Parol</label>
                            <input type="password" required name="password" class="form-control" id="password"
                                   placeholder="Parol kiriting">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Parol takroriy</label>
                            <input type="password" required name="password_confirmation" class="form-control" id="password_confirmation"
                                   placeholder="Parolni takroriy kiriting">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                        <button type="submit" class="btn btn-primary">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
