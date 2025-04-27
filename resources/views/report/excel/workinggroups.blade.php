<table>
    <thead>
        <tr>
            <th style="font-size:16px" colspan="9">Working Group Report</th>
        </tr>
        <tr>
            <th colspan="9"></th>
        </tr>
        <tr>
            <th><b>ID</b></th><th><b>Technical Committee</b></th>
            <th><b>Sub Committee</b></th>
            <th><b>Standard</b></th>
            <th><b>Standard Code</b></th>
            <th><b>Working Group</b></th>
            <th><b>Working Code</b></th>
        </tr>
    </thead>
    <tbody>
        @forelse($datas as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->subcommittee->technicalcommittee->technical_committee }}</td>
            <td>{{ $data->subcommittee->sub_committee }}</td>
            <td>{{ $data->standards }}</td>
            <td>{{ $data->code }}</td>
            <td>{{ $data->workinggroup->working_group }}</td>
            <td>{{ $data->workinggroup->code }}</td>
        </tr>
        @empty
        @endforelse
    </tbody>
</table>