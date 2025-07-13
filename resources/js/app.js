import "./bootstrap";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

window.Echo.channel("data-channel").listen(".data-updated", (e) => {
    console.log("Data baru:", e.data);
    // Tambahkan logika untuk refresh data
});

flatpickr("#tanggal_awal", {
    dateFormat: "m/d/Y", // mm/dd/yyyy
    allowInput: true,
    defaultDate: "today",
    altInput: true,
    altFormat: "F j, Y",
});
