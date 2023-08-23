<style>
    table {
       border-collapse: collapse;
       width: 100%;
     }

     th, td {
       border: 1px solid #ccc;
       padding: 8px;
       text-align: left;

     }

     th {
       background-color: #f2f2f2;
       font-weight: bold;
     }
     </style>

<!DOCTYPE html>
<html>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>

    <table class="table table-bordered">
        <tr><th>Campaign</th></tr>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Budget</th>
            <th>Status</th>
            <th>Expected Revenue</th>
            <th>Actual Revenue</th>

        </tr>

        <tr>
            <td>{{ $campaign->name }}</td>
            <td>{{ $campaign->description }}</td>
            <td>{{ $campaign->start_date }}</td>
            <td>{{ $campaign->end_date }}</td>
            <td>{{ $campaign->budget }}</td>
            <td>{{ $campaign->status }}</td>
            <td>{{ $campaign->expected_revenue }}</td>
            <td>{{ $campaign->actual_revenue }}</td>
        </tr>

    </table>
    <br />
    @if(isset($SM))

    <table class="table table-bordered">
    <tr><th>Social Media</th></tr>
        <tr>
            <th>Blogger</th>
            <th>Type</th>
            <th>Way</th>
            <th>Cost</th>
            <th>Expected Revenue</th>
            <th>Actual Revenue</th>
        </tr>
        @foreach($SM as $socialmedia)
        <tr>
            <td>{{ $socialmedia->blogger }}</td>
            <td>{{ $socialmedia->type }}</td>
            <td>{{ $socialmedia->way }}</td>
            <td>{{ $socialmedia->cost }}</td>
            <td>{{ $socialmedia->expected_revenue }}</td>
            <td>{{ $socialmedia->actual_revenue }}</td>
        </tr>
        @endforeach
    </table>

    @endif
    <br />

    @if(isset($TV))

    <table class="table table-bordered">
    <tr><th>TV</th></tr>
        <tr>
            <th>Channel</th>
            <th>Time</th>
            <th>Cost</th>
            <th>Advertising Period</th>
            <th>Expected Revenue</th>
            <th>Actual Revenue</th>
        </tr>
        @foreach($TV as $tvs)
        <tr>
            <td>{{ $tvs->channel }}</td>
            <td>{{ $tvs->time }}</td>
            <td>{{ $tvs->cost }}</td>
            <td>{{ $tvs->advertising_period }}</td>
            <td>{{ $tvs->expected_revenue }}</td>
            <td>{{ $tvs->actual_revenue }}</td>
        </tr>
        @endforeach
    </table>

    @endif
    <br />

    @if(isset($EV))

    <table class="table table-bordered">
    <tr><th>Event</th></tr>
        <tr>
            <th>Name</th>
            <th>Place</th>
            <th>Description</th>
            <th>Type</th>
            <th>Cost</th>
            <th>Expected Revenue</th>
            <th>Actual Revenue</th>
        </tr>
        @foreach($EV as $event)
        <tr>
            <td>{{ $event->name }}</td>
            <td>{{ $event->place }}</td>
            <td>{{ $event->description }}</td>
            <td>{{ $event->type }}</td>
            <td>{{ $event->cost }}</td>
            <td>{{ $event->expected_revenue }}</td>
            <td>{{ $event->actual_revenue }}</td>
        </tr>
        @endforeach
    </table>
    @endif
    <br />

    @if(isset($EV))

    <table class="table table-bordered">
        <tr><th style="text-align:center;">lead</th></tr>
            <tr>
                <th style="text-align:center;">Type</th>
            </tr>
            @foreach($LE as $lead)
            <tr>
                <td style="text-align:center;">{{ $lead->type }}</td>
            </tr>
            @endforeach
        </table>
        @endif



</body>
</html>
