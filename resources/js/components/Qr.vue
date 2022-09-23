<template>
    <button @click="install">install</button>
  </template>
  
  <script>
    export default {
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