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

    <table class="table table-bordered">
    <tr><th>Import</th></tr>
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Total Amount</th>
            <th>Employee</th>
            <th>Supplier</th>
        </tr>
        <tr>
            <td>{{ $import->import_name }}</td>
            <td>{{ $import->date }}</td>
            <td>{{ $import->total_amount }}</td>
            <td>{{ $import->employee_name }}</td>
            <td>{{ $import->supplier_name }}</td>
        </tr>
    </table>
    <br />

    <table class="table table-bordered">
    <tr><th>Products</th></tr>
        <tr>
            <th>Name</th>
            <th>Details</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Amount</th>

        </tr>
        @foreach($import_product as $products)
        <tr>
            <td>{{ $products->product_name }}</td>
            <?php $detailsObject = json_decode($products->details); ?>
            <td>
            @foreach ($detailsObject as $key => $value)
                {{ $key }}: {{ $value }}<br />
            @endforeach
        </td>
            <td>{{ $products->price }}</td>
            <td>{{ $products->quantity }}</td>
            <td>{{ $products->total_amount }}</td>
        </tr>
        @endforeach
    </table>

</body>
</html>
