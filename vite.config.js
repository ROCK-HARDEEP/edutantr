import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

function tryGetHostnameFromUrl(value) {
    if (!value) return undefined;
    try {
        return new URL(value).hostname;
    } catch {
        return undefined;
    }
}

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), "");

    // Browser requests your Laravel page from some external IP; if Vite's HMR URL
    // points at loopback (`localhost`/`::1`), browsers can block it with PNA/CORS rules.
    const hmrHost =
        env.VITE_HMR_HOST ||
        tryGetHostnameFromUrl(env.VITE_APP_URL) ||
        tryGetHostnameFromUrl(env.APP_URL) ||
        "127.0.0.1";

    return {
        plugins: [
            laravel({
                input: ["resources/style/app.scss", "resources/js/app.js"],
                refresh: true,
            }),
            vue(),
        ],
        server: {
            host: hmrHost,
            hmr: { host: hmrHost },
            port: env.VITE_PORT ? Number(env.VITE_PORT) : 5173,
            strictPort: true,
        },
        resolve: {
            alias: {
                "@": "/resources/js",
            },
        },
    };
});
