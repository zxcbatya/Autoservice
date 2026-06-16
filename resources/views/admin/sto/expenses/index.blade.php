@extends('layouts.admin')
@section('title', 'Расходы')
@section('content_header', 'Расходы')
@section('content')
@include('admin.sto._alerts')
<div class="row">
<div class="col-md-4">
<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Добавить расход</h3></div>
<form action="{{ route('admin.sto.expenses.store') }}" method="post">@csrf
<div class="card-body">
<div class="form-group"><label>Дата</label><input type="date" name="expense_date" value="{{ date('Y-m-d') }}" class="form-control" required></div>
<div class="form-group"><label>Категория</label>
<select name="category" class="form-control" required>
@foreach($categories as $key => $label)<option value="{{ $key }}">{{ $label }}</option>@endforeach
</select></div>
<div class="form-group"><label>Описание</label><textarea name="description" class="form-control" rows="2" required></textarea></div>
<div class="form-group"><label>Сумма</label><input type="number" step="0.01" min="0" name="amount" class="form-control" required></div>
</div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Сохранить</button></div>
</form></div></div>
<div class="col-md-8"><div class="card"><div class="card-body table-responsive p-0">
<table class="table table-striped"><thead><tr><th>Дата</th><th>Категория</th><th>Описание</th><th>Сумма</th><th></th></tr></thead>
<tbody>@forelse($expenses as $expense)<tr>
<td>{{ $expense->expense_date->format('d.m.Y') }}</td>
<td>{{ $categories[$expense->category] ?? $expense->category }}</td>
<td>{{ $expense->description }}</td>
<td>{{ number_format((float)$expense->amount, 2) }} ₽</td>
<td><form action="{{ route('admin.sto.expenses.destroy', $expense) }}" method="post" onsubmit="return confirm('Удалить?')">@csrf @method('DELETE')<button class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button></form></td>
</tr>@empty<tr><td colspan="5" class="text-center">Нет расходов</td></tr>@endforelse</tbody></table>
</div></div></div></div>
@endsection
