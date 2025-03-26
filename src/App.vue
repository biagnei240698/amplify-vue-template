<script setup lang="ts">
import {ref} from "vue"
import { Authenticator } from "@aws-amplify/ui-vue"
import "@aws-amplify/ui-vue/styles.css"
import Todos from './components/Todos.vue'
const message = ref("")
const fecha = ref("")
const tipoEvento = ref("") 
const lugar = ref("")
const nombreEvento = ref("")
const Baggins = ref("")



function alerttext(){
  alert (message.value)
}
</script>

<template>
  <main>
    <authenticator>
      <template v-slot="{ user, signOut }">
        <h1>GoFest > hola {{user?.signInDetails?.loginId}}'s</h1>
        <Todos />
        <!--
        <p>Message is: {{ message }}  {{ fecha }}</p>
        <input v-model="message" placeholder="edit me" />
        <Input v-model="fecha" placeholder="fecha"/>
        <Input v-model="tipoEvento" placeholder="tipoEvento"/>
        <Input v-model="lugar" placeholder="lugar"/>
        <Input v-model="nombreEvento" placeholder="nombreEvento"/>
        <Input v-model="Baggins" placeholder="Baggins"/>
        <button @click="alerttext">Alert</button>
        -->
        <button @click="signOut">Cerrar sesión</button>
        
      </template>
    </authenticator>
  </main>
</template>

