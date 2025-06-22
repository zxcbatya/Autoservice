@extends("layouts.admin")

@section('title','Редактирование отзыва')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактирование отзыва #{{$review->id}}</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.review.update', $review)}}" method="POST">
                        @csrf
                        @method("PATCH")
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $review->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="car">Авто</label>
                            <input type="text" class="form-control" id="car" name="car" value="{{ $review->car }}">
                        </div>
                        <div class="form-group">
                            <label for="rating">Рейтинг</label>
                            <select class="form-control" id="rating" name="rating" required>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{$i}}" @if($i == $review->rating) selected @endif>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message">Текст отзыва</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required>{{ $review->message }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="{{ route('admin.review.index') }}" class="btn btn-secondary">Отмена</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop 