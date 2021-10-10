@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0">{{ __('Create Report') }}</h2>
                            <div class="ml-auto">
                                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">{{ __('Back') }}</a>
                            </div>
                        </div>

                    </div>

                    <div class="card-body report">
                        @if(!isset($report->id))
                        <form action="{{ route('reports.store') }}" method="post">
                            @include ("reports._form", [])
                        </form>
                        @else
                        <form action="{{ route('reports.update', $report->id) }}" method="post">
                            {{ method_field('PUT') }}
                            @include ("reports._form", [])
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
