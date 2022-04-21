const path = require("path");

module.exports = {
  mode: "production",
  entry: {
    index: "./src/js/index.js",
    print: "./src/js/print.js",
  },
  devtool: "source-map",
  output: {
    filename: "[name].min.js",
    path: path.resolve(__dirname, "dist/js"),
    clean: true,
  },
  module: {
    rules: [
      {
        test: /\.css$/i,
        use: [
          "style-loader",
          "css-loader",
        ],
      },
    ],
  },
};
