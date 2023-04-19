@extends('layouts.app')
<!DOCTYPE html>
<html lang="en" ng-app="starshipPilotsApp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naves y pilotos</title>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="{{ asset('css/starshipPilot.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />

</head>
<body>

    <h1>Naves y pilotos</h1>

    <div class="actions">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('pilots.destroyByName') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este piloto?');">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <label for="name">Nombre del piloto a eliminar:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
                @if (session('success'))
                <div class="alert alert-removed">
                    {{ session('success') }}
                </div>
                @endif
            </div>
            <div class="col-md-6">
                <form action="{{ route('starships.linkPilot') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="pilot_id">Selecciona un piloto:</label>
                        <select class="form-control" id="pilot_id" name="pilot_id" required>
                            @foreach ($pilots as $pilot)
                                <option value="{{ $pilot->id }}">{{ $pilot->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="starship_id">Selecciona una nave:</label>
                        <select class="form-control" id="starship_id" name="starship_id" required>
                            @foreach ($starships as $starship)
                                <option value="{{ $starship->id }}">{{ $starship->name }}</option>
                            @endforeach
                            @if (session('success'))
                            <div class="alert alert-removed">
                                {{ session('success') }}
                            </div>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Vincular piloto a nave</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container" ng-controller="StarshipPilotController">

        <br>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre de la nave</th>
                    <th>Nombre del piloto</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($starship_pilot as $starship_name => $pilots)
                        <tr>
                            <td>{{ $starship_name }}</td>
                            <td>
                                @foreach ($pilots as $pilot)
                                    {{ $pilot->pilot_name }}@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            </tr>
                @endforeach
            </tbody>
    </table>

</div>

<!--Nombres de pilotos, autocompletar campo de texto-->
<div id="pilot-names" style="display: none;">
    @foreach ($pilots as $pilot)
        <span data-name="{{ $pilot->pilot_name }}"></span>
    @endforeach
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const alertRemoved = document.querySelector('.alert-removed');
        if (alertRemoved) {
            setTimeout(() => {
                alertRemoved.classList.add('fade-out');
                setTimeout(() => {
                    alertRemoved.remove();
                }, 500);
            }, 2000);
        }
    });
</script>
</body>
</html>
