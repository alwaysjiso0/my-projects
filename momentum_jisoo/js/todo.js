const toDoForm = document.getElementById("todo-form");
const toDoInput = toDoForm.querySelector("input");
const toDoList = document.getElementById("todo-list");

let toDos = [];
const TODOS_KEYS = "todos";

function saveToDos() {
  localStorage.setItem(TODOS_KEYS, JSON.stringify(toDos));
}

function deleteToDo(e) {
  const li = e.target.parentElement;
  li.remove();
  toDos = toDos.filter(item => item.id !== parseInt(li.id));
  saveToDos();
}

function editToDo(e) {
  const li = e.target.parentElement;
  
  const form = document.createElement("form");
  const input = document.createElement("input");
  input.classList.add("editting");
  const span = li.querySelector("span");
  span.classList.add("hidden");
  form.appendChild(input);
  li.appendChild(form);

  form.addEventListener('submit', handleEdit);
}

function handleEdit(e) {
  e.preventDefault();

  const li = e.target.parentElement;
  const span = li.querySelector("span");
  const input = li.querySelector("input");
  const form = li.querySelector("form");
  const newText = input.value;
  const id = li.id;
  const numId = parseInt(id);

  form.remove();
  span.classList.remove("hidden");

  const savedToDos = localStorage.getItem(TODOS_KEYS);
  const parsedToDos = JSON.parse(savedToDos);
  for (var i = 0; i < parsedToDos.length; i++) {
    if (parsedToDos[i].id === numId) {
      const changingDict = parsedToDos[i];
      changingDict["text"] = newText;

      console.log(changingDict);
    }
  }

  toDos = parsedToDos;
  localStorage.setItem(TODOS_KEYS, JSON.stringify(parsedToDos));

  window.location.reload();
}

function paintToDo(newTodo) {
  const li = document.createElement("li");
  li.id = newTodo.id;
  const span = document.createElement("span");
  span.innerText = newTodo.text;
  const editButton = document.createElement("button");
  editButton.innerText = "✏️";
  const deleteButton = document.createElement("button");
  deleteButton.innerText = "❌";
  deleteButton.addEventListener("click", deleteToDo);
  editButton.addEventListener("click", editToDo);
  li.appendChild(deleteButton);
  li.appendChild(editButton);
  li.appendChild(span);
  toDoList.appendChild(li);
}

function handleToDoSubmit(e) {
  e.preventDefault();
  const newTodo = toDoInput.value;
  toDoInput.value = '';
  const newToDoObj = {
    text: newTodo,
    id: Date.now() // random number 생성
  };
  toDos.push(newToDoObj);
  paintToDo(newToDoObj);
  saveToDos();
}

toDoForm.addEventListener('submit', handleToDoSubmit);
const savedToDos = localStorage.getItem(TODOS_KEYS);

if(savedToDos !== null) {
  const parsedToDos = JSON.parse(savedToDos);
  toDos = parsedToDos;
  // function의 줄임 표현 arrow function
  parsedToDos.forEach(paintToDo); //iterating through the array
}






