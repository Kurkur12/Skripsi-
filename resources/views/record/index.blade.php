<!-- resources/views/record/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record List</title>
    <style>
        .hidden { display: none; }
        .fade { transition: opacity 0.5s; }
    </style>
</head>
<body>

<h1>Records</h1>
<button id="addItemButton">Add Item</button>

<div id="addItemForm" class="hidden fade">
    <h2>Add New Record</h2>
    <form action="{{ route('record.store') }}" method="POST">
        @csrf
        <label for="code">Code:</label>
        <select name="code" id="code" required>
            @foreach($items as $item)
                <option value="{{ $item->code }}">{{ $item->code }} - {{ $item->name }}</option>
            @endforeach
        </select><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="condition">Condition:</label>
        <input type="text" name="condition" required><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>

        <button type="submit">Submit</button>
        <button type="button" id="cancelButton">Cancel</button>
    </form>
</div>

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Name</th>
            <th>Condition</th>
            <th>Quantity</th>
            <th>Date of Entry</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $record)
        <tr>
            <td>{{ $record->id }}</td>
            <td>{{ $record->code }}</td>
            <td>{{ $record->name }}</td>
            <td>{{ $record->condition }}</td>
            <td>{{ $record->quantity }}</td>
            <td>{{ $record->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    document.getElementById('addItemButton').addEventListener('click', function() {
        const form = document.getElementById('addItemForm');
        form.classList.toggle('hidden');
        form.style.opacity = form.classList.contains('hidden') ? '0' : '1';
    });

    document.getElementById('cancelButton').addEventListener('click', function() {
        const form = document.getElementById('addItemForm');
        form.classList.add('hidden');
        form.style.opacity = '0';
    });
</script>

</body>
</html>
