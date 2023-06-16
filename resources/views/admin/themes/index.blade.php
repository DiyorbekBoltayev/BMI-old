@extends('admin.master')
@section('content')
    <div class="card m-2 p-2" style="box-shadow: 0px 0px 5px 5px rgba(194,215,236,0.63)">

        <div class="card-header  ">


            <form action="{{route('filtered-teacher-themes')}}" style="margin-right: -30px; margin-top: -20px;" method="get"
                  class="form-group  float-end ">


                <table class="text-center">

                    <tr>
                        <th>
                            <label for="select0">Semestr</label>
                        </th>
                        <th>
                            <label for="select1">Yo'nalish</label>
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
                    <th class="w-25">
                        <select class="form-select" required name="specialty"
                                aria-label="Yo'nalishlar" >
                            <option @if($options->specialty == 5330600) selected
                                    @endif value="5330600">DASTURIY INJINIIRNG
                            </option>
                            <option @if($options->specialty == 5330500) selected
                                    @endif   value="5330500">KOMPYUTER INJINIRINGI
                            </option>
                            <option @if($options->specialty == 5350100) selected
                                    @endif  value="5350100">TELEKOMMUNIKATSIYA TEXNOLOGIYALARI
                            </option>
                            <option @if($options->specialty == 5350400) selected
                                    @endif  value="5350400">AKT SOHASIDA KASB TALIMI
                            </option>
                            <option @if($options->specialty == 5330300) selected
                                    @endif  value="5330300">AXBOROT XAVFSIZLIGI
                            </option>
                            <option @if($options->specialty == 5350101) selected
                                    @endif  value="5350101">TELEKOMMUNIKATSIYA INJINIRINGI
                            </option>
                        </select>
                    </th>
                    <th>

                        <select name="status" class="form-select" id="select3" >
                            <option selected value="0">Barchasi</option>
                            <option @if($options->status=="new") selected @endif value="new">Yangi</option>
                            <option @if($options->status=="process") selected @endif value="process">Jarayonda
                            </option>
                            <option @if($options->status=="end") selected @endif value="end">Topshirilgan</option>
                        </select>
                    </th>
                        <th class="btn-group">
                            <button type="submit" class="btn btn-primary "><i class="bx bx-filter-alt"></i>Filtr
                            </button>
                            @if(auth()->check())
                                <button type="button" class="btn btn-success float-end " data-bs-toggle="modal" data-bs-target="#createModal">
                                    <i class="bx bx-plus"></i> Qo'shish
                                </button>
                            @endif
                        </th>
                    </tr>
                </table>
            </form>
            <h1 class="text float-start">Mavzular ro'yhati</h1>

        </div>
        <div class="card-body">
            <table class="table overflow-auto">
                <tr>
                    <th>Amallar</th>
                    <th>Mavzu</th>
                </tr>
                @foreach($themes as $theme)
                    <tr class="align-items-center">
                        <td class="">
                            <table>
                                <tr>
                                    <td>
                            <button data-bs-toggle="modal" data-bs-target="#batafsilModal{{$theme->id}}" type="button"
                                    class="btn btn-outline-dark">Batafsil
                            </button>
                                    </td>
                                @if($theme->student_id == 0)
                                    <td>
                                    <button data-bs-toggle="modal" data-bs-target="#editModal{{$theme->id}}" type="button"
                                            class="btn btn-warning"><i class="bx bx-pencil"></i></button>
                                    </td>
                                    <td>
                                    <button data-bs-toggle="modal" data-bs-target="#deleteModal{{$theme->id}}" type="button"
                                            class="btn btn-danger"><i class="bx bx-trash"></i></button>
                                    </td>
                                @else
                                    <td>
                                @if($theme->status=="end")
                                    <a href="{{route('show-process',$theme->process->id)}}" style="height: 40px;" class="btn btn-success d-flex">Topshirilgan</a>
                                @else
                                    <a href="{{route('show-process',$theme->process->id)}}" style="height: 40px;" class="btn btn-outline-info d-flex"> <i class="bx bx-list-check"></i> Jarayonda</a>
                                @endif
                                    </td>
                                    <td>
                                    <a href="{{route('chat',$theme->chat->id)}}" style="height: 40px;" class="btn btn-outline-primary d-flex"> <i class="bx bx-chat"></i> Chat @if($theme->chat->teacherUnreadMessagesCount() >0) <span style="border-radius: 50%;" class="badge bg-danger">{{$theme->chat->teacherUnreadMessagesCount()}}</span> @endif</a>
                                    </td>
                                    @if($theme->percentage=='-1')
                                        <td>
                                            <button data-bs-toggle="modal" data-bs-target="#confirmCancelModal{{$theme->id}}" type="button"
                                                    class="btn btn-outline-danger" style="height: 40px;"> So'rov
                                            </button>
                                  </td>
                                    @endif
                            @endif
                                </tr>
                            </table>
                        </td>

                        <td>{{$theme->name}}</td>
                    </tr>
                    <!-- Modal batafsil  -->
                    <div  class="modal fade" id="batafsilModal{{$theme->id}}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div style="" class="modal-content">
                                <div class="modal-header border-top border-2" style="border-color: darkblue" >

                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Mavzu haqida ma'lumot</h1>



                                    <button type="button" class="btn-close "  data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <form action="{{route('get-theme',$theme->id)}}" method="get">

                                    <div class="modal-body">

                                        <div class="card mb-3  border-primary border-top border p-2 border-2 " >
                                            <label for="name" class="form-label">Mavzu nomi</label>
                                            <p>{{$theme->name}}</p>
                                        </div>
                                        <div class="card mb-3  border-primary border-top border p-2 border-2 " >
                                            <label for="description" class="form-label">Izoh</label>
                                            <p>{!! $theme->description!!}</p>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yopish
                                        </button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @if($theme->percentage=='-1')
                    <!-- Modal confirmCancel  -->
                    <div  class="modal fade" id="confirmCancelModal{{$theme->id}}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div style="" class="modal-content">
                                <div class="modal-header border-top border-2" style="border-color: darkblue" >

                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Mavzuni bekor qilish uchun talaba so'rov yuborgan</h1>



                                    <button type="button" class="btn-close "  data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <form action="{{route('cancel-confirm',$theme->id)}}" method="get">

                                    <div class="modal-body">

                                        <div class="card mb-3  border-primary border-top border p-2 border-2 " >
                                            <label for="name" class="form-label">Talaba so'rovini qabul qilasizmi?</label>
                                            <select name="confirm" class="form-select" aria-label="Default select example">
                                                <option value="1">Ha</option>
                                                <option value="0">Yo'q</option>
                                            </select>
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
                    @endif
                    <!-- Modal edit -->
                    <div class="modal fade" id="editModal{{$theme->id}}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mavzuni tahrirlash</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <form action="{{route('update-theme')}}" method="post">@csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="{{$theme->id}}">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Yonalish tanlang</label>
                                            <select class="form-select" required name="specialty"
                                                    aria-label="Default select example">
                                                <option @if($theme->specialty == 5330600) selected
                                                        @endif value="5330600">DASTURIY INJINIIRNG
                                                </option>
                                                <option @if($theme->specialty == 5330500) selected
                                                        @endif   value="5330500">KOMPYUTER INJINIRINGI
                                                </option>
                                                <option @if($theme->specialty == 5350100) selected
                                                        @endif  value="5350100">TELEKOMMUNIKATSIYA TEXNOLOGIYALARI
                                                </option>
                                                <option @if($theme->specialty == 5350400) selected
                                                        @endif  value="5350400">AKT SOHASIDA KASB TALIMI
                                                </option>
                                                <option @if($theme->specialty == 5330300) selected
                                                        @endif  value="5330300">AXBOROT XAVFSIZLIGI
                                                </option>
                                                <option @if($theme->specialty == 5350101) selected
                                                        @endif  value="5350101">TELEKOMMUNIKATSIYA INJINIRINGI
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Qaysi kurs uchun</label>
                                            <select class="form-select"  required name="level"
                                                    aria-label="Default select example">
                                                <option @if($theme->level =='3-kurs') selected @endif value="3-kurs">
                                                    3-kurs
                                                </option>
                                                <option @if($theme->level =='4-kurs') selected @endif value="4-kurs">
                                                    4-kurs
                                                </option>
                                                <option @if($theme->level =='5-kurs') selected @endif value="5-kurs">
                                                    5-kurs
                                                </option>
                                                <option @if($theme->level =='1-kurs') selected @endif value="1-kurs">
                                                    1-kurs magistr
                                                </option><option @if($theme->level =='2-kurs') selected @endif value="2-kurs">
                                                    2-kurs magistr
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Qaysi semestr uchun</label>
                                            <select class="form-select"  required name="semester" aria-label="Default select example">
                                                <option @if($theme->semester =='5-semetr') selected @endif value="5-semestr">5-semestr</option>
                                                <option @if($theme->semester =='6-semetr') selected @endif  value="6-semestr">6-semestr</option>
                                                <option @if($theme->semester =='7-semetr') selected @endif  value="7-semestr">7-semestr</option>
                                                <option @if($theme->semester =='8-semetr') selected @endif  value="8-semestr">8-semestr</option>
                                                <option @if($theme->semester =='9-semetr') selected @endif  value="9-semestr">9-semestr</option>
                                                <option @if($theme->semester =='10-semetr') selected @endif  value="10-semestr">10-semestr</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Mavzu nomi</label>
                                            <input type="text" value="{{$theme->name}}" required name="name"
                                                   class="form-control" id="name" placeholder="Mavzu nomini kiriting">
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Izoh</label>
                                            <textarea class="form-control" required name="description" id="description"
                                                      rows="4"
                                                      placeholder="Ushbu mavzuda talaba...">{{$theme->description}}</textarea>
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
                    <div class="modal fade" id="deleteModal{{$theme->id}}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-3" id="exampleModalLabel">Haqiqatdan ham ushbu mavzuni
                                        o'chirib tashlamoqchimisiz ?</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <form action="{{route('delete-theme')}}" method="post">@csrf

                                    <input type="hidden" name="id" value="{{$theme->id}}">


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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mavzu yaratish</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('store-theme')}}" method="post">@csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Yonalish tanlang</label>
                            <select class="form-select" required name="specialty" aria-label="Default select example">
                                <option value="5330600">DASTURIY INJINIIRNG</option>
                                <option value="5330500">KOMPYUTER INJINIRINGI</option>
                                <option value="5350100">TELEKOMMUNIKATSIYA TEXNOLOGIYALARI</option>
                                <option value="5350400">AKT SOHASIDA KASB TALIMI</option>
                                <option value="5330300">AXBOROT XAVFSIZLIGI</option>
                                <option value="5350101">TELEKOMMUNIKATSIYA INJINIRINGI</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Qaysi kurs uchun</label>
                            <select class="form-select" required name="level" id="kurs_select" aria-label="Default select example">
                                <option selected value="4-kurs">4-kurs</option>
                                <option value="3-kurs">3-kurs</option>
                                <option value="5-kurs">5-kurs</option>
                                <option value="1-kurs">1-kurs magistr</option>
                                <option value="2-kurs">2-kurs magistr</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Qaysi semestr uchun</label>
                            <select class="form-select" required name="semester" id="kurs_semester" aria-label="Default select example">
                                <option selected value="8-semestr">8-semestr</option>
                                <option value="7-semestr">7-semestr</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Mavzu nomi</label>
                            <input type="text" required name="name" class="form-control" id="name"
                                   placeholder="Mavzu nomini kiriting">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Izoh</label>
                            <textarea class="form-control" required name="description" id="description" rows="4"
                                      placeholder="Ushbu mavzuda talaba..."> </textarea>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var kursSelect = document.querySelector('#kurs_select');
            var kursSemester = document.querySelector('#kurs_semester');
            var kursSelectUpdate = document.querySelector('#kurs_select_update');
            var kursSemesterUpdate = document.querySelector('#kurs_semester_update');

            kursSelect.addEventListener('change', function() {
                if (this.value === '3-kurs') {

                    kursSemester.innerHTML = '<option selected value="5-semestr">5-semestr</option>' +
                        '<option value="6-semestr">6-semestr</option>';
                } else if (this.value === '4-kurs') {
                    kursSemester.innerHTML = '<option selected value="7-semestr">7-semestr</option>' +
                        '<option value="8-semestr">8-semestr</option>';
                }else if (this.value === '5-kurs') {
                    kursSemester.innerHTML = '<option selected value="9-semestr">9-semestr</option>' +
                        '<option value="10-semestr">10-semestr</option>';
                }else if (this.value === '1-kurs') {
                    kursSemester.innerHTML = '<option selected value="1-semestr">1-semestr</option>' +
                        '<option value="2-semestr">2-semestr</option>';
                }else if (this.value === '2-kurs') {
                    kursSemester.innerHTML = '<option selected value="3-semestr">3-semestr</option>' +
                        '<option value="4-semestr">4-semestr</option>';
                }
            });
            kursSelectUpdate.addEventListener('change', function() {
                if (this.value === '3-kurs') {
                    kursSemesterUpdate.innerHTML = '<option selected value="5-semestr">5-semestr</option>' +
                        '<option value="6-semestr">6-semestr</option>';
                } else if (this.value === '4-kurs') {
                    kursSemesterUpdate.innerHTML = '<option selected value="7-semestr">7-semestr</option>' +
                        '<option value="8-semestr">8-semestr</option>';
                }else if (this.value === '5-kurs') {
                    kursSemesterUpdate.innerHTML = '<option selected value="9-semestr">9-semestr</option>' +
                        '<option value="10-semestr">10-semestr</option>';
                }else if (this.value === '1-kurs') {
                    kursSemesterUpdate.innerHTML = '<option selected value="1-semestr">1-semestr</option>' +
                        '<option value="2-semestr">2-semestr</option>';
                }else if (this.value === '2-kurs') {
                    kursSemesterUpdate.innerHTML = '<option selected value="3-semestr">3-semestr</option>' +
                        '<option value="4-semestr">4-semestr</option>';
                }
            });
        });

    </script>

@endsection