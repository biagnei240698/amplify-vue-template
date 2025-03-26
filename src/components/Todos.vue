<script setup lang="ts">
import '@/assets/main.css';
import { onMounted, ref } from 'vue';
import type { Schema } from '../../amplify/data/resource';
import { generateClient } from 'aws-amplify/data';
const title = ref("")
const fecha = ref("")
const tipoEvento = ref("") 
const lugar = ref("")
const nombreEvento = ref("")
const client = generateClient<Schema>();

// create a reactive reference to the array of todos
const todos = ref<Array<Schema['Todo']["type"]>>([]);

function listTodos() {
  client.models.Todo.observeQuery().subscribe({
    next: ({ items, isSynced }) => {
      todos.value = items
     },
  }); 
}

function createTodo() {
  client.models.Todo.create({
    /*
    content: window.prompt("Todo content"),
    dateEvent: window.prompt("Todo content"),
    typeEvent: window.prompt("Todo content"),
    */
    content: title.value,
    dateEvent: fecha.value,
    typeEvent: tipoEvento.value
  }).then(() => {
    // After creating a new todo, update the list of todos
    listTodos();
   // alert(title.value + " | " + fecha.value + " | " + tipoEvento.value + " | " + lugar.value + " | " + nombreEvento.value)
  });
}

// delete function
function deleteTodo(id: string) {
    client.models.Todo.delete({ id })
  }
// fetch todos when the component is mounted
 onMounted(() => {
  listTodos();
});

</script>

<template>
  <main>
    <h1>Registrar evento</h1>
        <input v-model="title" placeholder="Evento" />
        <Input v-model="fecha" placeholder="fecha"/>
        <Input v-model="tipoEvento" placeholder="tipoEvento"/>
        <Input v-model="lugar" placeholder="lugar"/>
        <Input v-model="nombreEvento" placeholder="nombreEvento"/>
    <button @click="createTodo">Guardar</button>
    <h1>Mis eventos</h1>
    <ul>
      <li 
        v-for="todo in todos" 
        :key="todo.id"
        @click="deleteTodo(todo.id)"
        >
        {{ todo.id }} {{ todo.dateEvent }} {{ todo.typeEvent }} {{ todo.content }}
      </li>
    </ul>
    <!--
    <div>
      <a href="https://docs.amplify.aws/gen2/start/quickstart/nextjs-pages-router/">
        Review next steps of this tutorial.
      </a>
    </div>
    -->
  </main>
</template>
