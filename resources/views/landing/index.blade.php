@extends('layouts.landing')

@section('title', 'FIXMATE — Foto Masalahnya, Temukan Solusinya, Hubungi Teknisi')
@section('description', 'FIXMATE menggabungkan analisis visual AI dan sistem pakar untuk menemukan kemungkinan kerusakan perangkatmu, lalu memandu perbaikan atau menghubungkanmu dengan teknisi terverifikasi.')
@section('og_title', 'FIXMATE — Diagnose. Repair. Connect.')
@section('og_description', 'Diagnosis kerusakan perangkat berbasis foto. Sistem pakar transparan. Teknisi terverifikasi.')

@section('content')

<x-landing.navbar />

<main id="main-content">

    <x-landing.hero />

    <x-landing.bento :devices="$devices" />

    <x-landing.features :features="$features" />

    <x-landing.how-it-works />

    <x-landing.safety />

    <x-landing.technicians :technicians="$technicians" />

    <x-landing.stats :stats="$stats" />

    <x-landing.cta />

</main>

<x-landing.footer />

@endsection
