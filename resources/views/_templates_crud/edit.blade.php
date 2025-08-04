@extends('_templates_crud.layout')

@section('title', 'Editar Item')

@section('content')
    <form action="{{-- ROTA_ATUALIZAR --}}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="campo1" class="form-label">Nome do Campo 1</label>
            <input type="text" class="form-control" id="campo1" name="campo1" value="{{ old('campo1', $item->campo1) }}">
            @error('campo1') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="campo2" class="form-label">Nome do Campo 2</label>
            <input type="text" class="form-control" id="campo2" name="campo2" value="{{ old('campo2', $item->campo2) }}">
            @error('campo2') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
@endsection
