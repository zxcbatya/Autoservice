@extends('layouts.admin')

@section('title', 'Заказы')
@section('content_header', 'Заказы')

@section('buttons')
    <a href="{{ route('admin.sto.orders.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Новый заказ
    </a>
@endsection

@section('content')
    @include('admin.sto._alerts')

    <div class="card mb-3">
        <div class="card-body">
            <form method="get" class="form-inline">
                <label class="mr-2">Статус:</label>
                <select name="status" class="form-control form-control-sm mr-2" onchange="this.form.submit()">
                    <option value="">Все</option>
                    @foreach($statuses as $key => $label)
                        <option value="{{ $key }}" @selected($currentStatus === $key)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Клиент</th>
                    <th>Услуга</th>
                    <th>Сумма</th>
                    <th>Мастера</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->number }}</td>
                        <td>{{ $order->client?->name }}</td>
                        <td>{{ $order->service }}</td>
                        <td>{{ number_format((float) $order->amount, 2, '.', ' ') }} ₽</td>
                        <td class="text-sm">
                            @foreach($order->workers as $ow)
                                <div>{{ $ow->worker?->name }}: {{ number_format((float) $ow->amount, 2) }} ₽</div>
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ route('admin.sto.orders.status', $order) }}" method="post" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                    @foreach($statuses as $key => $label)
                                        <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>{{ $order->created_at->format('d.m.Y') }}</td>
                        <td>
                            <form action="{{ route('admin.sto.orders.destroy', $order) }}" method="post" class="d-inline"
                                  onsubmit="return confirm('Удалить заказ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">Заказов нет</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="card-footer">{{ $orders->links() }}</div>
        @endif
    </div>
@endsection
