@extends('layouts.admin')
@section('title', 'Клиенты')
@section('content_header', 'Клиенты')
@section('content')
@include('admin.sto._alerts')
<div class="row">
<div class="col-md-4">
<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Добавить клиента</h3></div>
<form action="{{ route('admin.sto.clients.store') }}" method="post">@csrf
<div class="card-body">
<div class="form-group"><label>Имя</label><input name="name" class="form-control" required></div>
<div class="form-group"><label>Телефон</label><input name="phone" class="form-control"></div>
<div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
</div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Сохранить</button></div>
</form></div></div>
<div class="col-md-8"><div class="card"><div class="card-body table-responsive p-0">
<table class="table table-striped"><thead><tr><th>Имя</th><th>Телефон</th><th>Email</th><th></th></tr></thead>
<tbody>@forelse($clients as $client)<tr>
<td>{{ $client->name }}</td><td>{{ $client->phone }}</td><td>{{ $client->email }}</td>
<td><form action="{{ route('admin.sto.clients.destroy', $client) }}" method="post" onsubmit="return confirm('Удалить?')">@csrf @method('DELETE')<button class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button></form></td>
</tr>@empty<tr><td colspan="4" class="text-center">Нет клиентов</td></tr>@endforelse</tbody></table>
</div></div></div></div>
@endsection
