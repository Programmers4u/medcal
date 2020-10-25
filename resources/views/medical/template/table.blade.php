<p>
    {!! Button::primary(trans('manager.humanresource.btn.create'))
    ->withIcon(Icon::plus())
    ->asLinkTo(route('medical.template.create', [$business]) ) !!}
</p>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Typ</th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Zarządzaj</th>
            </tr>
        </thead>
        <tbody>
            @foreach($templates as $template)
            <tr>
                <td>{{ $template_type[$template['type']] }}</td>
                <td>{{ $template['name'] }}</td>
                <td>{{ $template['description'] }}</td>
                <td>
                        {!! Button::normal()
                            ->withIcon(Icon::edit())
                            ->asLinkTo(route('medical.template.edit', [$business, $template['id']]) ) !!}
                            <a class="btn btn-danger tooltipstered" href="javascript:destroy({{$template['id']}})"><span class="glyphicon glyphicon-trash"></span></a>

                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
        </tfoot>
    </table>


</div>

@push('footer_scripts')
<script>
// $(document).ready( ()=>{
//     $('#example').DataTable();
// });
</script>
@endpush