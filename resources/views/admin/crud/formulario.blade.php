<div class="row">
    <div class="form-group col-md-6">
        <label for="nombre" class="control-label">{{'Nombre'}}</label>
        <input type="text" class="form-control {{$errors->has('nombre')?'is-invalid':''}}" name="nombre" id="nombre" value="{{isset($medicamentos->nombre)?$medicamentos->nombre:old('nombre')}}">
        {!!$errors->first('nombre','<div class="invalid-feedback">:message</div>')!!}
        <div class="invalid-feedback"></div>

    </div>

    <div class="form-group col-md-6">
        <label for="fabricante" class="control-label">{{'Fabricante'}}</label>
        <input type="text" class="form-control {{$errors->has('fabricante')?'is-invalid':''}}" name="fabricante" id="fabricante" value="{{isset($medicamentos->fabricante)?$medicamentos->fabricante:old('fabricante')}}">
        {!!$errors->first('fabricante','<div class="invalid-feedback">:message</div>')!!}
    </div>
</div>


<div class="form-group">
    <label for="descripcion" class="control-label">{{'Descripción'}}</label>
    <input type="text" class="form-control {{$errors->has('descripcion')?'is-invalid':''}}" name="descripcion" id="descripcion" value="{{isset($medicamentos->descripcion)?$medicamentos->descripcion:old('descripcion')}}">
    {!!$errors->first('descripcion','<div class="invalid-feedback">:message</div>')!!}
    <div class="invalid-feedback"></div>
</div>

<div class="row">
    <div class="form-group col-md-4">
        <label for="pais_fabricacion" class="control-label">{{'País de Fabricación'}}</label>
        <input type="text" class="form-control {{$errors->has('pais_fabricacion')?'is-invalid':''}}" name="pais_fabricacion" id="pais_fabricacion" value="{{isset($medicamentos->pais_fabricacion)?$medicamentos->pais_fabricacion:old('pais_fabricacion')}}">
        {!!$errors->first('pais_fabricacion','<div class="invalid-feedback">:message</div>')!!}
    </div>

    <div class="form-group col-md-4">
        <label for="categoria" class="control-label">{{'Categoría'}}</label>
        <select name="categoria" id="categoria" class="form-control {{$errors->has('categoria') ? 'is-invalid' : ''}}">
            <option value="">Seleccione una categoría</option>
            <option value="Analgésico" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Analgésico') ? 'selected' : '' }}>Analgésico</option>
            <option value="Antiácido" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Antiácido') ? 'selected' : '' }}>Antiácido y Antiulceroso</option>
            <option value="Antialérgico" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Antialérgico') ? 'selected' : '' }}>Antialérgico</option>
            <option value="Antidiarreico" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Antidiarreico') ? 'selected' : '' }}>Antidiarreico</option>
            <option value="Antiinfeccioso" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Antiinfeccioso') ? 'selected' : '' }}>Antiinfeccioso</option>
            <option value="Antiinflamatorio" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Antiinflamatorio') ? 'selected' : '' }}>Antiinflamatorio</option>
            <option value="Antidepresivo" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Antidepresivo') ? 'selected' : '' }}>Antidepresivo</option>
            <option value="Antipirético" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Antipirético') ? 'selected' : '' }}>Antipirético</option>
            <option value="Antitusivo" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Antitusivo') ? 'selected' : '' }}>Antitusivo</option>
            <option value="Laxante" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Laxante') ? 'selected' : '' }}>Laxante</option>
            <option value="Mucolítico" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Mucolítico') ? 'selected' : '' }}>Mucolítico</option>
            <option value="Otro" {{ (isset($medicamentos->categoria) && $medicamentos->categoria == 'Otro') ? 'selected' : '' }}>Otro</option>
        </select>
        {!! $errors->first('categoria', '<div class="invalid-feedback">:message</div>') !!}
    </div>

    <div class="form-group col-md-4">
        <label for="precio" class="control-label">{{'Precio'}}</label>
        <input type="text" class="form-control {{$errors->has('precio')?'is-invalid':''}}" name="precio" id="precio" value="{{isset($medicamentos->precio)?$medicamentos->precio:old('precio')}}">
        {!!$errors->first('precio','<div class="invalid-feedback">:message</div>')!!}
        <div class="invalid-feedback"></div>
    </div>

</div>
<div class="form-group" style="display: none;">
    <label for="id_farmacia" class="control-label">{{'id_farmacia'}}</label>
    <input type="text" class="form-control {{$errors->has('id_farmacia')?'is-invalid':''}}" name="id_farmacia" id="id_farmacia" value="{{ Auth::user()->farmacias->first()->id_farmacia ?? '' }}">
</div>


<div class="form-group col-md-6">
    <label class="control-label" for="Foto">{{'Foto'}}</label>
    @if(isset($medicamentos->Foto))
    <br>
    <img src="{{asset('storage').'/'.$medicamentos->Foto}}" width="200px" class="img-thumbnail img-fluid">
    <br>
    @endif
    <input class="form-control {{$errors->has('Foto')?'is-invalid':''}}" type="file" name="Foto" id="Foto">
    {!!$errors->first('Foto','<div class="invalid-feedback">:message</div>')!!}
</div>

<div class="d-grid gap-2 col-6 mx-auto">
    <input type="submit" class="btn btn-success" value="{{$Modo=='crear' ? 'Agregar':'Modificar'}}">
    <a class="btn btn-secondary" href="{{url('admin/crud/index')}}">Regresar</a>
</div>

</form>

<link rel="stylesheet" href="{{ asset('/build/assets/admin/admin.css') }}">
