@extends('_templates_crud.layout') {{-- ADAPTE O CAMINHO SE NECESSÁRIO --}}

@section('title', 'Lista de Itens')

@section('content')
    <a href="{{-- ROTA_CRIAR --}}" class="btn btn-primary mb-3">Adicionar Novo Item</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Campo 1</th>
            <th>Campo 2</th>
            <th width="150px">Ações</th>
        </tr>
        </thead>
        <tbody>
        @forelse($itens as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->campo1 }}</td>
                <td>{{ $item->campo2 }}</td>
                <td>
                    <a href="{{-- ROTA_EDITAR --}}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{-- ROTA_DELETAR --}}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Deletar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Nenhum item encontrado.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
