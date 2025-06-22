@extends("layouts.admin")

@section('title','Управление услугами')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ключевые услуги</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.service.create') }}" class="btn btn-primary">Добавить услугу</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">#ID</th>
                            <th style="width: 15%">Изображение</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th style="width: 10%">Цена</th>
                            <th style="width: 20%">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td>{{$service->id}}}</td>
                                <td>
                                    <img alt="Service Image" class="img-thumbnail" width="150"
                                         src="{{asset('storage/'.$service->image)}}">
                                </td>
                                <td>{{$service->name}}</td>
                                <td class="text-sm">{{$service->description}}</td>
                                <td>{{$service->price}}</td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm"
                                       href="{{route('admin.service.edit', $service->id)}}">
                                        <i class="fas fa-pencil-alt"></i>
                                        Редактировать
                                    </a>
                                    <form action="{{route('admin.service.delete',$service->id)}}" method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Вы уверены, что хотите удалить услугу?')">
                                            <i class="fas fa-trash"></i>
                                            Удалить
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>

@stop
