async function addTask() {
  const taskInput = document.getElementById("taskInput");
  const task = taskInput.value.trim(); // Ensure task input is trimmed of whitespace

  if (task) {
    try {
      const response = await fetch("../add_task.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ 'task': task }), // Send task as JSON
      });

      if (!response.ok) {
        throw new Error("Network response was not ok.");
      }

      const tasks = await response.json();
      displayTasks(tasks);
      taskInput.value = ""; // Clear input after successful addition
    } catch (error) {
      console.error("Fetch error:", error);
      // Handle error appropriately
    }
  } else {
    console.error("Task input is empty.");
    // Provide feedback to the user that task input is required
  }
}

async function deleteTask(index) {
  const response = await fetch("../delete_task.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ index }),
  });

  const tasks = await response.json();
  displayTasks(tasks);
}

async function fetchTasks() {
  const response = await fetch("../tasks.php");
  const tasks = await response.json();
  displayTasks(tasks);
}

function displayTasks(tasks) {
  const taskList = document.getElementById("taskList");
  taskList.innerHTML = "";

  tasks.forEach((task, index) => {
    const li = document.createElement("li");
    li.textContent = task.description;
    li.appendChild(createDeleteButton(index));
    taskList.appendChild(li);
  });
}

function createDeleteButton(index) {
  const button = document.createElement("button");
  button.textContent = "Delete";
  button.onclick = () => deleteTask(index);
  return button;
}

document.addEventListener("DOMContentLoaded", fetchTasks);
