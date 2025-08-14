<div class="form-group">
    <label for="name"><i class="fas fa-certificate text-primary"></i> Brand Name <span class="text-danger">*</span></label>
    <input type="text" name="name" id="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $brand->name ?? '') }}"
           placeholder="Enter brand name" required>
    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
</div>

<div class="form-group">
    <label for="is_active"><i class="fas fa-toggle-on text-success"></i> Status <span class="text-danger">*</span></label>
    <select name="is_active" id="is_active"
            class="form-control @error('is_active') is-invalid @enderror" required>
        <option value="1" {{ old('is_active', $brand->is_active ?? '') == '1' ? 'selected' : '' }}>Active</option>
        <option value="2" {{ old('is_active', $brand->is_active ?? '') == '2' ? 'selected' : '' }}>Inactive</option>
    </select>
    @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
</div>
