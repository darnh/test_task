@extends('layouts.app')


@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Tenders list</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tender_id</th>
                        <th scope="col">Description</th>
                        <th scope="col">Amount UAH</th>
                        <th scope="col">Date Modified</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tenders as $tender)
                        <tr>
                            <th scope="row">{{ $tender->id }}</th>
                            <td>{{ $tender->tender_id }}</td>
                            <td>{{ $tender->description }}</td>
                            <td>{{ format_number($tender->amount) }}</td>
                            <td>{{ $tender->date_modified }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="text-right mt-3">
                    <p class="font-weight-bold">
                        Total amount: {{ format_number($tenders->sum('amount')) }} UAH
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
