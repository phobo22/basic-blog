<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/sidebar.css">
    <link rel="stylesheet" href="../css/todolist.css">
    <title>To Do List</title>
</head>
<body>
    <?php require_once "./sidebar.php";?>
    <main class="content">
        <h1 id="add-title">Add you task here</h1>
        <div class="form-container">
            <form id="add-task-form" method="POST">
                <label>Title: <input type="text" name="taskTitle" id="taskTitle"></label>
                <label>Description: <textarea rows=5 cols=40 name="taskDescription"></textarea></label>
                <label>Start Date: <input type="date" name="taskStartDate"></label>
                <label>End Date: <input type="date" name="taskEndDate"></label>
                <div>
                    <button type="submit" id="add-btn" name="add" value="add">Add</button><span id="add-msg-display"></span>
                </div>
            </form>

            <form id="update-task-form" method="PUT" style="display:none"></form>
        </div>

        <h1 id="task-title">Your task here</h1>
        <p id="task-msg-display"></p>
        <div class="tasks-container"></div>    
    </main>
    <script src="../js/todolist.js"></script>
</body>
</html>

