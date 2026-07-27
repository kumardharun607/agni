@php $u = $user ?? null; @endphp

<div class="grid grid-cols-2 gap-5">
  <div>
    <label class="form-label">Employee Code *</label>
    <input type="text" name="emp_code" value="{{ old('emp_code', $u->emp_code ?? '') }}" class="form-input" required>
    @error('emp_code') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Role *</label>
    <select name="role_id" class="form-select" required>
      <option value="">Select Role</option>
      @foreach($roles as $r)
        <option value="{{ $r->id }}" @selected(old('role_id', $u->role_id ?? '') == $r->id)>{{ $r->name }}</option>
      @endforeach
    </select>
    @error('role_id') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Name *</label>
    <input type="text" name="name" value="{{ old('name', $u->name ?? '') }}" class="form-input" required>
    @error('name') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Mobile *</label>
    <input type="text" name="mobile" value="{{ old('mobile', $u->mobile ?? '') }}" class="form-input" required maxlength="15">
    @error('mobile') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Email *</label>
    <input type="email" name="email" value="{{ old('email', $u->email ?? '') }}" class="form-input" required>
    @error('email') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Password {{ $u ? '(leave blank to keep current)' : '(leave blank to auto-generate)' }}</label>
    <input type="password" name="plain_password" class="form-input" autocomplete="new-password">
    <p class="text-xs text-on-surface/50 mt-1">Stored as plain text for admin reference and as a bcrypt hash for login.</p>
    @error('plain_password') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Date of Joining</label>
    <input type="date" name="doj" value="{{ old('doj', optional($u->doj ?? null)->format('Y-m-d')) }}" class="form-input">
  </div>

  <div>
    <label class="form-label">Date of Birth</label>
    <input type="date" name="dob" value="{{ old('dob', optional($u->dob ?? null)->format('Y-m-d')) }}" class="form-input">
  </div>

  <div>
    <label class="form-label">Country</label>
    <select name="country_id" id="country_id" class="form-select">
      <option value="">Select Country</option>
      @foreach($countries as $c)
        <option value="{{ $c->id }}" @selected(old('country_id', $u->country_id ?? '') == $c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label class="form-label">State</label>
    <select name="state_id" id="state_id" class="form-select"><option value="">Select State</option></select>
  </div>

  <div>
    <label class="form-label">City</label>
    <select name="city_id" id="city_id" class="form-select"><option value="">Select City</option></select>
  </div>

  <div>
    <label class="form-label">Pincode</label>
    <select name="pincode_id" id="pincode_id" class="form-select"><option value="">Select Pincode</option></select>
  </div>

  <div class="col-span-2">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-textarea" rows="2">{{ old('address', $u->address ?? '') }}</textarea>
  </div>
</div>

<div class="flex gap-3 pt-6">
  <button class="btn-primary">Save</button>
  <a href="{{ route('users.index') }}" class="btn-secondary">Cancel</a>
</div>

<script>
(function () {
  const countrySel = document.getElementById('country_id');
  const stateSel = document.getElementById('state_id');
  const citySel = document.getElementById('city_id');
  const pincodeSel = document.getElementById('pincode_id');

  const preselected = {
    state_id: "{{ old('state_id', $u->state_id ?? '') }}",
    city_id: "{{ old('city_id', $u->city_id ?? '') }}",
    pincode_id: "{{ old('pincode_id', $u->pincode_id ?? '') }}",
  };

  function loadStates(countryId, cb) {
    stateSel.innerHTML = '<option value="">Select State</option>';
    if (!countryId) return;
    fetch(`/ajax/states/${countryId}`).then(r => r.json()).then(data => { data.forEach(s => stateSel.append(new Option(s.name, s.id))); if (cb) cb(); });
  }
  function loadCities(stateId, cb) {
    citySel.innerHTML = '<option value="">Select City</option>';
    if (!stateId) return;
    fetch(`/ajax/cities/${stateId}`).then(r => r.json()).then(data => { data.forEach(c => citySel.append(new Option(c.name, c.id))); if (cb) cb(); });
  }
  function loadPincodes(cityId, cb) {
    pincodeSel.innerHTML = '<option value="">Select Pincode</option>';
    if (!cityId) return;
    fetch(`/ajax/pincodes/${cityId}`).then(r => r.json()).then(data => { data.forEach(p => pincodeSel.append(new Option(p.pincode, p.id))); if (cb) cb(); });
  }

  countrySel.addEventListener('change', () => loadStates(countrySel.value));
  stateSel.addEventListener('change', () => loadCities(stateSel.value));
  citySel.addEventListener('change', () => loadPincodes(citySel.value));

  if (countrySel.value) {
    loadStates(countrySel.value, () => {
      stateSel.value = preselected.state_id;
      loadCities(stateSel.value, () => {
        citySel.value = preselected.city_id;
        loadPincodes(citySel.value, () => { pincodeSel.value = preselected.pincode_id; });
      });
    });
  }
})();
</script>
