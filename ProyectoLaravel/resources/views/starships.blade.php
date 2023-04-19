@extends('layouts.app')

@section('title', 'Naves')

@section('content')
    <div class="container">
        <h1>Naves</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Modelo</th>
                    <th>Fabricante</th>
                    <th>Costo en créditos</th>
                    <th>Longitud</th>
                    <th>Velocidad atmosférica máxima</th>
                    <th>Equipo requerido</th>
                    <th>Pasajeros</th>
                    <th>Capacidad de carga</th>
                    <th>Consumibles</th>
                    <th>Clasificación del navío</th>
                    <th>Velocidad en el hiperespacio</th>
                    <th>MGLT</th>
                    <th>Pilotos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($starships as $starship)
                    <tr>
                        <td>{{ $starship->name }}</td>
                        <td>{{ $starship->model }}</td>
                        <td>{{ $starship->manufacturer }}</td>
                        <td>{{ $starship->cost_in_credits }}</td>
                        <td>{{ $starship->length }}</td>
                        <td>{{ $starship->max_atmosphering_speed }}</td>
                        <td>{{ $starship->crew }}</td>
                        <td>{{ $starship->passengers }}</td>
                        <td>{{ $starship->cargo_capacity }}</td>
                        <td>{{ $starship->consumables }}</td>
                        <td>{{ $starship->starship_class }}</td>
                        <td>{{ $starship->hyperdrive_rating }}</td>
                        <td>{{ $starship->MGLT }}</td>
                        <td>
                        @forelse ($starship->pilots as $pilot)
                            {{ $pilot->name }}@if (!$loop->last), @endif
                        @empty
                            Desconocido
                        @endforelse

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
