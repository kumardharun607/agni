@php
  $d = $dealer ?? null;
@endphp

<div class="grid grid-cols-2 gap-5">

  <div>
    <label class="form-label">Dealer Name *</label>
    <input type="text" name="name" value="{{ old('name', $d->name ?? '') }}" class="form-input" required>
    @error('name') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Client Type *</label>
    <select name="client_type" id="client_type" class="form-select" required>
      <option value="">Select Type</option>
      <option value="1" @selected(old('client_type', $d->client_type ?? '') == 1)>Existing Dealer</option>
      <option value="2" @selected(old('client_type', $d->client_type ?? '') == 2)>New Dealer</option>
      <option value="3" @selected(old('client_type', $d->client_type ?? '') == 3)>Sub Dealer</option>
    </select>
    @error('client_type') <p class="error-text">{{ $message }}</p> @enderror
    @if($d)
      <p class="text-xs text-on-surface/50 mt-1">Alias ID: <span class="font-mono">{{ $d->alias_id }}</span> (auto-generated, not editable)</p>
    @else
      <p class="text-xs text-on-surface/50 mt-1">Alias ID (001, 002...) is generated automatically after saving.</p>
    @endif
  </div>

  {{-- Only visible for Sub Dealer (client_type = 3). For Existing/New dealer this stays 0/empty --}}
  <div id="parent_dealer_wrap" class="col-span-2" style="display:none;">
    <label class="form-label">Parent Dealer *</label>
    <select name="parent_dealer_id" class="form-select">
      <option value="">Select Parent Dealer</option>
      @foreach($parentDealers as $p)
        <option value="{{ $p->id }}" @selected(old('parent_dealer_id', $d->parent_dealer_id ?? '') == $p->id)>{{ $p->name }} ({{ $p->alias_id }})</option>
      @endforeach
    </select>
    @error('parent_dealer_id') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Designation</label>
    <input type="text" name="designation" value="{{ old('designation', $d->designation ?? '') }}" class="form-input">
  </div>

  <div>
    <label class="form-label">Contact Person</label>
    <input type="text" name="contact_person" value="{{ old('contact_person', $d->contact_person ?? '') }}" class="form-input">
  </div>

  <div>
    <label class="form-label">Mobile *</label>
    <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $d->mobile ?? '') }}" class="form-input" required maxlength="15">
    @error('mobile') <p class="error-text">{{ $message }}</p> @enderror
  </div>

  <div>
    <label class="form-label">Alternate Mobile</label>
    <input type="text" name="alternate_mobile" value="{{ old('alternate_mobile', $d->alternate_mobile ?? '') }}" class="form-input" maxlength="15">
  </div>

  <div class="col-span-2">
    <label class="flex items-center gap-2 text-sm text-on-surface mb-2">
      <input type="checkbox" id="same_as_mobile" name="same_as_mobile" value="1"
        @checked(old('same_as_mobile') || (isset($d) && $d->whatsapp_number === $d->mobile))>
      WhatsApp number is same as Mobile number
    </label>
    <label class="form-label">WhatsApp Number</label>
    <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $d->whatsapp_number ?? '') }}" class="form-input" maxlength="15">
  </div>

  <div>
    <label class="form-label">Email</label>
    <input type="email" name="email" value="{{ old('email', $d->email ?? '') }}" class="form-input">
  </div>

  <div>
    <label class="form-label">GST No.</label>
    <input type="text" name="gst_no" value="{{ old('gst_no', $d->gst_no ?? '') }}" class="form-input">
  </div>

  <div>
    <label class="form-label">PAN No.</label>
    <input type="text" name="pan_no" value="{{ old('pan_no', $d->pan_no ?? '') }}" class="form-input">
  </div>

  <div>
    <label class="form-label">Credit Limit</label>
    <input type="number" step="0.01" name="credit_limit" value="{{ old('credit_limit', $d->credit_limit ?? '') }}" class="form-input">
  </div>

  <div class="col-span-2">
    <label class="form-label">Payment Terms</label>
    <input type="text" name="payment_terms" value="{{ old('payment_terms', $d->payment_terms ?? '') }}" class="form-input">
  </div>

  <div>
    <label class="form-label">Country</label>
    <select name="country_id" id="country_id" class="form-select">
      <option value="">Select Country</option>
      @foreach($countries as $c)
        <option value="{{ $c->id }}" @selected(old('country_id', $d->country_id ?? '') == $c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <div>
    <label class="form-label">State</label>
    <select name="state_id" id="state_id" class="form-select">
      <option value="">Select State</option>
    </select>
  </div>

  <div>
    <label class="form-label">City</label>
    <select name="city_id" id="city_id" class="form-select">
      <option value="">Select City</option>
    </select>
  </div>

  <div>
    <label class="form-label">Pincode</label>
    <select name="pincode_id" id="pincode_id" class="form-select">
      <option value="">Select Pincode</option>
    </select>
  </div>

  <div class="col-span-2">
    <label class="form-label">Address</label>
    <textarea name="address" class="form-textarea" rows="2">{{ old('address', $d->address ?? '') }}</textarea>
  </div>

  <div>
    <label class="form-label">Latitude</label>
    <input type="text" name="latitude" value="{{ old('latitude', $d->latitude ?? '') }}" class="form-input">
  </div>

  <div>
    <label class="form-label">Longitude</label>
    <input type="text" name="longitude" value="{{ old('longitude', $d->longitude ?? '') }}" class="form-input">
  </div>
</div>

<div class="flex gap-3 pt-6">
  <button class="btn-primary">Save</button>
  <a href="{{ route('dealers.index') }}" class="btn-secondary">Cancel</a>
</div>

<script>
(function () {
  const clientTypeEl = document.getElementById('client_type');
  const parentWrap = document.getElementById('parent_dealer_wrap');
  const parentSelect = parentWrap.querySelector('select[name=parent_dealer_id]');

  function toggleParentDealer() {
    // parent_dealer_id is only relevant for Sub Dealer (3). For Existing/New it is forced to 0/null.
    if (clientTypeEl.value === '3') {
      parentWrap.style.display = 'block';
      parentSelect.setAttribute('required', 'required');
    } else {
      parentWrap.style.display = 'none';
      parentSelect.removeAttribute('required');
      parentSelect.value = '';
    }
  }
  clientTypeEl.addEventListener('change', toggleParentDealer);
  toggleParentDealer();

  // WhatsApp = Mobile checkbox
  const sameAsMobile = document.getElementById('same_as_mobile');
  const mobile = document.getElementById('mobile');
  const whatsapp = document.getElementById('whatsapp_number');

  function syncWhatsapp() {
    if (sameAsMobile.checked) {
      whatsapp.value = mobile.value;
      whatsapp.setAttribute('readonly', 'readonly');
    } else {
      whatsapp.removeAttribute('readonly');
    }
  }
  sameAsMobile.addEventListener('change', syncWhatsapp);
  mobile.addEventListener('input', function () { if (sameAsMobile.checked) whatsapp.value = mobile.value; });
  syncWhatsapp();

  // Cascading Country -> State -> City -> Pincode
  const countrySel = document.getElementById('country_id');
  const stateSel = document.getElementById('state_id');
  const citySel = document.getElementById('city_id');
  const pincodeSel = document.getElementById('pincode_id');

  const preselected = {
    state_id: "{{ old('state_id', $d->state_id ?? '') }}",
    city_id: "{{ old('city_id', $d->city_id ?? '') }}",
    pincode_id: "{{ old('pincode_id', $d->pincode_id ?? '') }}",
  };

  function loadStates(countryId, cb) {
    stateSel.innerHTML = '<option value="">Select State</option>';
    if (!countryId) return;
    fetch(`/ajax/states/${countryId}`).then(r => r.json()).then(data => {
      data.forEach(s => stateSel.append(new Option(s.name, s.id)));
      if (cb) cb();
    });
  }
  function loadCities(stateId, cb) {
    citySel.innerHTML = '<option value="">Select City</option>';
    if (!stateId) return;
    fetch(`/ajax/cities/${stateId}`).then(r => r.json()).then(data => {
      data.forEach(c => citySel.append(new Option(c.name, c.id)));
      if (cb) cb();
    });
  }
  function loadPincodes(cityId, cb) {
    pincodeSel.innerHTML = '<option value="">Select Pincode</option>';
    if (!cityId) return;
    fetch(`/ajax/pincodes/${cityId}`).then(r => r.json()).then(data => {
      data.forEach(p => pincodeSel.append(new Option(p.pincode, p.id)));
      if (cb) cb();
    });
  }

  countrySel.addEventListener('change', () => loadStates(countrySel.value));
  stateSel.addEventListener('change', () => loadCities(stateSel.value));
  citySel.addEventListener('change', () => loadPincodes(citySel.value));

  // preload chain for edit page
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
