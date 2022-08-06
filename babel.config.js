module.exports = {
    presets: ["@babel/preset-env", ["@babel/preset-react", {runtime: "automatic"}]],
    plugins: [
        [
            require.resolve("babel-plugin-module-resolver"),
            {
                root: ["./resources/js/"],
                extensions: [".ts", ".tsx", ".js"],
                alias: {
                    "@": "./",
                    "@classified": "./resources/js/classified",
                    "@thikana": "./thikana",
                },
            },
        ],
        "jest-hoist",
    ],
};
