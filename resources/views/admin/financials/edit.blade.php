<x-app-layout>
    <h1>Edit Financial Record</h1>
    <form action="{{ route('financials.update', $financial->financial_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="bond_id" class="form-label">Bond ID</label>
            <input type="text" class="form-control" id="bond_id" name="bond_id" value="{{ $financial->bond_id }}" required>
        </div>
        <div class="mb-3">
            <label for="financial_year" class="form-label">Financial Year</label>
            <input type="text" class="form-control" id="financial_year" name="financial_year" value="{{ $financial->financial_year }}" required>
        </div>
        <div class="mb-3">
            <label for="revenue" class="form-label">Revenue</label>
            <input type="number" step="0.01" class="form-control" id="revenue" name="revenue" value="{{ $financial->revenue }}" required>
        </div>
        <div class="mb-3">
            <label for="expenses" class="form-label">Expenses</label>
            <input type="number" step="0.01" class="form-control" id="expenses" name="expenses" value="{{ $financial->expenses }}" required>
        </div>
        <div class="mb-3">
            <label for="net_income" class="form-label">Net Income</label>
            <input type="number" step="0.01" class="form-control" id="net_income" name="net_income" value="{{ $financial->net_income }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Financial Record</button>
    </form>
</x-app-layout>