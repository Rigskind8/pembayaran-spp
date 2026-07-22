<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Student Details</h1>
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>NIS:</strong> {{ $student->nis }}</p>
        <p><strong>Class ID:</strong> {{ $student->class_id }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <a href="{{ route('students.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded mt-4 inline-block">Back to Students</a>
    </div>
</body>
</html>