<template>
    <button v-if="deferredPrompt" @onClick="promptInstall">
      Add to home screen
    </button>
  </template>
  
  <script lang="ts">
    export default {
    name: "App",
    data() {
        return {
        deferredPrompt: null
        };
    },
    created() {
        window.addEventListener("beforeinstallprompt", (e) => {
        e.preventDefault();
        // Stash the event so it can be triggered later.
        this.deferredPrompt = e;
        });
    },
    methods: {
        async install() {
        this.deferredPrompt.prompt();
        }
    }
    };
  </script>