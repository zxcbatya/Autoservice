@extends('layouts.admin')

@section('title', 'Новый заказ')
@section('content_header', 'Создание заказа')

@section('content')
    @include('admin.sto._alerts')

    <div class="card">
        <form action="{{ route('admin.sto.orders.store') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Клиент</label>
                        <select name="client_id" class="form-control @error('client_id') is-invalid @enderror" required>
                            <option value="">Выберите клиента</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->name }}</option>
                            @endforeach
                        </select>
                        @error('client_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Статус</label>
                        <select name="status" class="form-control" required>
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" @selected(old('status', 'new') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Услуга</label>
                    <input type="text" name="service" class="form-control @error('service') is-invalid @enderror" value="{{ old('service') }}" required>
                    @error('service')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label>Сумма заказа, ₽</label>
                    <input type="number" step="0.01" min="0" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', 0) }}" required>
                    @error('amount')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <h5 class="mt-4">Мастера</h5>
                <div id="workers-list">
                    <div class="row worker-row mb-2">
                        <div class="col-md-6">
                            <select name="workers[0][worker_id]" class="form-control">
                                <option value="">— не выбран —</option>
                                @foreach($workers as $worker)
                                    <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" step="0.01" min="0" name="workers[0][amount]" class="form-control" placeholder="Сумма мастеру">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary btn-sm" id="add-worker">+ Добавить мастера</button>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Сохранить</button>
                <a href="{{ route('admin.sto.orders.index') }}" class="btn btn-default">Отмена</a>
            </div>
        </form>
    </div>
@endsection

@push('js')
<script>
(function () {
    let index = 1;
    const workersOptions = @json($workers->map(fn ($w) => ['id' => $w->id, 'name' => $w->name]));
    document.getElementById('add-worker').addEventListener('click', function () {
        const row = document.createElement('div');
        row.className = 'row worker-row mb-2';
        let options = '<option value="">— не выбран —</option>';
        workersOptions.forEach(function (w) {
            options += '<option value="' + w.id + '">' + w.name + '</option>';
        });
        row.innerHTML = '<div class="col-md-6"><select name="workers[' + index + '][worker_id]" class="form-control">' + options + '</select></div>' +
            '<div class="col-md-4"><input type="number" step="0.01" min="0" name="workers[' + index + '][amount]" class="form-control" placeholder="Сумма мастеру"></div>';
        document.getElementById('workers-list').appendChild(row);
        index++;
    });
})();
</script>
@endpush