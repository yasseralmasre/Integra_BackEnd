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
<head>

</head>
<body>
    <h1>{{ $title }}</h1>
    <p>{{ $date }}</p>


    <table >
    <tr><th>Employee Vacation</th></tr>
        <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Type Of Vacation</th>
            <th>Reason Of Vacation</th>
            <th>Employee Name</th>

        </tr>

        if(isset($EP))
        @foreach($EP as $employeeVacation)
        <tr>
            <td>{{ $employeeVacation->startDate }}</td>
            <td>{{ $employeeVacation->endDate }}</td>
            <td>{{ $employeeVacation->typeOfVacation }}</td>
            <td>{{ $employeeVacation->reasonOfVacation }}</td>
            <td>{{ $employee->firstName }}</td>

        </tr>
        @endforeach
    </table>


</body>
</html>
