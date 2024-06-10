<table class="table all-db-table align-middle w-100">
    @if(count($transactions)>0)
        @foreach($transactions as $transaction)
            <tr>
                <td>
                    @if ($transaction->date_time)
                        {{ date('d M Y', strtotime($transaction->date_time)); }}<br>{{ date('h: i a', strtotime($transaction->date_time)) }}<br>
                        @ {{ $transaction->location_name }}
                    @else
                        N/A<br>N/A
                    @endif
                </td>
                <td>
                    ${{ number_format($transaction->redeemed_value, 2) }} {{ $transaction->redeemed_value_type }}<br>
                    @if($transaction->redeemed_by == null)
                    Invoice #INV{{ $transaction->invoice_number }}<br>
                    @else
                    Edited in {{ $transaction->redeemed_by }}<br>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <div>No transaction found</div>
    @endif
</table>