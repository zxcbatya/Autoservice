@extends('layouts.admin')
@section('title', 'Зарплаты')
@section('content_header', 'Зарплаты мастеров')
@section('content')
@include('admin.sto._alerts')
<div class="row mb-3">
@foreach($workers as $item)
@php $worker = $item['model']; $debt = $item['debt']; @endphp
<div class="col-md-3 col-sm-6">
<div class="small-box {{ $debt > 0 ? 'bg-warning' : 'bg-success' }}">
<div class="inner"><h3>{{ number_format($debt, 2) }} ₽</h3><p>{{ $worker->name }}</p></div>
@if($debt > 0)
<form action="{{ route('admin.sto.payments.pay-all', $worker) }}" method="post" class="small-box-footer">@csrf
<button type="submit" class="btn btn-link text-white p-0 border-0">Выплатить всё</button>
</form>
@else
<span class="small-box-footer">Нет долга</span>
@endif
</div></div>
@endforeach
</div>
<div class="card mb-3">
<div class="card-header"><h3 class="card-title">К выплате</h3></div>
<div class="card-body table-responsive p-0">
<table class="table table-hover"><thead><tr><th>Мастер</th><th>Заказ</th><th>Сумма</th><th></th></tr></thead>
<tbody>@forelse($pending as $payment)<tr>
<td>{{ $payment->worker?->name }}</td>
<td>{{ $payment->order?->number ?? '—' }}</td>
<td>{{ number_format((float)$payment->amount, 2) }} ₽</td>
<td><form action="{{ route('admin.sto.payments.pay-one', $payment) }}" method="post">@csrf<button class="btn btn-success btn-xs">Выплатить</button></form></td>
</tr>@empty<tr><td colspan="4" class="text-center">Нет ожидающих выплат</td></tr>@endforelse</tbody></table>
</div></div>
<div class="card">
<div class="card-header"><h3 class="card-title">История выплат</h3></div>
<div class="card-body table-responsive p-0">
<table class="table table-striped"><thead><tr><th>Дата</th><th>Мастер</th><th>Заказ</th><th>Сумма</th></tr></thead>
<tbody>@forelse($history as $payment)<tr>
<td>{{ $payment->paid_at?->format('d.m.Y') }}</td>
<td>{{ $payment->worker?->name }}</td>
<td>{{ $payment->order?->number ?? '—' }}</td>
<td>{{ number_format((float)$payment->amount, 2) }} ₽</td>
</tr>@empty<tr><td colspan="4" class="text-center">История пуста</td></tr>@endforelse</tbody></table>
</div></div>
@endsection
