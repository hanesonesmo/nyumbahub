@extends('layouts.app')

@section('title', 'Edit Listing — NyumbaHub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}?v={{ time() }}">
    <style>
    .amenity-chip { display:inline-flex; align-items:center; gap:7px; padding:8px 14px; border:1.5px solid var(--gray-200,#E5E7EB); border-radius:9999px; font-size:13px; font-weight:500; color:#6B7280; cursor:pointer; transition:all 0.18s; user-select:none; background:white; }
    .amenity-chip input[type=checkbox] { display:none; }
    .amenity-chip:hover { border-color:#1B4332; color:#1B4332; background:rgba(27,67,50,0.04); }
    .amenity-chip--active { border-color:#1B4332 !important; background:#1B4332 !important; color:white !important; }
    .amenity-chip--active i { color:white !important; }
    </style>
@endpush

@section('content')

<div class="form-page">

    <div class="form-page-header">
        <div>
            <h1 class="dashboard-title">{{ __('Edit Listing') }}</h1>
            <p class="dashboard-subtitle">{{ __('Update your property details — it will be resubmitted for approval.') }}</p>
        </div>
        <a href="{{ route('agent.listings.index') }}" class="btn-outline">
            <i class="fa-solid fa-arrow-left"></i> {{ __('My Listings') }}
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-error" style="margin-bottom:24px;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong>{{ __('Please fix the following:') }}</strong>
                <ul style="margin-top:6px;padding-left:16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('agent.listings.update', $listing->id) }}" enctype="multipart/form-data" id="listingEditForm">
        @csrf
        @method('PUT')

        <div class="listing-form">

            {{-- LEFT --}}
            <div class="listing-form-left">

                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-circle-info"></i> {{ __('Basic Information') }}</h2>

                    <div class="field">
                        <label>{{ __('Listing Title') }} <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $listing->title) }}"
                            placeholder="{{ __('e.g. Modern 3BR Apartment in Njiro') }}"
                            class="{{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                        @error('title') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>{{ __('Description') }} <span class="required">*</span></label>
                        <textarea name="description" rows="5"
                            placeholder="{{ __('Describe the property...') }}"
                            class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                            required>{{ old('description', $listing->description) }}</textarea>
                        @error('description') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label>{{ __('Type') }} <span class="required">*</span></label>
                            <select name="type" required>
                                <option value="">{{ __('Select type') }}</option>
                                <option value="rent" {{ old('type', $listing->type) === 'rent' ? 'selected' : '' }}>For Rent</option>
                                <option value="sale" {{ old('type', $listing->type) === 'sale' ? 'selected' : '' }}>For Sale</option>
                            </select>
                            @error('type') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label>{{ __('Category') }} <span class="required">*</span></label>
                            <select name="category" required>
                                <option value="">{{ __('Select category') }}</option>
                                @foreach(['apartment','house','villa','land','commercial'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $listing->category) === $cat ? 'selected' : '' }}>
                                        {{ ucfirst($cat) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label>{{ __('Price (TZS)') }} <span class="required">*</span></label>
                        <input type="number" name="price" value="{{ old('price', $listing->price) }}"
                            placeholder="{{ __('e.g. 500000') }}" required>
                        @error('price') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-location-dot"></i> {{ __('Location') }}</h2>

                    <div class="field">
                        <label>{{ __('Area') }} <span class="required">*</span></label>
                        <select name="location" required>
                            <option value="">{{ __('Select area') }}</option>
                            @foreach(['Njiro','Sakina','Themi','Kimandolu','Ngarenaro','Kijenge','Kaloleni','Sekei','Olorien','Lemara','Moshono','Baraa','Sombetini','Other'] as $area)
                                <option value="{{ $area }}" {{ old('location', $listing->location) === $area ? 'selected' : '' }}>
                                    {{ $area }}
                                </option>
                            @endforeach
                        </select>
                        @error('location') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>{{ __('Full Address') }}</label>
                        <input type="text" name="address" value="{{ old('address', $listing->address) }}"
                            placeholder="{{ __('e.g. Plot 45, Njiro Road') }}">
                        @error('address') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="listing-form-right">

                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-house-chimney"></i> {{ __('Property Details') }}</h2>

                    <div class="field-row">
                        <div class="field">
                            <label>{{ __('Bedrooms') }}</label>
                            <input type="number" name="bedrooms" value="{{ old('bedrooms', $listing->bedrooms) }}"
                                placeholder="{{ __('e.g. 3') }}" min="0" max="20">
                            @error('bedrooms') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>{{ __('Bathrooms') }}</label>
                            <input type="number" name="bathrooms" value="{{ old('bathrooms', $listing->bathrooms) }}"
                                placeholder="{{ __('e.g. 2') }}" min="0" max="20">
                            @error('bathrooms') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label>{{ __('Area (m²)') }}</label>
                        <input type="number" name="area" value="{{ old('area', $listing->area) }}"
                            placeholder="{{ __('e.g. 120') }}" min="1" step="0.1">
                        @error('area') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Amenities --}}
                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-star"></i> {{ __('Amenities') }}</h2>
                    @php
                    $amenityList = [
                        'wifi'          => ['icon' => 'fa-wifi',           'label' => 'WiFi'],
                        'parking'       => ['icon' => 'fa-square-parking', 'label' => 'Parking'],
                        'security'      => ['icon' => 'fa-shield-halved',  'label' => 'Security Guard'],
                        'generator'     => ['icon' => 'fa-bolt',           'label' => 'Generator'],
                        'water_tank'    => ['icon' => 'fa-droplet',        'label' => 'Water Tank'],
                        'cctv'          => ['icon' => 'fa-video',          'label' => 'CCTV'],
                        'garden'        => ['icon' => 'fa-leaf',           'label' => 'Garden'],
                        'swimming_pool' => ['icon' => 'fa-water-ladder',   'label' => 'Swimming Pool'],
                        'ac'            => ['icon' => 'fa-wind',           'label' => 'Air Conditioning'],
                        'balcony'       => ['icon' => 'fa-building',       'label' => 'Balcony'],
                        'lift'          => ['icon' => 'fa-elevator',       'label' => 'Lift/Elevator'],
                        'furnished'     => ['icon' => 'fa-couch',          'label' => 'Furnished'],
                    ];
                    $selected = old('amenities', $listing->amenities ?? []);
                    @endphp
                    <div style="display:flex;flex-wrap:wrap;gap:10px;">
                        @foreach($amenityList as $value => $amenity)
                        <label class="amenity-chip {{ in_array($value, $selected) ? 'amenity-chip--active' : '' }}" for="edit_amenity_{{ $value }}">
                            <input type="checkbox" id="edit_amenity_{{ $value }}" name="amenities[]" value="{{ $value }}"
                                {{ in_array($value, $selected) ? 'checked' : '' }}
                                onchange="this.closest('.amenity-chip').classList.toggle('amenity-chip--active', this.checked)">
                            <i class="fa-solid {{ $amenity['icon'] }}"></i>
                            {{ $amenity['label'] }}
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Current images --}}
                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-images"></i> {{ __('Current Images') }}</h2>

                    @if($listing->images->count() > 0)
                        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:16px;">
                            @foreach($listing->images as $image)
                            <div style="position:relative;border-radius:8px;overflow:hidden;aspect-ratio:4/3;">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                    style="width:100%;height:100%;object-fit:cover;">
                                <form method="POST" action="{{ route('agent.listings.images.delete', $image->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="position:absolute;top:4px;right:4px;width:24px;height:24px;border-radius:50%;background:rgba(0,0,0,0.6);color:#fff;border:none;cursor:pointer;font-size:11px;display:flex;align-items:center;justify-content:center;"
                                        onclick="return confirm('Remove this image?')">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                                @if($image->is_primary)
                                    <span style="position:absolute;bottom:4px;left:4px;background:var(--primary,#1B4332);color:#fff;font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;">{{ __('COVER') }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size:13px;color:var(--text-muted,#717171);margin-bottom:16px;">{{ __('No images yet.') }}</p>
                    @endif

                    {{-- Add new images --}}
                    <p style="font-size:13px;color:var(--text-muted,#717171);margin-bottom:12px;">
                        {{ __('Add more images (max 5 total). JPG, PNG, WEBP. Max 2MB each.') }}
                    </p>

                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('images').click()">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>{{ __('Click to add more images') }}</p>
                        <span>{{ __('or drag and drop') }}</span>
                    </div>

                    <input type="file" id="images" name="images[]"
                        accept="image/jpeg,image/jpg,image/png,image/webp"
                        multiple style="display:none"
                        onchange="previewImages(event)">

                    @error('images') <div class="field-error">{{ $message }}</div> @enderror
                    @error('images.*') <div class="field-error">{{ $message }}</div> @enderror

                    <div id="previewGrid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-top:12px;"></div>
                    <p class="image-count-text" id="imageCount"></p>
                </div>

                {{-- Video Upload --}}
                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-video"></i> {{ __('Walkthrough Video') }}
                        <span style="font-size:11px;color:var(--gray-400);font-weight:400;margin-left:auto;">{{ __('Optional · Max 100MB · Max 90s') }}</span>
                    </h2>

                    @if($listing->video_path)
                        <div style="margin-bottom:16px;">
                            <video src="{{ asset('storage/' . $listing->video_path) }}" controls preload="metadata" style="width:100%; border-radius:8px; max-height:250px; background:#000;"></video>
                            <label style="display:flex; align-items:center; gap:8px; margin-top:10px; font-size:13px; color:var(--danger); cursor:pointer;">
                                <input type="checkbox" name="remove_video" value="1">
                                <i class="fa-solid fa-trash"></i> {{ __('Remove current video completely') }}
                            </label>
                        </div>
                    @endif

                    <div class="upload-area" id="videoZone" onclick="document.getElementById('video').click()" style="margin-bottom:10px; text-align:center;">
                        <i class="fa-solid fa-film"></i>
                        <p id="videoZoneText">{{ $listing->video_path ? __('Replace current video') : __('Upload a video') }}</p>
                        <span>{{ __('MP4, MOV, WEBM accepted') }}</span>
                    </div>

                    <input type="file" id="video" name="video"
                        accept="video/mp4,video/quicktime,video/webm"
                        style="display:none"
                        onchange="previewVideo(event)">
                    
                    <div id="videoError" class="field-error" style="display:none;margin-top:8px;"><i class="fa-solid fa-circle-exclamation"></i> <span></span></div>
                    @error('video') <div class="field-error" style="margin-top:8px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror

                    {{-- Video Preview & Progress --}}
                    <div id="videoPreviewContainer" style="display:none; margin-top:16px; position:relative;">
                        <video id="videoPlayer" controls style="width:100%; border-radius:8px; max-height:250px; background:#000;"></video>
                        <div id="videoProgressWrapper" style="display:none; margin-top:10px;">
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px; font-weight:600;">
                                <span>{{ __('Uploading...') }}</span>
                                <span id="videoProgressText">0%</span>
                            </div>
                            <div style="width:100%; height:8px; background:var(--gray-200); border-radius:4px; overflow:hidden;">
                                <div id="videoProgressBar" style="width:0%; height:100%; background:var(--primary); transition:width 0.2s;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="form-section" style="border:none;padding-top:0;">
                    <div class="submit-info">
                        <i class="fa-solid fa-circle-info"></i>
                        {{ __('Editing will resubmit for admin approval.') }}
                    </div>
                    <button type="submit" id="submitBtn" class="btn-primary" style="width:100%;justify-content:center;">
                        <span id="submitBtnText">{{ __('Save Changes') }}</span>
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
// Video preview and validation
function previewVideo(event) {
    const file = event.target.files[0];
    const container = document.getElementById('videoPreviewContainer');
    const player = document.getElementById('videoPlayer');
    const error = document.getElementById('videoError');
    const errorSpan = error.querySelector('span');
    const zoneText = document.getElementById('videoZoneText');

    error.style.display = 'none';
    container.style.display = 'none';
    
    if (!file) {
        zoneText.textContent = 'Upload a video';
        return;
    }

    // Check size (100MB)
    if (file.size > 100 * 1024 * 1024) {
        errorSpan.textContent = 'Video exceeds 100MB limit.';
        error.style.display = 'block';
        event.target.value = '';
        zoneText.textContent = 'Upload a video';
        return;
    }

    // Check duration (90s)
    const url = URL.createObjectURL(file);
    const tempVideo = document.createElement('video');
    tempVideo.preload = 'metadata';
    tempVideo.onloadedmetadata = function() {
        URL.revokeObjectURL(url);
        if (tempVideo.duration > 90) {
            errorSpan.textContent = 'Video duration exceeds 90 seconds (actual: ' + Math.round(tempVideo.duration) + 's).';
            error.style.display = 'block';
            event.target.value = '';
            zoneText.textContent = 'Upload a video';
        } else {
            // Valid video
            const finalUrl = URL.createObjectURL(file);
            player.src = finalUrl;
            container.style.display = 'block';
            zoneText.textContent = file.name;
        }
    };
    tempVideo.src = url;
}

// Custom form submission for progress UI
document.getElementById('listingEditForm').addEventListener('submit', function(e) {
    const videoFile = document.getElementById('video').files[0];
    const imagesFile = document.getElementById('images').files.length > 0;
    
    if (videoFile || imagesFile) {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitBtnText');
        
        // Prevent double submission if already loading
        if (submitBtn.dataset.submitting === 'true') {
            e.preventDefault();
            return;
        }

        submitBtn.dataset.submitting = 'true';
        
        setTimeout(() => {
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';
            submitText.textContent = 'Uploading... Please wait';
            
            if (videoFile) {
                const wrapper = document.getElementById('videoProgressWrapper');
                const bar = document.getElementById('videoProgressBar');
                const text = document.getElementById('videoProgressText');
                
                wrapper.style.display = 'block';
                text.textContent = 'Uploading...';
                bar.style.width = '100%';
            }
        }, 0);
    }
});

// Image preview
function previewImages(event) {
    const files = Array.from(event.target.files);
    const grid = document.getElementById('previewGrid');
    const countText = document.getElementById('imageCount');
    grid.innerHTML = '';

    if (files.length > 5) {
        alert('Maximum 5 images allowed.');
        event.target.value = '';
        return;
    }

    let totalSize = 0;
    let sizeError = false;

    files.forEach((file, index) => {
        totalSize += file.size;
        if (file.size > 2 * 1024 * 1024) {
            alert(`"${file.name}" exceeds 2MB limit.`);
            sizeError = true;
        }
    });

    if (sizeError) {
        event.target.value = '';
        return;
    }

    if (totalSize > 7 * 1024 * 1024) {
        alert('Total size of all images combined exceeds 7MB. Please select fewer or smaller images.');
        event.target.value = '';
        return;
    }

    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.style.cssText = 'position:relative;border-radius:8px;overflow:hidden;aspect-ratio:4/3;';
            div.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">
                ${index === 0 ? '<span style="position:absolute;bottom:4px;left:4px;background:#1B4332;color:#fff;font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;">{{ __('NEW COVER') }}</span>' : ''}`;
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });

    countText.textContent = `${files.length} new image${files.length > 1 ? 's' : ''} selected`;
    document.getElementById('uploadArea').style.borderColor = '#1B4332';
}

// Drag and drop
const uploadArea = document.getElementById('uploadArea');
uploadArea.addEventListener('dragover', e => { e.preventDefault(); uploadArea.classList.add('drag-over'); });
uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('drag-over'));
uploadArea.addEventListener('drop', e => {
    e.preventDefault();
    uploadArea.classList.remove('drag-over');
    const input = document.getElementById('images');
    input.files = e.dataTransfer.files;
    previewImages({ target: input });
});
</script>
@endpush
