{{-- DEPOSIT --}}
<div class="modal fade" id="depositModal">
    <div class="modal-dialog">
        <form class="modal-content wallet-form" method="POST" action="{{ route('wallet.deposit') }}">
            @csrf

            <div class="modal-header">
                <h5>Deposit</h5>
            </div>

            <div class="modal-body">
                <input type="number" name="amount" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success w-100">Confirm</button>
            </div>
        </form>
    </div>
</div>

{{-- WITHDRAW --}}
<div class="modal fade" id="withdrawModal">
    <div class="modal-dialog">
        <form class="modal-content wallet-form" method="POST" action="{{ route('wallet.withdraw') }}">
            @csrf

            <div class="modal-header">
                <h5>Withdraw</h5>
            </div>

            <div class="modal-body">
                <input type="number" name="amount" class="form-control" required>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger w-100">Confirm</button>
            </div>
        </form>
    </div>
</div>