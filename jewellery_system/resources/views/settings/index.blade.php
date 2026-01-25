@extends('layouts.app')

@section('header', 'Settings')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Daily Rates & Configuration</div>
            <div class="card-body">
                <form action="{{ route('settings.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Gold Rate (24K) per gram</label>
                        <input type="number" step="0.01" class="form-control" name="gold_rate_24k" value="{{ $settings['gold_rate_24k'] ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gold Rate (22K) per gram</label>
                        <input type="number" step="0.01" class="form-control" name="gold_rate_22k" value="{{ $settings['gold_rate_22k'] ?? '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Silver Rate per gram</label>
                        <input type="number" step="0.01" class="form-control" name="silver_rate" value="{{ $settings['silver_rate'] ?? '' }}" required>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label class="form-label">Shop Name</label>
                        <input type="text" class="form-control" name="shop_name" value="{{ $settings['shop_name'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="shop_address">{{ $settings['shop_address'] ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
