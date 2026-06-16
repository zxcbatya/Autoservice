@extends("layouts.admin")

@section('title','Дэшборд')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['services'] }}</h3>
                    <p>Количество услуг</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.service.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['reviews'] }}</h3>
                    <p>Количество отзывов</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('admin.review.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['users'] }}</h3>
                    <p>Пользователи</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('backend.user.index') }}" class="small-box-footer">Подробнее <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['views'] }}</h3>
                    <p>Просмотры сайта</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">&nbsp;</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Последние отзывы</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Оценка</th>
                            <th>Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($latestReviews as $review)
                            <tr>
                                <td>{{ $review->id }}</td>
                                <td>{{ $review->name }}</td>
                                <td>{{ $review->rating }} ★</td>
                                <td>{{ $review->created_at->format('d.m.Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Отзывов пока нет</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Здоровье сайта</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Услуги без описания
                            <span class="badge {{ $siteHealth['services_no_description'] > 0 ? 'badge-danger' : 'badge-success' }}">{{ $siteHealth['services_no_description'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Страницы без контента
                            <span class="badge {{ $siteHealth['pages_no_content'] > 0 ? 'badge-danger' : 'badge-success' }}">{{ $siteHealth['pages_no_content'] }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Наличие robots.txt
                            @if($siteHealth['robots_exists'])
                                <span class="badge badge-success">Есть</span>
                            @else
                                <span class="badge badge-danger">Отсутствует</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
