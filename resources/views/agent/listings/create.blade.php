@extends('layouts.app')

@section('title', 'Add Listing — NyumbaHub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}">
@endpush

@section('content')

<div class="form-page">

    <div class="form-page-header">
        <div>
            <h1 class="dashboard-title">Add New Listing</h1>
            <p class="dashboard-subtitle">Fill in the details below. Your listing will be reviewed before going live.</p>
        </div>
        <a href="{{ route('agent.listings.index') }}" class="btn-outline">
            <i class="fa-solid fa-arrow-left"></i> My Listings
        </a>
    </div>

    {{-- Validation errors --}}
    @if ($errors->any())
        <div class="alert alert-error" style="margin-bottom:24px;">
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

    <form method="POST" action="{{ route('agent.listings.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="listing-form">

            {{-- LEFT COLUMN --}}
            <div class="listing-form-left">

                {{-- Basic info --}}
                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-circle-info"></i> Basic Information</h2>

                    <div class="field">
                        <label for="title">Listing Title <span class="required">*</span></label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title') }}"
                            placeholder="e.g. Modern 3BR Apartment in Njiro"
                            class="{{ $errors->has('title') ? 'is-invalid' : '' }}"
                            required>
                        @error('title') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="description">Description <span class="required">*</span></label>
                        <textarea id="description" name="description" rows="5"
                            placeholder="Describe the property in detail — features, surroundings, nearby amenities..."
                            class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                            required>{{ old('description') }}</textarea>
                        @error('description') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label for="type">Listing Type <span class="required">*</span></label>
                            <select id="type" name="type" class="{{ $errors->has('type') ? 'is-invalid' : '' }}" required>
                                <option value="">Select type</option>
                                <option value="rent" {{ old('type') === 'rent' ? 'selected' : '' }}>For Rent</option>
                                <option value="sale" {{ old('type') === 'sale' ? 'selected' : '' }}>For Sale</option>
                            </select>
                            @error('type') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="category">Category <span class="required">*</span></label>
                            <select id="category" name="category" class="{{ $errors->has('category') ? 'is-invalid' : '' }}" required>
                                <option value="">Select category</option>
                                <option value="apartment"  {{ old('category') === 'apartment'  ? 'selected' : '' }}>Apartment</option>
                                <option value="house"      {{ old('category') === 'house'      ? 'selected' : '' }}>House</option>
                                <option value="villa"      {{ old('category') === 'villa'      ? 'selected' : '' }}>Villa</option>
                                <option value="land"       {{ old('category') === 'land'       ? 'selected' : '' }}>Land</option>
                                <option value="commercial" {{ old('category') === 'commercial' ? 'selected' : '' }}>Commercial</option>
                            </select>
                            @error('category') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label for="price">
                            Price (TZS) <span class="required">*</span>
                            <span id="price-hint" style="font-weight:400;color:var(--text-muted);font-size:12px;"></span>
                        </label>
                        <input type="number" id="price" name="price"
                            value="{{ old('price') }}"
                            placeholder="e.g. 500000"
                            class="{{ $errors->has('price') ? 'is-invalid' : '' }}"
                            required>
                        @error('price') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Location --}}
                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-location-dot"></i> Location</h2>

                    <div class="field">
                        <label for="location">Area / Neighbourhood <span class="required">*</span></label>
                        <select id="location" name="location" class="{{ $errors->has('location') ? 'is-invalid' : '' }}" required>
                            <option value="">Select area</option>
                            @foreach(['Njiro','Sakina','Themi','Kimandolu','Ngarenaro','Kijenge','Kaloleni','Sekei','Olorien','Lemara','Moshono','Baraa','Sombetini','King\'ori','Other'] as $area)
                                <option value="{{ $area }}" {{ old('location') === $area ? 'selected' : '' }}>{{ $area }}</option>
                            @endforeach
                        </select>
                        @error('location') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="address">Full Address</label>
                        <input type="text" id="address" name="address"
                            value="{{ old('address') }}"
                            placeholder="e.g. Plot 45, Njiro Road">
                        @error('address') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="listing-form-right">

                {{-- Property details --}}
                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-house-chimney"></i> Property Details</h2>

                    <div class="field-row">
                        <div class="field">
                            <label for="bedrooms">Bedrooms</label>
                            <input type="number" id="bedrooms" name="bedrooms"
                                value="{{ old('bedrooms') }}"
                                placeholder="e.g. 3" min="0" max="20">
                            @error('bedrooms') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label for="bathrooms">Bathrooms</label>
                            <input type="number" id="bathrooms" name="bathrooms"
                                value="{{ old('bathrooms') }}"
                                placeholder="e.g. 2" min="0" max="20">
                            @error('bathrooms') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label for="area">Area (m²)</label>
                        <input type="number" id="area" name="area"
                            value="{{ old('area') }}"
                            placeholder="e.g. 120" min="1" step="0.1">
                        @error('area') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Images --}}
                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-images"></i> Property Images</h2>
                    <p style="font-size:13px;color:var(--text-muted);margin-bottom:16px;">
                        Upload 1–5 images. First image will be the cover photo.<br>
                        Accepted: JPG, PNG, WEBP. Max 2MB per image.
                    </p>

                    {{-- Upload area --}}
                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('images').click()">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>Click to upload images</p>
                        <span>or drag and drop here</span>
                    </div>

                    <input type="file" id="images" name="images[]"
                        accept="image/jpeg,image/jpg,image/png,image/webp"
                        multiple style="display:none"
                        onchange="previewImages(event)">

                    @error('images') <div class="field-error">{{ $message }}</div> @enderror
                    @error('images.*') <div class="field-error">{{ $message }}</div> @enderror

                    {{-- Preview grid --}}
                    <div class="image-preview-grid" id="previewGrid"></div>

                    <p class="image-count-text" id="imageCount"></p>
                </div>

                {{-- Submit --}}
                <div class="form-section" style="border:none;padding-top:0;">
                    <div class="submit-info">
                        <i class="fa-solid fa-circle-info"></i>
                        Your listing will be reviewed by admin before going live.
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center;height:48px;font-size:15px;">
                        <i class="fa-solid fa-paper-plane"></i> Submit Listing
                    </button>
                </div>

            </div>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
    // Show /month or /total hint based on type
    document.getElementById('type').addEventListener('change', function() {
        const hint = document.getElementById('price-hint');
        hint.textContent = this.value === 'rent' ? '(per month)' : '(total price)';
    });

    // Image preview
    function previewImages(event) {
        const files = Array.from(event.target.files);
        const grid = document.getElementById('previewGrid');
        const countText = document.getElementById('imageCount');
        const uploadArea = document.getElementById('uploadArea');

        grid.innerHTML = '';

        if (files.length > 5) {
            alert('You can only upload up to 5 images.');
            event.target.value = '';
            return;
        }

        files.forEach((file, index) => {
            if (!file.type.match('image.*')) return;
            if (file.size > 2 * 1024 * 1024) {
                alert(`"${file.name}" is too large. Max size is 2MB.`);
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview">
                    ${index === 0 ? '<span class="preview-badge">Cover</span>' : ''}
                `;
                grid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        countText.textContent = `${files.length} image${files.length > 1 ? 's' : ''} selected`;
        uploadArea.style.borderColor = 'var(--primary)';
    }

    // Drag and drop
    const uploadArea = document.getElementById('uploadArea');

    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('drag-over');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('drag-over');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('drag-over');
        const input = document.getElementById('images');
        input.files = e.dataTransfer.files;
        previewImages({ target: input });
    });
</script>
@endpush
