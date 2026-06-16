@extends('layouts.admin')
@section('title', 'Отчёты')
@section('content_header', 'Отчёты')
@section('content')
<div class="card mb-3">
<div class="card-body">
<form method="get" class="form-inline">
<label class="mr-2">С</label>
<input type="date" name="date_from" value="{{ request('date_from', $date_from) }}" class="form-control mr-3">
<label class="mr-2">По</label>
<input type="date" name="date_to" value="{{ request('date_to', $date_to) }}" class="form-control mr-3">
<button type="submit" class="btn btn-primary">Применить</button>
</form></div></div>
<div class="row">
<div class="col-lg-3 col-6"><div class="small-box bg-info"><div class="inner"><h3>{{ number_format($revenue, 0, '.', ' ') }} ₽</h3><p>Выручка</p></div></div></div>
<div class="col-lg-3 col-6"><div class="small-box bg-danger"><div class="inner"><h3>{{ number_format($expenses, 0, '.', ' ') }} ₽</h3><p>Расходы</p></div></div></div>
<div class="col-lg-3 col-6"><div class="small-box bg-warning"><div class="inner"><h3>{{ number_format($salaries, 0, '.', ' ') }} ₽</h3><p>Зарплаты</p></div></div></div>
<div class="col-lg-3 col-6"><div class="small-box bg-success"><div class="inner"><h3>{{ number_format($profit, 0, '.', ' ') }} ₽</h3><p>Чистая прибыль</p></div></div></div>
</div>
<div class="row"><div class="col-12"><div class="info-box"><span class="info-box-icon bg-primary"><i class="fas fa-clipboard-list"></i></span>
<div class="info-box-content"><span class="info-box-text">Заказов за период</span><span class="info-box-number">{{ $orders_count }}</span></div></div></div></div>
<div class="card"><div class="card-header"><h3 class="card-title">Завершённые заказы за период</h3></div>
<div class="card-body table-responsive p-0">
<table class="table table-striped"><thead><tr><th>№</th><th>Клиент</th><th>Услуга</th><th>Сумма</th><th>Дата</th></tr></thead>
<tbody>@forelse($orders as $order)<tr>
<td>{{ $order->number }}</td><td>{{ $order->client?->name }}</td><td>{{ $order->service }}</td>
<td>{{ number_format((float)$order->amount, 2) }} ₽</td><td>{{ $order->created_at->format('d.m.Y') }}</td>
</tr>@empty<tr><td colspan="5" class="text-center">Нет данных</td></tr>@endforelse</tbody></table>
</div></div>
@endsection
