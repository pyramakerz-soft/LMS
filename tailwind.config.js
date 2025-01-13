/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
<<<<<<< HEAD
<<<<<<< HEAD
        "./resources/**/*.js",
        "./resources/**/*.vue",
        // "./src/**/*.{html , js, jsx, ts , tsx}",
=======
        "./resources/**/*.{html , js , jsx , tsx, ts}",
        "./resources/**/*.vue",
>>>>>>> c5b5c4e (edit chat)
=======
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./src/**/*.{html , js, jsx, ts , tsx}",
>>>>>>> d32742d (edit chat)
    ],
    theme: {
        extend: {
            fontFamily: {
                poppins: ["Poppins", "sans-serif"],
            },
        },
    },
    plugins: [],
};
