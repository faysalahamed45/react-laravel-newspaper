module.exports = {
    "root": true,
    "env": {
        "browser": true,
        "es2021": true,
        "jest": true,
        "amd": true,
        "node": true,
    },
    "extends": ["eslint:recommended", "plugin:react/recommended"],
    "settings": {
        "react": {
            "version": "detect",
        },
    },
    "parserOptions": {
        "ecmaFeatures": {
            "jsx": true,
        },
        "ecmaVersion": "latest",
        "sourceType": "module",
    },
    "plugins": ["react"],
    "rules": {
        "indent": ["error", 4],
        "semi": ["error", "always"],
        // "quote-props": ["error", "always"],
        "no-mixed-spaces-and-tabs": ["error", "smart-tabs"],
        "padding-line-between-statements": ["error", {blankLine: "always", prev: "*", next: "return"}],
        "no-unused-vars": "off",
        // "space-before-function-paren": ["error", "always"],
        "react/prop-types": "off",
        "react/react-in-jsx-scope": "off",
    },
    "globals": {
        "baseUrl": "readonly",
        "$": "readonly",
    },
};
