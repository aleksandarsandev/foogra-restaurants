@extends('layouts.admin')

@section('title', 'Site Settings - Foogra Admin')

@section('breadcrumb')
<li class="breadcrumb-item active">Site Settings</li>
@endsection

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fa fa-cog"></i> Site Settings
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @foreach($definitions as $key => $def)
            @php $current = $settings[$key] ?? null; @endphp

            @if($def['type'] === 'text')
            <div class="form-group row mb-4 pb-4 border-bottom">
                <label class="col-md-3 col-form-label font-weight-bold">{{ $def['label'] }}</label>
                <div class="col-md-9">
                    <input type="text" name="texts[{{ $key }}]" class="form-control"
                           value="{{ $current ?? $def['default'] }}">
                </div>
            </div>

            @else
            @php
                $isCustom = $current && !str_starts_with($current, 'img/');
                if (!$current) {
                    $currentUrl = $def['default'] ? asset($def['default']) : null;
                } elseif (str_starts_with($current, 'img/')) {
                    $currentUrl = asset($current);
                } else {
                    $currentUrl = asset('storage/' . $current);
                }
            @endphp
            <div class="row align-items-center mb-4 pb-4 border-bottom">
                <div class="col-md-2 text-center">
                    @if($currentUrl)
                        <img src="{{ $currentUrl }}" alt="{{ $def['label'] }}"
                             style="max-width:120px; max-height:80px; object-fit:contain; border:1px solid #dee2e6; padding:4px; background:#f8f9fa;">
                    @else
                        <div style="width:120px; height:80px; background:#f0f0f0; display:flex; align-items:center; justify-content:center; border:1px solid #dee2e6; margin:auto;">
                            <small class="text-muted">No image</small>
                        </div>
                    @endif
                </div>
                <div class="col-md-10">
                    <label class="font-weight-bold d-block mb-1">{{ $def['label'] }}</label>
                    @if($isCustom)
                        <span class="badge badge-success mb-2">Custom image active</span>
                    @elseif($current)
                        <span class="badge badge-secondary mb-2">Default</span>
                    @else
                        <span class="badge badge-warning mb-2">Not set</span>
                    @endif
                    <div class="mb-2">
                        <input type="file" name="images[{{ $key }}]" class="form-control-file" accept="image/*">
                    </div>
                    @if($isCustom)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remove[{{ $key }}]" value="1" id="remove_{{ $key }}">
                        <label class="form-check-label text-danger" for="remove_{{ $key }}">
                            Remove custom image and revert to default
                        </label>
                    </div>
                    @endif
                </div>
            </div>
            @endif
            @endforeach

            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Save Changes
            </button>
        </form>
    </div>
</div>
@endsection
