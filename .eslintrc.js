module.exports = {
    env: {
        browser: true,
        es2021: true,
        jquery: true,
    },
    extends: "eslint:recommended",
    parserOptions: {
        ecmaVersion: 12,
        sourceType: "module",
    },
    rules: {
        // Allow undefined variables (for Laravel Blade)
        "no-undef": "off",
        // Allow unused variables
        "no-unused-vars": "warn",
    },
    globals: {
        Chart: "readonly",
        Alpine: "readonly",
        "@json": "readonly",
        "@if": "readonly",
        "@endif": "readonly",
        "@php": "readonly",
        "@endphp": "readonly",
    },
    ignorePatterns: ["**/*.blade.php", "vendor/**", "node_modules/**"],
};
