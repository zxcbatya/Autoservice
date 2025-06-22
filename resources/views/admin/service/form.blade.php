{{--
    Этот файл — переиспользуемая форма для создания и редактирования услуг.
    Он будет подключаться в create.blade.php и edit.blade.php.

    Для корректной работы формы предполагается, что в контроллере
    при редактировании передается переменная $service.
--}}

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="form-group mb-4">
            <label for="name" class="font-weight-bold">Название услуги</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   id="name" placeholder="Слесарные работы"
                   value="{{ old('name', $service->name ?? '') }}" required>
            @error('name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="price" class="font-weight-bold">Цена</label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror"
                   id="price" placeholder="от 1000 руб."
                   value="{{ old('price', $service->price ?? '') }}" required>
            @error('price')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="description" class="font-weight-bold">Описание</label>
            <textarea name="description" id="description"
                      class="form-control @error('description') is-invalid @enderror"
                      rows="4"
                      placeholder="Краткое описание услуги...">{{ old('description', $service->description ?? '') }}</textarea>
            @error('description')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-4">
            <label for="image" class="font-weight-bold">Изображение (600x400, jpg/png/webp)</label>
            @if(isset($service) && $service->image)
                <div class="mb-2" id="current-image-block">
                    <span class="text-muted small">Текущее изображение:</span><br>
                    <img src="{{ asset('storage/'.$service->image) }}"
                         alt="{{ $service->name }}" class="img-thumbnail mb-2" style="max-width: 300px;">
                </div>
            @endif

            <div class="custom-file">
                <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                       id="image" name="image" accept="image/*"
                       onchange="previewImage(event)">
                <label class="custom-file-label" for="image">Выберите изображение...</label>
            </div>
            @error('image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            <div id="preview-container" class="mt-3" style="display:none;">
                <span class="text-muted small">Предпросмотр:</span><br>
                <img id="preview-image" src="#" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            @if(isset($isEdit) && $isEdit === true)
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-save"></i> Сохранить
                </button>
            @else
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-plus"></i> Добавить
                </button>
            @endif
            <a class="btn btn-secondary ml-2" href="{{ route('admin.service.index') }}">
                <i class="fas fa-times"></i> Отмена
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('preview-container');
        const preview = document.getElementById('preview-image');
        const currentImageBlock = document.getElementById('current-image-block');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
                if(currentImageBlock) currentImageBlock.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.style.display = 'none';
            if(currentImageBlock) currentImageBlock.style.display = '';
        }
    }
</script>
@endpush
