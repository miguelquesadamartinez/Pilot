@extends("layouts.app")

@section('content')

<div class="card shadow mb-4">
            <div class="card-header">
                {{ __('Ecommerce to Sage File Generator') }}
            </div>
            <div class="card-body text-center">

                <a href="/file-generator/generate-sage-file" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                    <span class="text">{{ __('Generate Sage File') }}</span>
                </a>

            </div>
        </div>

@endsection