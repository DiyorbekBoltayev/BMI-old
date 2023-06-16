@extends('admin.master')
@section('content')
    <div class="card m-2 p-2" style="box-shadow: 0px 0px 5px 5px rgba(194,215,236,0.63)">
        <div class="card-header d-flex justify-content-between">
            <h1 class="text text-center text-dark">Jarayonlar</h1>

        </div>
        <div class="card-body">
            <table class="table overflow-auto">
                <tr>
                    <th>Amallar</th>
                    <th>Mavzu</th>
                </tr>
                @foreach($processes as $process)
                    <tr class="align-items-center">
                        <td class="">
                            <button data-bs-toggle="modal" data-bs-target="#batafsilModal{{$process->id}}" type="button" class="btn btn-success" >Batafsil</button>
                            <button data-bs-toggle="modal" data-bs-target="#editModal{{$process->id}}" type="button" class="btn btn-warning" > <i class="bx bx-pencil"></i></button>
                            <button data-bs-toggle="modal" data-bs-target="#deleteModal{{$process->id}}" type="button" class="btn btn-danger" > <i class="bx bx-trash"></i></button>

                        </td>
                        <td>{{$process->theme->name}}</td>
                        <td>{{$process->theme->student_name}}</td>
                        <td>{{$process->theme->group_name}}</td>
                    </tr>
                    <!-- Modal batafsil  -->
                    <div class="modal fade" id="batafsilModal{{$theme->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tanlangan mavzuni o'zgartira olmaysiz, shu mavzuni tanlaysizmi ?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('get-theme',$theme->id)}}" method="get">

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label for="name" class="form-label">Mavzu nomi</label>
                                            <p>{{$theme->name}}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Izoh</label>
                                            <p>{{$theme->description}}</p>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
                                        <button type="submit" class="btn btn-primary">Mavzuni tanlash</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal edit -->
                    <div class="modal fade" id="editModal{{$theme->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mavzuni tahrirlash</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('update-theme')}}" method="post">@csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="{{$theme->id}}">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Yonalish tanlang</label>
                                            <select class="form-select" required name="specialty" aria-label="Default select example">
                                                <option @if($theme->specialty == 5330600) selected @endif value="5330600">DASTURIY INJINIIRNG</option>
                                                <option  @if($theme->specialty == 5330500) selected @endif   value="5330500">KOMPYUTER INJINIRINGI</option>
                                                <option  @if($theme->specialty == 5350100) selected @endif  value="5350100">TELEKOMMUNIKATSIYA TEXNOLOGIYALARI</option>
                                                <option  @if($theme->specialty == 5350400) selected @endif  value="5350400">AKT SOHASIDA KASB TALIMI</option>
                                                <option  @if($theme->specialty == 5330300) selected @endif  value="5330300">AXBOROT XAVFSIZLIGI</option>
                                                <option  @if($theme->specialty == 5350101) selected @endif  value="5350101">TELEKOMMUNIKATSIYA INJINIRINGI</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Qaysi kurs uchun</label>
                                            <select class="form-select" required name="level" aria-label="Default select example">
                                                <option @if($theme->level =='3-kurs') selected @endif value="3-kurs">3-kurs</option>
                                                <option @if($theme->level =='4-kurs') selected @endif value="4-kurs">4-kurs</option>
                                                <option @if($theme->level =='5-kurs') selected @endif value="5-kurs">5-kurs</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Mavzu nomi</label>
                                            <input type="text" value="{{$theme->name}}" required name="name" class="form-control" id="name" placeholder="Mavzu nomini kiriting">
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Izoh</label>
                                            <textarea class="form-control" required name="description" id="description" rows="4" placeholder="Ushbu mavzuda talaba...">{{$theme->description}}</textarea>
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

                    <div class="modal fade" id="deleteModal{{$theme->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">Haqiqatdan ham ushbu mavzuni o'chirib tashlamoqchimisiz ?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('delete-theme')}}" method="post">@csrf

                                    <input type="hidden" name="id" value="{{$theme->id}}">



                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish</button>
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




@endsection
