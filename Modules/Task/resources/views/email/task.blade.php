<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>

<body>
    <h1>Task Management</h1>
    <p>Dear {{ $name }}</p>
    <p>Your task has been created successfully.</p>
    <p>Task Title: {{ $title }}</p>
    <p>Task Description: {{ $description }}</p>
    <p>Task Status: {{ $status }}</p>
    <p>Task Priority: {{ $priority }}</p>
    <p>Task Due Date: {{ $due_date }}</p>

    <p>For more details, please login to your account.</p>

    <p>Thank you</p>
    <p>Task Management</p>
</body>

</html>