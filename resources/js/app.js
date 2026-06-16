import "./bootstrap";
import "bootstrap/dist/js/bootstrap.min.js";
import "animate.css";
import "/resources/style/tailwind.css";

import VueAwesomePaginate from "vue-awesome-paginate";
import { createApp } from "vue";
import App from "./App.vue";
import vReveal from "./directives/vReveal.js";
import localization from "./localization.js";
import router from "./router";
import { createPinia } from "pinia";
import piniaPersist from "pinia-plugin-persistedstate";

// PrimeVue
import PrimeVue from "primevue/config";
import Aura from "@primevue/themes/aura";

const app = createApp(App);
const pinia = createPinia();
app.use(pinia);

localization.fetchLocalizationData();

app.use(localization.i18n);
app.use(router);
pinia.use(piniaPersist);
app.use(VueAwesomePaginate);

// PrimeVue with Aura theme
app.use(PrimeVue, {
    theme: {
        preset: Aura,
        options: {
            darkModeSelector: ".dark-mode",
        },
    },
    ripple: true,
});

// Register scroll-reveal directive globally
app.directive("reveal", vReveal);

app.mount("#app");
