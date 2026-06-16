@extends('layouts.admin')
@section('title', 'Запчасти')
@section('content_header', 'Склад запчастей')
@section('content')
@include('admin.sto._alerts')
<div class="row">
<div class="col-md-4">
<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Добавить запчасть</h3></div>
<form action="{{ route('admin.sto.parts.store') }}" method="post">@csrf
<div class="card-body">
<div class="form-group"><label>Название</label><input name="name" class="form-control" required></div>
<div class="form-group"><label>Артикул</label><input name="article" class="form-control"></div>
<div class="form-group"><label>Количество</label><input type="number" min="0" name="quantity" class="form-control" required></div>
<div class="form-group"><label>Цена</label><input type="number" step="0.01" min="0" name="price" class="form-control" required></div>
<div class="form-group"><label>Мин. остаток</label><input type="number" min="0" name="min_quantity" class="form-control" required></div>
</div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Сохранить</button></div>
</form></div></div>
<div class="col-md-8"><div class="card"><div class="card-body table-responsive p-0">
<table class="table table-striped"><thead><tr><th>Название</th><th>Артикул</th><th>Кол-во</th><th>Цена</th><th>Мин.</th><th></th></tr></thead>
<tbody>@forelse($parts as $part)<tr class="{{ $part->isLowStock() ? 'table-danger' : '' }}">
<td>{{ $part->name }}</td><td>{{ $part->article }}</td>
<td class="{{ $part->isLowStock() ? 'text-danger font-weight-bold' : '' }}">{{ $part->quantity }}</td>
<td>{{ number_format((float)$part->price, 2) }} ₽</td><td>{{ $part->min_quantity }}</td>
<td><form action="{{ route('admin.sto.parts.destroy', $part) }}" method="post" onsubmit="return confirm('Удалить?')">@csrf @method('DELETE')<button class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button></form></td>
</tr>@empty<tr><td colspan="6" class="text-center">Склад пуст</td></tr>@endforelse</tbody></table>
</div></div></div></div>
@endsection
