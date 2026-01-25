@extends('layouts.app')

@section('header', 'Reports')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">Sales Report</div>
            <div class="card-body">
                <form action="{{ route('reports.generate') }}" method="GET">
                    <input type="hidden" name="type" value="sales">
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required value="{{ date('Y-m-01') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" required value="{{ date('Y-m-d') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                    <!-- In real app, offer Export PDF/Excel here -->
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">Stock Report</div>
            <div class="card-body">
                <form action="{{ route('reports.generate') }}" method="GET">
                    <input type="hidden" name="type" value="stock">
                    <p>Generate current stock inventory report.</p>
                    <button type="submit" class="btn btn-secondary">View Stock Report</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
