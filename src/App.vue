<script setup lang="ts">
import { Authenticator } from "@aws-amplify/ui-vue";
import "@aws-amplify/ui-vue/styles.css";
import Todos from './components/Todos.vue';
import { Fieldset } from '@aws-amplify/ui-react';

</script>

<template>
  <main>
    <authenticator>
      <template v-slot="{ user, signOut }">
        <h1>Hello {{user?.signInDetails?.loginId}}'s todos</h1>
        <Todos />
        <Input placeholder="evento"/>
        <Input placeholder="fecha"/>
        <Input placeholder="tipoEvento"/>
        <Input placeholder="lugar"/>
        <Input placeholder="nombreEvento"/>
        <Input placeholder="Baggins"/>
        <Input placeholder="Baggins"/>
        <button @click="signOut">Sign Out</button>
      </template>
    </authenticator>
  </main>
</template>

