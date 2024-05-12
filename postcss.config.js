module.exports = {
    plugins: {
        tailwindcss: {},
        autoprefixer: {},
    },
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue'
    ]
};
