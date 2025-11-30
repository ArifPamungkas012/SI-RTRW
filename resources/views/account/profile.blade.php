@extends('layouts.app')

@section('content')
    <h1>Profil Saya</h1>
    <p>Nama: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Role: {{ $user->role }}</p>
    @if($user->warga)
        <p>Alamat: {{ $user->warga->alamat ?? '-' }}</p>
    @endif
@endsection