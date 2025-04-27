<table>
    <thead>
        <tr>
            <th style="font-size:16px" colspan="9">Standards Report</th>
        </tr>
        <tr>
            <th colspan="9"></th>
        </tr>
        <tr>
            <th><b>ID</b></th><th><b>Technical Committee</b></th>
            <th><b>Sub Committee</b></th>
            <th><b>Standard</b></th>
            <th><b>Standard Code</b></th>
            <th><b>Status</b></th>
            <th><b>Date</b></th>
            <th><b>Purchased By</b></th>
            <th><b>Standard Amount</b></th>
          
        </tr>
    </thead>
    <tbody>
        @forelse($reportdatas as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $data->technical_committee }}</td>
            <td>{{ $data->sub_committee }}</td>
            <td>{{ $data->standards }}</td>
            <td>{{ $data->st_code }}</td>
            <td>{{ $data->status }}</td>
            <td>{{ $data->created_at }}</td>
            <td>{{ $data->name }}</td>
            @if($data->standards_type == 1)
            <td>Nu.{{ $data->price }}</td>
            @else
            <td>USD {{ $data->otherprice }}</td>
            @endif
        </tr>
        @empty
        @endforelse
    </tbody>
</table>