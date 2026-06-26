@extends('layouts.dashboard')

@section('title', 'Add New Listing')
@section('page-title', 'Add New Listing')
@section('page-subtitle', 'Submit a property for admin approval')

@section('topbar-actions')
    <a href="{{ route('agent.listings.index') }}" class="btn-outline btn-sm">
        <i class="fa-solid fa-arrow-left"></i> My Listings
    </a>
@endsection

@push('styles')
<style>
.form-grid { display:grid; grid-template-columns:1fr 380px; gap:24px; align-items:start; }
.form-section { background:white; border:1px solid var(--gray-200); border-radius:var(--radius-lg); padding:24px; margin-bottom:20px; box-shadow:var(--shadow-xs); }
.form-section-title { font-size:15px; font-weight:700; color:var(--gray-900); margin-bottom:18px; padding-bottom:12px; border-bottom:1px solid var(--gray-100); display:flex; align-items:center; gap:8px; }
.form-section-title i { color:var(--primary); }
.upload-zone { border:2px dashed var(--gray-200); border-radius:var(--radius-lg); padding:36px 24px; text-align:center; cursor:pointer; transition:all 0.2s; background:var(--gray-50); }
.upload-zone:hover, .upload-zone.dragover { border-color:var(--primary); background:rgba(27,67,50,0.03); }
.preview-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-top:14px; }
.preview-item { position:relative; aspect-ratio:4/3; border-radius:var(--radius-sm); overflow:hidden; background:var(--gray-100); }
.preview-item img { width:100%; height:100%; object-fit:cover; }
.preview-primary { position:absolute; bottom:4px; left:4px; background:var(--primary); color:white; font-size:9px; font-weight:700; padding:2px 6px; border-radius:4px; text-transform:uppercase; }
.info-box { background:rgba(27,67,50,0.06); border:1px solid rgba(27,67,50,0.15); border-radius:var(--radius); padding:14px 16px; font-size:13px; color:var(--primary); display:flex; align-items:flex-start; gap:10px; margin-bottom:16px; line-height:1.6; }
.amenity-chip { display:inline-flex; align-items:center; gap:7px; padding:8px 14px; border:1.5px solid var(--gray-200); border-radius:var(--radius-full); font-size:13px; font-weight:500; color:var(--gray-600); cursor:pointer; transition:all 0.18s; user-select:none; background:white; }
.amenity-chip input[type=checkbox] { display:none; }
.amenity-chip:hover { border-color:var(--primary); color:var(--primary); background:rgba(27,67,50,0.04); }
.amenity-chip--active { border-color:var(--primary) !important; background:var(--primary) !important; color:white !important; }
.amenity-chip--active i { color:white !important; }
@media(max-width:900px) { .form-grid { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')

@if ($errors->any())
    <div class="alert alert-error">
        <i class="fa-solid fa-circle-exclamation"></i>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul style="margin-top:6px;padding-left:16px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form method="POST" action="{{ route('agent.listings.store') }}" enctype="multipart/form-data" id="listingForm" target="_self">
@csrf

<div class="form-grid">

    {{-- LEFT COLUMN --}}
    <div>

        {{-- Basic Info --}}
        <div class="form-section">
            <h2 class="form-section-title">
                <i class="fa-solid fa-circle-info"></i> Basic Information
            </h2>

            <div class="field">
                <label>Listing Title <span class="required">*</span></label>
                <input type="text" name="title"
                    value="{{ old('title') }}"
                    placeholder="e.g. Modern 3-Bedroom Apartment in Njiro"
                    class="{{ $errors->has('title') ? 'is-invalid' : '' }}"
                    required>
                @error('title')<div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>Description <span class="required">*</span></label>
                <textarea name="description" rows="5"
                    placeholder="Describe the property in detail. Include key features, nearby amenities, and any special conditions..."
                    class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                    required>{{ old('description') }}</textarea>
                @error('description')<div class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
            </div>

            <div class="field-row">
                <div class="field">
                    <label>Listing Type <span class="required">*</span></label>
                    <select name="type" required class="{{ $errors->has('type') ? 'is-invalid' : '' }}">
                        <option value="">Select type</option>
                        <option value="rent"  {{ old('type') === 'rent'  ? 'selected' : '' }}>For Rent</option>
                        <option value="sale"  {{ old('type') === 'sale'  ? 'selected' : '' }}>For Sale</option>
                    </select>
                    @error('type')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label>Category <span class="required">*</span></label>
                    <select name="category" required class="{{ $errors->has('category') ? 'is-invalid' : '' }}">
                        <option value="">Select category</option>
                        @foreach(['apartment'=>'Apartment','house'=>'House','villa'=>'Villa','land'=>'Land','commercial'=>'Commercial'] as $val => $label)
                            <option value="{{ $val }}" {{ old('category') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="field">
                <label>Price (TZS) <span class="required">*</span></label>
                <div style="position:relative;">
                    <span style="position:absolute;left:14px;top:50%;transform:translateY(-50%);font-size:13px;font-weight:600;color:var(--gray-500);">TZS</span>
                    <input type="number" name="price"
                        value="{{ old('price') }}"
                        placeholder="0"
                        style="padding-left:48px;"
                        class="{{ $errors->has('price') ? 'is-invalid' : '' }}"
                        required>
                </div>
                @error('price')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Location --}}
        <div class="form-section">
            <h2 class="form-section-title">
                <i class="fa-solid fa-location-dot"></i> Location Details
            </h2>

            <div class="field">
                <label>Area / Neighbourhood <span class="required">*</span></label>
                <select name="location" required class="{{ $errors->has('location') ? 'is-invalid' : '' }}">
                    <option value="">Select area</option>
                    @foreach(['Njiro','Sakina','Themi','Kimandolu','Ngarenaro','Kijenge','Kaloleni','Sekei','Olorien','Lemara','Moshono','Baraa','Sombetini','Tengeru','Other'] as $area)
                        <option value="{{ $area }}" {{ old('location') === $area ? 'selected' : '' }}>{{ $area }}</option>
                    @endforeach
                </select>
                @error('location')<div class="field-error">{{ $message }}</div>@enderror
            </div>

            <div class="field">
                <label>Full Address</label>
                <input type="text" name="address"
                    value="{{ old('address') }}"
                    placeholder="e.g. Plot 45, Njiro Road, near Njiro Hub">
                @error('address')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Property Details --}}
        <div class="form-section">
            <h2 class="form-section-title">
                <i class="fa-solid fa-house-chimney"></i> Property Details
            </h2>

            <div class="field-row">
                <div class="field">
                    <label>Bedrooms</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" placeholder="e.g. 3" min="0" max="20">
                    @error('bedrooms')<div class="field-error">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                    <label>Bathrooms</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" placeholder="e.g. 2" min="0" max="20">
                    @error('bathrooms')<div class="field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="field">
                <label>Total Area (m²)</label>
                <input type="number" name="area" value="{{ old('area') }}" placeholder="e.g. 120" min="1" step="0.1">
                @error('area')<div class="field-error">{{ $message }}</div>@enderror
            </div>
        </div>

        {{-- Amenities --}}
        <div class="form-section">
            <h2 class="form-section-title">
                <i class="fa-solid fa-star"></i> Amenities
                <span style="font-size:11px;color:var(--gray-400);font-weight:400;margin-left:auto;">Select all that apply</span>
            </h2>
            @php
            $amenityList = [
                'wifi'         => ['icon' => 'fa-wifi',            'label' => 'WiFi'],
                'parking'      => ['icon' => 'fa-square-parking',  'label' => 'Parking'],
                'security'     => ['icon' => 'fa-shield-halved',   'label' => 'Security Guard'],
                'generator'    => ['icon' => 'fa-bolt',            'label' => 'Generator'],
                'water_tank'   => ['icon' => 'fa-droplet',         'label' => 'Water Tank'],
                'cctv'         => ['icon' => 'fa-video',           'label' => 'CCTV'],
                'garden'       => ['icon' => 'fa-leaf',            'label' => 'Garden'],
                'swimming_pool'=> ['icon' => 'fa-water-ladder',    'label' => 'Swimming Pool'],
                'ac'           => ['icon' => 'fa-wind',            'label' => 'Air Conditioning'],
                'balcony'      => ['icon' => 'fa-building',        'label' => 'Balcony'],
                'lift'         => ['icon' => 'fa-elevator',        'label' => 'Lift/Elevator'],
                'furnished'    => ['icon' => 'fa-couch',           'label' => 'Furnished'],
            ];
            $selected = old('amenities', []);
            @endphp
            <div style="display:flex;flex-wrap:wrap;gap:10px;">
                @foreach($amenityList as $value => $amenity)
                <label class="amenity-chip {{ in_array($value, $selected) ? 'amenity-chip--active' : '' }}" for="amenity_{{ $value }}">
                    <input type="checkbox" id="amenity_{{ $value }}" name="amenities[]" value="{{ $value }}"
                        {{ in_array($value, $selected) ? 'checked' : '' }}
                        onchange="this.closest('.amenity-chip').classList.toggle('amenity-chip--active', this.checked)">
                    <i class="fa-solid {{ $amenity['icon'] }}"></i>
                    {{ $amenity['label'] }}
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN --}}
    <div>

        {{-- Approval notice --}}
        <div class="form-section">
            <div class="info-box">
                <i class="fa-solid fa-circle-info" style="margin-top:1px;flex-shrink:0;"></i>
                <div>
                    <strong>Approval Required</strong><br>
                    Your listing will be reviewed by our admin team before going live. This usually takes less than 24 hours. You will be able to see the status in your dashboard.
                </div>
            </div>

            {{-- Status flow visual --}}
            <div style="display:flex;flex-direction:column;gap:0;">
                @foreach([
                    ['icon'=>'fa-upload','label'=>'You submit listing','color'=>'#2563EB','bg'=>'#EFF6FF','done'=>true],
                    ['icon'=>'fa-clock','label'=>'Admin reviews','color'=>'#D97706','bg'=>'#FFFBEB','done'=>false],
                    ['icon'=>'fa-circle-check','label'=>'Goes live on NyumbaHub','color'=>'#059669','bg'=>'#ECFDF5','done'=>false],
                ] as $i => $step)
                <div style="display:flex;align-items:center;gap:12px;padding:10px 0;">
                    <div style="display:flex;flex-direction:column;align-items:center;gap:0;">
                        <div style="width:32px;height:32px;border-radius:50%;background:{{ $step['bg'] }};display:flex;align-items:center;justify-content:center;font-size:13px;color:{{ $step['color'] }};flex-shrink:0;">
                            <i class="fa-solid {{ $step['icon'] }}"></i>
                        </div>
                        @if($i < 2)
                        <div style="width:2px;height:16px;background:var(--gray-200);margin:2px 0;"></div>
                        @endif
                    </div>
                    <div style="font-size:13px;font-weight:{{ $step['done'] ? '700' : '500' }};color:{{ $step['done'] ? 'var(--gray-900)' : 'var(--gray-500)' }};">
                        {{ $step['label'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Images --}}
        <div class="form-section">
            <h2 class="form-section-title">
                <i class="fa-solid fa-images"></i> Property Photos
                <span style="font-size:11px;color:var(--gray-400);font-weight:400;margin-left:auto;">Max 5 images · 2MB each</span>
            </h2>

            <div class="upload-zone" id="uploadZone" onclick="document.getElementById('images').click()">
                <i class="fa-solid fa-cloud-arrow-up" style="font-size:32px;color:var(--primary);margin-bottom:10px;display:block;"></i>
                <div style="font-size:14px;font-weight:600;color:var(--gray-700);margin-bottom:4px;">Click to upload photos</div>
                <div style="font-size:12px;color:var(--gray-400);">or drag and drop here</div>
                <div style="font-size:11px;color:var(--gray-400);margin-top:6px;">JPG, PNG, WEBP accepted</div>
            </div>

            <input type="file" id="images" name="images[]"
                accept="image/jpeg,image/jpg,image/png,image/webp"
                multiple style="display:none"
                onchange="previewImages(event)">

            @error('images')   <div class="field-error" style="margin-top:8px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
            @error('images.*') <div class="field-error" style="margin-top:8px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror

            <div id="previewGrid" class="preview-grid"></div>
            <p id="imageCountText" style="font-size:12px;color:var(--gray-400);margin-top:8px;"></p>
        </div>

        {{-- Submit --}}
        <div class="form-section" style="margin-bottom:0;">
            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;height:46px;font-size:15px;">
                <i class="fa-solid fa-paper-plane"></i> Submit for Approval
            </button>
            <p style="font-size:12px;color:var(--gray-400);text-align:center;margin-top:10px;">
                You can edit your listing after submission
            </p>
        </div>

    </div>
</div>

</form>

@endsection

@push('scripts')
<script>
// Image preview
function previewImages(event) {
    const files = Array.from(event.target.files);
    const grid  = document.getElementById('previewGrid');
    const count = document.getElementById('imageCountText');
    grid.innerHTML = '';

    if (files.length > 5) {
        alert('Maximum 5 images allowed. Only first 5 will be used.');
        return;
    }

    let totalSize = 0;
    let sizeError = false;

    files.forEach((file, index) => {
        totalSize += file.size;
        if (file.size > 2 * 1024 * 1024) {
            alert(`"${file.name}" exceeds 2MB.`);
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
            div.className = 'preview-item';
            div.innerHTML = `
                <img src="${e.target.result}" alt="">
                ${index === 0 ? '<span class="preview-primary">Cover</span>' : ''}
            `;
            grid.appendChild(div);
        };
        reader.readAsDataURL(file);
    });

    count.textContent = `${files.length} photo${files.length > 1 ? 's' : ''} selected`;
    document.getElementById('uploadZone').style.borderColor = '#1B4332';
}

// Drag and drop
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover',  e => { e.preventDefault(); zone.classList.add('dragover'); });
zone.addEventListener('dragleave', () => zone.classList.remove('dragover'));
zone.addEventListener('drop', e => {
    e.preventDefault();
    zone.classList.remove('dragover');
    const input = document.getElementById('images');
    input.files = e.dataTransfer.files;
    previewImages({ target: input });
});
</script>
@endpush
