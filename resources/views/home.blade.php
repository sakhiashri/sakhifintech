@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(Auth::user()->role_id == 2)
            <div class="col md-12">
                <div class="row">
                    <div class="col">
                        <div class="row text-secondary">Welcome,</div>
                        <div class="row fw-bold" style="font-size: 25px;">
                            {{ Auth::user()->name}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header dw-bold">
                                Saldo
                            </div>
                            <div class="card-body">
                                Rp. {{number_format($saldo)}}
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header dw-bold">
                                Jumlah Nasabah
                            </div>
                            <div class="card-body">
                                {{ $nasabah }}
                            </div>
                            <div class="card-footer">
                                <a href="" class="bg-color-black">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card">
                            <div class="card-header dw-bold">
                                Jumlah Transaksi
                            </div>
                            <div class="card-body">
                                {{ $transactions }}
                            </div>
                        </div>
                    </div>
                </div>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Nasabah</th>
                                <th>Permintaan Saldo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($request_topup as $key => $request)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$request->user->username}}</td>
                                <td>Rp. {{number_format($request->credit)}}</td>
                                <form action="{{ route('request_topup') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{ $request->id}}">
                                    <td><button type="submit" class="btn btn-primary">SETUJU</button></td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        @if(Auth::user()->role_id == 4)
        <div class="col-md-12">
            <div class="container mb-3">
                <div class="text-center">
                    <div class="row text-bg-success p-3">
                        <div class="col">
                            <div class="row d-flex justify-content-center text-warning" style="font-size: 50px">Welcome,</div>
                            <div class="row d-flex justify-content-center fw-bold" style="font-size: 25px;">
                                {{ Auth::user()->name}}
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col">
                            <div class="row">
                                <div class="col d-flex justify-content-start ">Saldo Anda: </div>
                            </div>
                            <div class="row"style="font-size:40px;">
                                <div class="col d-flex justify-content-start">Rp {{ number_format($saldo) }}</div>
                            </div>
                            <div class="col d-flex justify-content-start align-items-center">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet" viewBox="0 0 16 16">
                                    <path d="M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5V3zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a1.99 1.99 0 0 1-1-.268zM1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1z"/>
                                </svg> <span>Top Up</span>
                            </button>
            
                                <!-- Modal -->
                                <form action="{{ route('TopUpNow') }}" method="post">
                                    @csrf
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <input type="number" name="credit" value="10000" class="form-control" min="10000"   >
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Top Up Sekarang</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif
</div>
<div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header text-bg-danger fw-bold text-center">Products</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($products as $product)
                        <div class="col">
                            <form action="{{ route('addToCart') }}" method="post">
                                @csrf
                                <input type="hidden" value="{{ Auth::user()->id}}" name="user_id">
                                <input type="hidden" value="{{ $product->id}}" name="product_id">
                                <input type="hidden" value="{{ $product->price}}" name="price">
                                <div class="card">
                                    <div class="card-header">
                                        {{ $product->name }}
                                    </div>
                                    <div class="card-body">
                                        <img style="width: 150px; height:150px;" src="images/{{ $product->photo }}">
                                        <div>{{$product->desc}}</div>
                                        <div>Harga: {{ $product->price }}</div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <input type="number" name="quantity" id="quantity" class="form-control" value="0" min='0'>
                                                </div>
                                            </div>
                                            <div class="col-7">
                                                <div class="d-grip gap-2">
                                                    <button type="submit" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
                                                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
                                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                                        </svg> <span style="font-size: 12px;">Tambah</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header text-bg-primary fw-bold text-center">
                    Baskets
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($carts as $cart)
                        <li>{{ $cart->product->name }} | {{ $cart->quantity}} x Rp {{ number_format($cart->price) }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer">
                    Total Biaya: {{ $total_biaya }}
                    <form action="{{ route('payNow')}}" method="POST">
                        <div class="d-grip gap-2">
                            @csrf
                            <button type="submit" class="btn btn-success">Bayar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header">
                    Transactions History
                </div>
                <div class="card-body">
                    @foreach($transactions as $key => $transaction)
                    <div class="row mb-3">
                        <div class="col">
                            <div class="row">
                                <div class="col fw-bold">
                                    {{ $transaction[0]->order_code}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col text-secondary" style="font-size: 12px;">
                                    {{$transaction[0]->created_at}}
                                </div>
                            </div>
                        </div>
                        <div class="col d-flex justify-content-end align-items-center">
                            <a href="{{ route('download', ['order_code' => $transaction[0]->order_code]) }}" class="btn btn-success" target="blank">Download</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header text-center fw-bold text-bg-primary">
                    Mutasi Wallet
                </div>
                @foreach($mutasi as $data)
                <div class="card-body container">
                    <div class="row">
                        <div class="col-8">
                            <div class="row fw-bold">{{$data->description}} </div>
                            <div class="row text-secondary" style="font-size: 10px;">{{$data->created_at}}</div>
                        </div>
                        <div class="col-4">{{ $data->credit ? '+ Rp '.number_format($data->credit):'' }} {{ $data->debit ? '- Rp '.number_format($data->debit):''}}
                        <span class="badge text-bg-warning">{{$data->status == 'proses' ? 'PROSES' : ''}}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
@endsection