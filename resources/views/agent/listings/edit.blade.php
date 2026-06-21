@extends('layouts.app')

@section('title', 'Edit Listing — NyumbaHub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/listings.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="form-page">

    <div class="form-page-header">
        <div>
            <h1 class="dashboard-title">Edit Listing</h1>
            <p class="dashboard-subtitle">Update your property details — it will be resubmitted for approval.</p>
        </div>
        <a href="{{ route('agent.listings.index') }}" class="btn-outline">
            <i class="fa-solid fa-arrow-left"></i> My Listings
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-error" style="margin-bottom:24px;">
            <i class="fa-solid fa-circle-exclamation"></i>
            <div>
                <strong>Please fix the following:</strong>
                <ul style="margin-top:6px;padding-left:16px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('agent.listings.update', $listing->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="listing-form">

            {{-- LEFT --}}
            <div class="listing-form-left">

                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-circle-info"></i> Basic Information</h2>

                    <div class="field">
                        <label>Listing Title <span class="required">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $listing->title) }}"
                            placeholder="e.g. Modern 3BR Apartment in Njiro"
                            class="{{ $errors->has('title') ? 'is-invalid' : '' }}" required>
                        @error('title') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Description <span class="required">*</span></label>
                        <textarea name="description" rows="5"
                            placeholder="Describe the property..."
                            class="{{ $errors->has('description') ? 'is-invalid' : '' }}"
                            required>{{ old('description', $listing->description) }}</textarea>
                        @error('description') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field-row">
                        <div class="field">
                            <label>Type <span class="required">*</span></label>
                            <select name="type" required>
                                <option value="">Select type</option>
                                <option value="rent" {{ old('type', $listing->type) === 'rent' ? 'selected' : '' }}>For Rent</option>
                                <option value="sale" {{ old('type', $listing->type) === 'sale' ? 'selected' : '' }}>For Sale</option>
                            </select>
                            @error('type') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="field">
                            <label>Category <span class="required">*</span></label>
                            <select name="category" required>
                                <option value="">Select category</option>
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
                        <label>Price (TZS) <span class="required">*</span></label>
                        <input type="number" name="price" value="{{ old('price', $listing->price) }}"
                            placeholder="e.g. 500000" required>
                        @error('price') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-location-dot"></i> Location</h2>

                    <div class="field">
                        <label>Area <span class="required">*</span></label>
                        <select name="location" required>
                            <option value="">Select area</option>
                            @foreach(['Njiro','Sakina','Themi','Kimandolu','Ngarenaro','Kijenge','Kaloleni','Sekei','Olorien','Lemara','Moshono','Baraa','Sombetini','Other'] as $area)
                                <option value="{{ $area }}" {{ old('location', $listing->location) === $area ? 'selected' : '' }}>
                                    {{ $area }}
                                </option>
                            @endforeach
                        </select>
                        @error('location') <div class="field-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label>Full Address</label>
                        <input type="text" name="address" value="{{ old('address', $listing->address) }}"
                            placeholder="e.g. Plot 45, Njiro Road">
                        @error('address') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="listing-form-right">

                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-house-chimney"></i> Property Details</h2>

                    <div class="field-row">
                        <div class="field">
                            <label>Bedrooms</label>
                            <input type="number" name="bedrooms" value="{{ old('bedrooms', $listing->bedrooms) }}"
                                placeholder="e.g. 3" min="0" max="20">
                            @error('bedrooms') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                        <div class="field">
                            <label>Bathrooms</label>
                            <input type="number" name="bathrooms" value="{{ old('bathrooms', $listing->bathrooms) }}"
                                placeholder="e.g. 2" min="0" max="20">
                            @error('bathrooms') <div class="field-error">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label>Area (m²)</label>
                        <input type="number" name="area" value="{{ old('area', $listing->area) }}"
                            placeholder="e.g. 120" min="1" step="0.1">
                        @error('area') <div class="field-error">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Current images --}}
                <div class="form-section">
                    <h2 class="section-title"><i class="fa-solid fa-images"></i> Current Images</h2>

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
                                    <span style="position:absolute;bottom:4px;left:4px;background:var(--primary,#1B4332);color:#fff;font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;">COVER</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size:13px;color:var(--text-muted,#717171);margin-bottom:16px;">No images yet.</p>
                    @endif

                    {{-- Add new images --}}
                    <p style="font-size:13px;color:var(--text-muted,#717171);margin-bottom:12px;">
                        Add more images (max 5 total). JPG, PNG, WEBP. Max 2MB each.
                    </p>

                    <div class="upload-area" id="uploadArea" onclick="document.getElementById('images').click()">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <p>Click to add more images</p>
                        <span>or drag and drop</span>
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

                {{-- Submit --}}
                <div class="form-section" style="border:none;padding-top:0;">
                    <div class="submit-info">
                        <i class="fa-solid fa-circle-info"></i>
                        Editing will resubmit for admin approval.
                    </div>
                    <button type="submit" class="btn-primary" style="width:100%;justify-content:center;height:48px;font-size:15px;">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
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

    files.forEach((file, index) => {
        if (file.size > 2 * 1024 * 1024) {
            alert(`"${file.name}" exceeds 2MB limit.`);
            return;
        }
        const reader = new FileReader();
        reader.onload = e => {
            const div = document.createElement('div');
            div.style.cssText = 'position:relative;border-radius:8px;overflow:hidden;aspect-ratio:4/3;';
            div.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">
                ${index === 0 ? '<span style="position:absolute;bottom:4px;left:4px;background:#1B4332;color:#fff;font-size:9px;font-weight:700;padding:2px 6px;border-radius:4px;">NEW COVER</span>' : ''}`;
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
