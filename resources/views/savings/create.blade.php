{{-- resources/views/savings/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Savings Account</h2>

    <form action="{{ route('savings.store') }}" method="POST">
        @csrf

        {{-- Member --}}
        <div class="mb-3">
            <label for="member_id" class="form-label">Member</label>
            <select name="member_id" class="form-control" required>
                <option value="">Select Member</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Initial Deposit --}}
        <div class="mb-3">
            <label for="amount" class="form-label">Initial Deposit</label>
            <input type="number" name="amount" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">
            Create Savings
        </button>
    </form>
</div>
@endsection