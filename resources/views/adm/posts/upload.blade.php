@extends('layouts.adm')
@section('content')
    <div class="container" style="padding: 25px 50px 25px 50px;">
        <h2>{{$formTitle}}</h2>
        <form method="POST" enctype="multipart/form-data" action="{{$formAction}}">
            @csrf
            <!-- Upload -->
            <div class="form-group">
                <label for="inputFile">Arquivo:</label>
                <input id="inputFile" type="file" name="uploadFile" class="form-control">
            </div>
            <!-- Description -->
            @if(isset($isBanner))
                <div class="form-group">
                    <label for="inputDate">Mostrar até:</label>
                    <input id="inputDate" type="date" name="limitDate" class="form-control"
                        @isset($bannerLimit)value="{{$bannerLimit}}"@endisset>
                </div>
            @else
                <div class="form-group">
                    <label for="inputDescr">Descrição:</label>
                    <input id="inputDescr" type="text" name="description" class="form-control">
                </div>
            @endif
            <!-- Submit -->
            <div class="form-group" style="float: right;">
                <button id="btnSubmit" type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
@endsection