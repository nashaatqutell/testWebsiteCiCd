<!-- resources/views/dashboard/partials/contact-social-fields.blade.php -->
<h2 class="section-header">{{ __("keys.contact_social_data") }}</h2>
<div class="row">
    @foreach ($fields as $name => $type)
        <div class="col-md-6">
            <div class="form-group">
                <label for="{{ $name }}" class="font-weight-bold">{{ __("keys.$name") }}</label>
                <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
                       class="form-control @error($name) is-invalid @enderror"
                       value="{{ old($name, $setting->$name ?? '') }}">
                @error($name)
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach (config('translatable.locales') as $locale)
        <div class="col-md-6">
            <div class="form-group">
                <label for="address_{{ $locale }}"
                       class="font-weight-bold">{{ __("keys.address_$locale") }}</label>
                <textarea name="{{ $locale }}[address]" id="address_{{ $locale }}"
                          class="form-control summernote @error("$locale.address") is-invalid @enderror"
                          rows="3"
                >{{ old("$locale.address", $setting ? $setting->translate($locale)->address : '') }}</textarea>
                @error("$locale.address")
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    @endforeach
</div>

