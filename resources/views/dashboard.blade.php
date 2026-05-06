@extends('layouts.app')

@section('title', 'Dashboard - VYS International')

@section('content')
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-desktop"></i></div>
                    <span>Dashboard</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card rounded-0">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-mb-4 col-lg-4 col-xl-4">
                        <div class="row no-gutters h-100">
                            <div class="col">
                                <div class="card-body p-0 p-2 text-right">
                                    <div class="progress" style="height: 3px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 100%;"
                                            aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!doctype html>
    <html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/dist/main.css" rel="stylesheet">
    </head>



    </html>
@endsection