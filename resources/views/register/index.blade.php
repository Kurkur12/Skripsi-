<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-container {
            display: none;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }

        .show {
            display: block;
        }

        form {
            display: grid;
            gap: 15px;
            max-width: 500px;
        }

        label {
            font-weight: bold;
        }

        input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover {
            background-color: #45a049;
        }

        #addBtn {
            margin-bottom: 20px;
            background-color: #2196F3;
        }

        #addBtn:hover {
            background-color: #1976D2;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            display: none;
        }
    </style>
</head>
<body>
    <div>
        <h2>Menu Register</h2>
        <button id="addBtn">+ Add New Item</button>
        <div id="successMessage" class="success-message">Data berhasil ditambahkan!</div>
        <div id="formContainer" class="form-container">
            <form id="registerForm">
                <div>
                    <label for="code">Kode Barang:</label>
                    <input type="text" id="code" name="code" required>
                </div>
                <div>
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="condition">Kondisi:</label>
                    <input type="text" id="condition" name="condition" required>
                </div>
                <div>
                    <label for="quantity">Jumlah:</label>
                    <input type="number" id="quantity" name="quantity" required>
                </div>
                <div>
                    <label for="date_of_entry">Date of Entry:</label>
                    <input type="date" id="date_of_entry" name="date_of_entry" required>
                </div>
                <button type="submit">Submit</button>
            </form>
            <a href="{{ route('index') }}" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Back to Home</a>
        </div>
    </div>

    <table>
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
        <tbody id="dataTable">
            <!-- Data akan ditampilkan di sini -->
        </tbody>
    </table>

    <script>
        let currentId = 1;
        const successMessage = document.getElementById('successMessage');

        document.getElementById('addBtn').addEventListener('click', function() {
            const formContainer = document.getElementById('formContainer');
            formContainer.classList.toggle('show');
            if (!formContainer.classList.contains('show')) {
                resetForm();
            }
        });

        document.getElementById('registerForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const data = {
                code: document.getElementById('code').value,
                name: document.getElementById('name').value,
                condition: document.getElementById('condition').value,
                quantity: document.getElementById('quantity').value,
                date_of_entry: document.getElementById('date_of_entry').value,
            };

            addRowToTable(data);
            resetForm();
            
            // Show success message
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);

            // Hide form after submission
            document.getElementById('formContainer').classList.remove('show');
        });

        function addRowToTable(data) {
            const table = document.getElementById('dataTable');
            const row = table.insertRow(0); // Insert at the top
            row.insertCell(0).innerText = currentId++;
            row.insertCell(1).innerText = data.code;
            row.insertCell(2).innerText = data.name;
            row.insertCell(3).innerText = data.condition;
            row.insertCell(4).innerText = data.quantity;
            row.insertCell(5).innerText = formatDate(data.date_of_entry);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function resetForm() {
            document.getElementById('registerForm').reset();
        }
    </script>
</body>
</html>