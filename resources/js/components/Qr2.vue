<template>
    <button v-if="deferredPrompt" @onClick="promptInstall">
      Add to home screen
    </button>
  </template>
  
  <script lang="ts">
    import { Component, Vue } from "vue-property-decorator";
    import { BeforeInstallPromptEvent } from "vue-pwa-install";
  
    @Component({})
    export default class App extends Vue {
      deferredPrompt: BeforeInstallPromptEvent | void;
  
      promptInstall() {
        // Show the prompt:
        this.deferredPrompt.prompt();
  
        // Wait for the user to respond to the prompt:
        this.deferredPrompt.userChoice.then((choiceResult) => {
          if (choiceResult.outcome === "accepted") {
            console.log("User accepted the install prompt");
          } else {
            console.log("User dismissed the install prompt");
          }
  
          this.deferredPrompt = null;
        });
      }
  
      created() {
        this.$on("canInstall", (event: BeforeInstallPromptEvent) => {
          // Prevent Chrome 67 and earlier from automatically showing the prompt:
          event.preventDefault();
  
          // Stash the event so it can be triggered later:
          this.deferredPrompt = event;
        });
      }
    }
  </script>