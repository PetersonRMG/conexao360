@extends('layout.network')

@section('content')

@include('site.network.navbar')

<div class="network-page">

    <aside class="network-left">

        @include('site.network.profile-card')

    </aside>

    <main class="network-feed">

        @include('site.network.create-post')

        @include('site.network.feed')

    </main>

    <aside class="network-right">

        @include('site.network.video-widget')

        @include('site.network.event-widget')

        @include('site.network.connection-widget')

    </aside>

</div>

@endsection