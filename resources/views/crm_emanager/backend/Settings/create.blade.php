@extends('crm_emanager.backend.layout.master')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <div class="card border-0 shadow">

                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">Site Settings</h5>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')


                            {{-- Site Name --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Site Name
                                </label>

                                <input type="text" name="site_name" class="form-control"
                                    value="{{ old('site_name', $setting?->site_name) }}" placeholder="Enter Site Name">
                            </div>

                            {{-- Site Logo --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Logo Type</label>

                                <select name="logo_type" class="form-control">
                                    <option value="">Select One</option>
                                    <option value="icon" {{ ($setting->logo_type ?? '') == 'icon' ? 'selected' : '' }}>
                                        Icon
                                    </option>

                                    <option value="wordmark"
                                        {{ ($setting->logo_type ?? '') == 'wordmark' ? 'selected' : '' }}>
                                        Wordmark
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Site Logo
                                </label>

                                <input type="file" name="logo" class="form-control" accept="image/*">

                                @if ($setting?->site_logo)
                                    <div class="mt-3">
                                        <p class="mb-2">Current Logo:</p>

                                        <img src="{{ asset('storage/' . $setting->site_logo) }}" width="120"
                                            class="img-thumbnail" alt="Site Logo">
                                    </div>
                                @endif
                            </div>

                            {{-- Contact Email --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Contact Email
                                </label>

                                <input type="email" name="contact_email" class="form-control"
                                    value="{{ old('contact_email', $setting?->contact_email) }}"
                                    placeholder="Enter Contact Email">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Update Settings
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
