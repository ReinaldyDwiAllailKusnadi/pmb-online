@props(['title' => null])

@php
    $pageTitle = $title ?? config('app.name', 'PMB Online');
@endphp

@include('layouts.app', ['title' => $pageTitle, 'slot' => $slot])