@extends('layouts.app')

@section('header', 'New Sale')

@section('content')
<form action="{{ route('sales.store') }}" method="POST" id="saleForm">
@csrf
<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">Items</div>
            <div class="card-body">
                <table class="table table-bordered" id="itemsTable">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Rate (Price)</th>
                            <th>Qty</th>
                            <th>Making Charges</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Items will be added here via JS -->
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#productModal">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Billing Details</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Customer</label>
                    <select name="customer_id" class="form-select" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->phone }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-select">
                        <option>Cash</option>
                        <option>Card</option>
                        <option>UPI</option>
                        <option>Bank Transfer</option>
                    </select>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span id="displaySubtotal">0.00</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Tax (GST):</span>
                    <span id="displayTax">0.00</span>
                </div>
                <div class="d-flex justify-content-between fw-bold mt-2 fs-5">
                    <span>Total:</span>
                    <span id="displayTotal">0.00</span>
                </div>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-success">Complete Sale</button>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">Current Rates</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between"><span>Gold 24K</span> <span>₹{{ $goldRate24k }}/g</span></li>
                <li class="list-group-item d-flex justify-content-between"><span>Gold 22K</span> <span>₹{{ $goldRate22k }}/g</span></li>
                <li class="list-group-item d-flex justify-content-between"><span>Silver</span> <span>₹{{ $silverRate }}/g</span></li>
            </ul>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="searchProduct" class="form-control mb-3" placeholder="Search product...">
                <div class="list-group" id="productList">
                    @foreach($products as $p)
                    <button type="button" class="list-group-item list-group-item-action product-item" 
                            data-id="{{ $p->id }}" 
                            data-name="{{ $p->name }}" 
                            data-price="{{ $p->price }}" 
                            data-stock="{{ $p->stock_quantity }}"
                            data-mc="{{ $p->making_charges }}"
                            data-gst="{{ $p->gst_percentage }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $p->name }}</h6>
                            <small>Stock: {{ $p->stock_quantity }}</small>
                        </div>
                        <p class="mb-1">Price: ₹{{ $p->price }} | MC: ₹{{ $p->making_charges }}</p>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</form>

@push('scripts')
<script>
    let items = [];
    
    document.querySelectorAll('.product-item').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);
            const stock = parseInt(this.dataset.stock);
            const mc = parseFloat(this.dataset.mc);
            const gst = parseFloat(this.dataset.gst);
            
            addItem(id, name, price, stock, mc, gst);
            const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
            modal.hide();
        });
    });

    function addItem(id, name, price, stock, mc, gst) {
        // Simple add, no checks for duplicate for brevity, assuming new line for each
        const index = items.length;
        items.push({ id, name, price, stock, mc, gst, qty: 1 });
        renderTable();
    }

    function renderTable() {
        const tbody = document.querySelector('#itemsTable tbody');
        tbody.innerHTML = '';
        let subtotal = 0;
        let taxTotal = 0;

        items.forEach((item, index) => {
            const rowTotal = (item.price * item.qty) + item.mc;
            const itemTax = (rowTotal * item.gst) / 100;
            const finalTotal = rowTotal + itemTax;
            
            subtotal += rowTotal;
            taxTotal += itemTax;

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${item.name} <input type="hidden" name="products[${index}][product_id]" value="${item.id}"></td>
                <td>${item.stock}</td>
                <td><input type="number" step="0.01" class="form-control form-control-sm" name="products[${index}][price]" value="${item.price}" onchange="updateItem(${index}, 'price', this.value)"></td>
                <td><input type="number" min="1" max="${item.stock}" class="form-control form-control-sm" name="products[${index}][quantity]" value="${item.qty}" onchange="updateItem(${index}, 'qty', this.value)"></td>
                <td><input type="number" step="0.01" class="form-control form-control-sm" name="products[${index}][making_charges]" value="${item.mc}" onchange="updateItem(${index}, 'mc', this.value)"></td>
                <td>${finalTotal.toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${index})"><i class="fas fa-trash"></i></button></td>
            `;
            tbody.appendChild(tr);
        });

        document.getElementById('displaySubtotal').textContent = subtotal.toFixed(2);
        document.getElementById('displayTax').textContent = taxTotal.toFixed(2);
        document.getElementById('displayTotal').textContent = (subtotal + taxTotal).toFixed(2);
    }

    window.updateItem = function(index, field, value) {
        items[index][field] = parseFloat(value);
        renderTable();
    }

    window.removeItem = function(index) {
        items.splice(index, 1);
        renderTable();
    }
    
    // Search filter
    document.getElementById('searchProduct').addEventListener('keyup', function() {
        const val = this.value.toLowerCase();
        document.querySelectorAll('.product-item').forEach(el => {
            el.style.display = el.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection
