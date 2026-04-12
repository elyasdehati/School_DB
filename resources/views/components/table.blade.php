<div class="table-responsive">
    <table id="datatable" class="table table-bordered nowrap">
        <thead>
            <tr class="text-center">
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach($rows as $row)
                <tr class="text-center">
                    @foreach($row as $cell)
                        <td>{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>