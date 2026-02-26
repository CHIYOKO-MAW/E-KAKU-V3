<div>
    <label class="mb-1 block text-sm font-medium text-gray-700" for="nik">NIK</label>
    <input id="nik" name="nik" type="text" value="{{ old('nik', $biodata->nik ?? '') }}" class="form-input" required>
    @error('nik') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-gray-700" for="tempat_lahir">Tempat Lahir</label>
    <input id="tempat_lahir" name="tempat_lahir" type="text" value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" class="form-input" required>
    @error('tempat_lahir') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-gray-700" for="tanggal_lahir">Tanggal Lahir</label>
    <input id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" class="form-input" required>
    @error('tanggal_lahir') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-gray-700" for="alamat">Alamat</label>
    <textarea id="alamat" name="alamat" class="form-input" required>{{ old('alamat', $biodata->alamat ?? '') }}</textarea>
    @error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-gray-700" for="pendidikan">Pendidikan</label>
    <input id="pendidikan" name="pendidikan" type="text" value="{{ old('pendidikan', $biodata->pendidikan ?? '') }}" class="form-input" required>
    @error('pendidikan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-gray-700" for="keahlian">Keahlian</label>
    <input id="keahlian" name="keahlian" type="text" value="{{ old('keahlian', $biodata->keahlian ?? '') }}" class="form-input">
    @error('keahlian') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
