@extends('layouts.admin')
@section('title', 'Мастера')
@section('content_header', 'Мастера')
@section('content')
@include('admin.sto._alerts')
<div class="row">
<div class="col-md-4">
<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Добавить мастера</h3></div>
<form action="{{ route('admin.sto.workers.store') }}" method="post">@csrf
<div class="card-body">
<div class="form-group"><label>Имя</label><input name="name" class="form-control" required></div>
<div class="form-group"><label>Телефон</label><input name="phone" class="form-control"></div>
<div class="form-group"><label>Тип оплаты</label><select name="payment_type" class="form-control" required><option value="fixed">Фикс</option><option value="percent">Процент</option></select></div>
<div class="form-group"><label>Ставка</label><input type="number" step="0.01" name="rate" class="form-control" required></div>
<div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" checked id="wa"><label class="form-check-label" for="wa">Активен</label></div>
</div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Сохранить</button></div>
</form></div></div>
<div class="col-md-8"><div class="card"><div class="card-body table-responsive p-0">
<table class="table table-striped"><thead><tr><th>Имя</th><th>Телефон</th><th>Оплата</th><th>Ставка</th><th>Активен</th><th></th></tr></thead>
<tbody>@forelse($workers as $worker)<tr>
<td>{{ $worker->name }}</td><td>{{ $worker->phone }}</td>
<td>{{ $worker->payment_type === 'percent' ? 'Процент' : 'Фикс' }}</td>
<td>{{ number_format((float)$worker->rate, 2) }}</td>
<td>{{ $worker->is_active ? 'Да' : 'Нет' }}</td>
<td><form action="{{ route('admin.sto.workers.destroy', $worker) }}" method="post" onsubmit="return confirm('Удалить?')">@csrf @method('DELETE')<button class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button></form></td>
</tr>@empty<tr><td colspan="6" class="text-center">Нет мастеров</td></tr>@endforelse</tbody></table>
</div></div></div></div>
@endsection
