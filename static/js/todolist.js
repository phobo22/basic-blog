const addTaskForm = document.getElementById("add-task-form");
const addMsgDisplay = document.getElementById("add-msg-display");
const taskDisplay = document.querySelector(".tasks-container");
const taskMsgDisplay = document.getElementById("task-msg-display");
const updateTaskForm = document.getElementById("update-task-form");
let updateMsgForm;

async function deleteTask(taskId) {
    const response = await fetch(`../../src/todolist/delete_task.php?id=${taskId}`, {
        method: "DELETE",
    })

    if (!response.ok) {
        throw new Error("Error when calling delete task API");
    }
    return response.json();
}

async function getTask(taskId) {
    const response = await fetch(`../../src/todolist/get_task.php?id=${taskId}`, {
        method: "GET",
    })

    if (!response.ok) {
        throw new Error("Error when get task from calling update task API");
    }
    
    return response.json();
}

function displayUpdateTask(task) {
    updateTaskForm.innerHTML = `
        <input type="hidden" name="taskId" value=${task["id"]}>
        <label>Title: <input type="text" name="taskTitle" id="taskTitle" value=${task["title"]}></label>
        <label>Description: <textarea rows=5 cols=40 name="taskDescription">${task["descriptions"]}</textarea></label>
        <label>Start Date: <input type="date" name="taskStartDate" value=${task["start_date"]}></label>
        <label>End Date: <input type="date" name="taskEndDate" value=${task["end_date"]}></label>
        <div>
            <button type="submit" id="submit-update-btn" name="update" value="update">Update</button>
            <button class="discard-btn" name="discard" value="discard">Discard</button><span id="update-msg-display"></span>
        </div>
    `;
    updateMsgForm = document.getElementById("update-msg-display");
    updateTaskForm.style.display = "flex";
}

async function updateTask(taskId) {
    const response = await getTask(taskId);
    const data = response["data"];
    displayUpdateTask(data);
}

async function displayTask() {
    const response = await fetch("../../src/todolist/get_task.php", {
        method: "GET",
    })

    if (!response.ok) {
        throw new Error("Error when calling get task API");
    }

    const data = await response.json();
    if (data["success"] === false) {
        taskMsgDisplay.innerText = data["msg"];
    } else {
        if (data["data"].length === 0) {
            taskDisplay.innerText = "";
            taskMsgDisplay.innerText = "You do not have any tasks";
        } else {
            taskDisplay.innerHTML = "";
            data["data"].forEach(task => {
                taskDisplay.innerHTML += `
                    <div class="task-container">
                        <p><span>Title: </span>${task["title"]}</p>
                        <p><span>Description: </span>${task["descriptions"]}</p>
                        <p><span>Start: </span>${task["start_date"]}</p>
                        <p><span>End: </span>${task["end_date"]}</p>
                        <div>
                            <button class="update-btn" value="${task["id"]}">Update</button>
                            <button class="delete-btn" value="${task["id"]}">Delete</button>
                        </div>
                    </div>
                `;
            })
        }
    }
}

addTaskForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    try {
        const formData = new FormData(addTaskForm);
        const params = new URLSearchParams(formData);
        const response = await fetch("../../src/todolist/add_task.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: params.toString(),
        })

        if (!response.ok) {
            throw new Error("Error when calling add task API");
        }

        const data = await response.json();
        addMsgDisplay.innerText = data["msg"];
        addMsgDisplay.style.color = "color:rgb(221, 29, 67)";

        if (data["success"] === true) {
            taskMsgDisplay.innerText = "";
            displayTask();
            addMsgDisplay.style.color = "green";
        }
    } catch (error) {
        addMsgDisplay.innerText = error;
    }
})

updateTaskForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    try {
        const formData = new FormData(updateTaskForm);
        const params = new URLSearchParams(formData);
        const response = await fetch("../../src/todolist/update_task.php", {
            method: "PUT",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: params.toString(),
        })

        if (!response.ok) {
            throw new Error("Error when calling add task API");
        }

        const data = await response.json();
        if (data["success"] === false) {
            updateMsgForm.innerText = data["msg"];
        } else {
            updateTaskForm.style.display = "none";
            displayTask();
        }
    } catch (error) {
        console.log(error);
    }
})

updateTaskForm.addEventListener("click", e => {
    if (e.target.classList.contains("discard-btn")) {
        updateTaskForm.innerHTML = "";
        updateTaskForm.style.display = "none";
    }
})

taskDisplay.addEventListener("click", async (e) => {
    if (e.target.classList.contains("delete-btn")) {
        const taskId = e.target.value;
        try {
            const successDelete = await deleteTask(taskId);
            if (successDelete["success"] === true) {
                displayTask();
            }
            else taskMsgDisplay.innerText = "Error when deleting task";
        } catch (error) {
            taskMsgDisplay.innerText = error;
        }
    }

    if (e.target.classList.contains("update-btn")) {
        const taskId = e.target.value;
        updateTask(taskId);
    }
})

try {
    displayTask();
} catch (error) {
    taskMsgDisplay.innerText = error;
}



