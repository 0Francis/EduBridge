// Simple CRUD demo using localStorage
const form = document.getElementById("opportunity-form");
const listEl = document.getElementById("opportunities-list");
const formTitle = document.getElementById("form-title");
const cancelBtn = document.getElementById("cancel-btn");

// Helpers
function uid() {
  return "op_" + Date.now() + "_" + Math.floor(Math.random() * 1000);
}

function readForm() {
  return {
    id: document.getElementById("op-id").value || uid(),
    title: document.getElementById("title").value.trim(),
    description: document.getElementById("description").value.trim(),
    requirements: document
      .getElementById("requirements")
      .value.split(",")
      .map((s) => s.trim())
      .filter(Boolean),
    location: document.getElementById("location").value.trim(),
    deadline: document.getElementById("deadline").value || null,
    contact: document.getElementById("contact").value.trim(),
    created: new Date().toISOString(),
  };
}

function saveToStorage(items) {
  localStorage.setItem("edubridge_ops", JSON.stringify(items));
}

function loadFromStorage() {
  return JSON.parse(localStorage.getItem("edubridge_ops") || "[]");
}

function resetForm() {
  form.reset();
  document.getElementById("op-id").value = "";
  formTitle.textContent = "Create Opportunity";
}

function renderList() {
  const items = loadFromStorage();
  listEl.innerHTML = "";
  if (items.length === 0) {
    listEl.innerHTML = "<p>No opportunities yet.</p>";
    return;
  }

  items
    .slice()
    .reverse()
    .forEach((item) => {
      const card = document.createElement("div");
      card.className = "card";

      const h = document.createElement("h3");
      h.textContent = item.title;

      const p = document.createElement("p");
      p.textContent = item.description;

      const meta = document.createElement("div");
      meta.className = "meta";
      meta.textContent = `${item.location || "Remote/Not set"} • Deadline: ${
        item.deadline || "Open"
      }`;

      const req = document.createElement("div");
      req.textContent = item.requirements.length
        ? "Skills: " + item.requirements.join(", ")
        : "";

      const contact = document.createElement("div");
      contact.className = "meta";
      contact.textContent = `Contact: ${item.contact}`;

      const actions = document.createElement("div");
      actions.className = "actions";

      const editBtn = document.createElement("button");
      editBtn.textContent = "Edit";

      const delBtn = document.createElement("button");
      delBtn.textContent = "Delete";
      delBtn.className = "secondary";

      editBtn.addEventListener("click", () => {
        populateForm(item);
      });

      delBtn.addEventListener("click", () => {
        if (confirm("Delete this opportunity?")) deleteItem(item.id);
      });

      actions.appendChild(editBtn);
      actions.appendChild(delBtn);

      card.appendChild(h);
      card.appendChild(meta);
      card.appendChild(p);
      if (req.textContent) card.appendChild(req);
      card.appendChild(contact);
      card.appendChild(actions);

      listEl.appendChild(card);
    });
}

function addItem(item) {
  const items = loadFromStorage();
  const exists = items.findIndex((i) => i.id === item.id);
  if (exists >= 0) {
    items[exists] = item;
  } else {
    items.push(item);
  }
  saveToStorage(items);
  renderList();
}

function deleteItem(id) {
  let items = loadFromStorage();
  items = items.filter((i) => i.id !== id);
  saveToStorage(items);
  renderList();
}

function populateForm(item) {
  document.getElementById("op-id").value = item.id;
  document.getElementById("title").value = item.title;
  document.getElementById("description").value = item.description;
  document.getElementById("requirements").value = item.requirements.join(", ");
  document.getElementById("location").value = item.location;
  document.getElementById("deadline").value = item.deadline || "";
  document.getElementById("contact").value = item.contact;
  formTitle.textContent = "Edit Opportunity";
}

form.addEventListener("submit", (e) => {
  e.preventDefault();
  const data = readForm();
  if (!data.title || !data.contact) {
    alert("Title and contact email are required");
    return;
  }
  addItem(data);
  resetForm();
});

cancelBtn.addEventListener("click", () => {
  resetForm();
});

// Initialize
renderList();
