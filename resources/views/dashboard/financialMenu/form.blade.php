@csrf
<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_{{ $locale }}" class="font-weight-bold">{{ __("keys.name_$locale") }}</label>
                <input type="text" name="{{ $locale }}[name]" id="name_{{ $locale }}"
                       class="form-control @error("$locale.name") is-invalid @enderror"
                       value="{{ old("$locale.name", $financial_menu->translate($locale)->name ?? '') }}" required>
                @error("$locale.name")
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    @endforeach
</div>



<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="year" class="font-weight-bold">{{ __('keys.year') }}</label>
            <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror"
                   value="{{ old('year', $financial_menu->year ?? '') }}" required>
            @error('year')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    </div>

    {{-- Active Switch --}}
    <div class="col-md-6 d-flex align-items-center">
        <p class="mb-0 mr-3 font-weight-bold">{{ __('keys.is_active') }}</p>
        <div class="custom-control custom-switch">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" class="custom-control-input" id="customSwitch1" name="is_active" value="1"
                {{ old('is_active', $financial_menu->is_active ?? false) ? 'checked' : '' }}>
            <label class="custom-control-label" for="customSwitch1">{{ __('keys.yes') }}</label>
        </div>
    </div>


</div>


<div class="row">
    {{-- Image Column --}}
    <div class="col-md-6">
        <div class="form-group">
            @if (isset($financial_menu) && $financial_menu->getMedia('financial_icon')->count() > 0)
                <div class="mb-2">
                    <img src="{{ $financial_menu->getFirstMediaUrl('financial_icon') }}"
                         alt="Financial Menu Image" class="img-thumbnail" width="100" style="height: 70px">
                </div>
            @endif
            <div class="custom-file">
                <input type="file" name="icon" class="custom-file-input @error('icon') is-invalid @enderror"
                       id="validatedCustomFile" accept="image/*" onchange="previewImage(event)">
                <label class="custom-file-label" for="validatedCustomFile">{{ __('keys.choose_image') }}</label>
                @error('icon')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    {{-- PDF Column --}}
    <div class="col-md-6">
        <div class="form-group">
            @if (isset($financial_menu) && $financial_menu->id && $financial_menu->getMedia('financial_file')->count() > 0)
                <div class="mb-2">
                    <a href="{{ $financial_menu->getFirstMediaUrl('financial_file') }}"
                       class="btn btn-outline-primary btn-sm" target="_blank" download>
                        📥 {{ __('keys.download_file') }}
                    </a>
                </div>
            <br><br>
            @endif
            <div class="custom-file">
                <input type="file" name="file" class="custom-file-input @error('file') is-invalid @enderror"
                       id="customFileUpload" accept="application/pdf">
                <label class="custom-file-label" for="customFileUpload">{{ __('keys.choose_file') }}</label>
                @error('file')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="image-preview" id="image-preview"></div>


<div class="text-right">
    <button type="submit" class="btn btn-primary">{{ __('keys.submit') }}</button>
</div>
