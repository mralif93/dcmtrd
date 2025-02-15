<x-app-layout>
    <h1>Financial Record Details</h1>
    <p><strong>ID:</strong> {{ $financial->financial_id }}</p>
    <p><strong>Bond ID:</strong> {{ $financial->bond_id }}</p>
    <p><strong>Financial Year:</strong> {{ $financial->financial_year }}</p>
    <p><strong>Revenue:</strong> {{ $financial->revenue }}</p>
    <p><strong>Expenses:</strong> {{ $financial->expenses }}</p>
    <p><strong>Net Income:</strong> {{ $financial->net_income }}</p>
    <a href="{{ route('financials.edit', $financial->financial_id) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('financials.destroy', $financial->financial_id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <a href="{{ route('financials.index') }}" class="btn btn-secondary">Back to List</a>
</x-app-layout>