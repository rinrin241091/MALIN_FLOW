@extends('backend.layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">{{ __('messages.dashboard') }}</li>
        </ol>
    </nav>

    <!-- Main content -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('messages.smart_document_management') }}</h3>
                </div>
                <div class="card-body">
                    <p>{{ __('messages.smart_document_management_desc') }}</p>
                    
                    <!-- Featured Functions -->
                    <h4 class="mt-4">{{ __('messages.featured_functions') }}</h4>
                    <div class="row mt-3">
                        <!-- Category Management -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fas fa-list text-primary"></i>
                                        {{ __('messages.category_management') }}
                                    </h5>
                                    <p class="card-text">{{ __('messages.category_management_desc') }}</p>
                                    <a href="{{ route('categories.user-list') }}" class="btn btn-primary">
                                        {{ __('messages.view') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 