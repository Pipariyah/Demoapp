@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                
                    <div class="text-center">
                        <a class="text-light btn btn-primary" href="http://localhost/demoapp/public/datatables">Datatables</a> <br>
                        The Datatables is table of user data and provide functionality of View,Add,Edit and Delete the Data
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
