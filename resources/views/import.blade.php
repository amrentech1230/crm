<!DOCTYPE html>
<html>
<head>
    <title>Update Loads Data</title>
</head>
<body>
    <h2>Update Loads Table from Excel</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('loads.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Select Excel File:</label>
        <input type="file" name="file" required>
        <button type="submit">Upload & Update</button>
    </form>
</body>
</html>
