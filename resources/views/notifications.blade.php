@extends('layout.maintemplate')
@section('content')
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-3">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0"></h6>
                    </div>
            
                    <div class="card-body">
                        <div class="notification-list">
    <h2>Notifications</h2>

    @if ($notifications->isEmpty())
        <p>No notifications found.</p>
    @else
        <ul>
            @foreach ($notifications as $notification)
                <li>
                    <span class="">{{ $notification->message_title }}</span>
                    <a href="{{ $notification->url }}">{{ $notification->message_notify }}</a>
                    <span class="timestamp">{{ $notification->created_at->diffForHumans(now()) }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>


        </div>
    </div>
    </div>
    </div>
    </div>
</div>
    <script src="{!! asset('/assets/bundles/libscripts.bundle.js') !!}"></script>
@endsection