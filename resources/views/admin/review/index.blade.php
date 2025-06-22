@extends("layouts.admin")

@section('title','Управление отзывами')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Отзывы клиентов</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">#ID</th>
                            <th>Имя</th>
                            <th>Авто</th>
                            <th>Рейтинг</th>
                            <th style="width: 40%">Текст отзыва</th>
                            <th style="width: 10%">Дата</th>
                            <th style="width: 20%">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reviews as $review)
                            <tr>
                                <td>{{$review->id}}</td>
                                <td>{{$review->name}}</td>
                                <td>{{$review->car ?? 'N/A'}}</td>
                                <td>{{$review->rating}} ★</td>
                                <td class="text-sm">{{$review->message}}</td>
                                <td>{{$review->created_at->format('d.m.Y')}}</td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm"
                                       href="{{route('admin.review.edit', $review)}}">
                                        <i class="fas fa-pencil-alt"></i>
                                        Редактировать
                                    </a>
                                    <form action="{{route('admin.review.destroy', $review)}}" method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Вы уверены, что хотите удалить отзыв?')">
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
            {{ $reviews->links() }}
        </div>
    </section>
@stop 