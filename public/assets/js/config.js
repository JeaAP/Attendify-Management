// const BASE_URL = "https://backend24.site/Rian/XI/attendify/attendify_management/";
const BASE_URL = "/Attendify-Management/";

const CONFIG = {
    ROOT_PATH: "/", // Path root aplikasi (bisa diubah sesuai kebutuhan)
    BASE_URL: BASE_URL, // URL dasar aplikasi
    BASE_PATH: "/Attendify-Management/", // Path dasar proyek
    ASSETS_PATH: BASE_URL + "/public/assets/", // Path untuk assets seperti gambar, CSS, JS
    VIEWS_PATH: BASE_URL + "/app/views/", // Path untuk tampilan (views)
    TEMPLATES_PATH: BASE_URL + "/app/views/templates/" // Path untuk templates
};

// Debugging (Opsional)
// console.log("Config Loaded - BASE_URL:", CONFIG.BASE_URL);

// Menyimpan ke `window.CONFIG` agar bisa diakses secara global
window.CONFIG = CONFIG;

// Ekspor konfigurasi jika menggunakan module JavaScript
// export default CONFIG;