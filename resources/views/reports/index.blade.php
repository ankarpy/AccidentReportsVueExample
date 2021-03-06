@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">

                    <div class="d-flex align-items-center">
                        <h2 class="mb-0">{{ __('Reports') }}</h2>
                        <div class="ml-auto">
                            <a href="{{ route('reports.create') }}" class="btn btn-outline-secondary">{{ __('Create Report') }}</a>
                        </div>
                    </div>


                </div>

                <div class="card-body">
                    @include('layouts/_messages')


                    <reports></reports>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
