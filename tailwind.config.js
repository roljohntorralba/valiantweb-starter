const colors = require("tailwindcss/colors");

module.exports = {
  darkMode: "class",
  content: ["**/*.{html,php}", "!node_modules/**"],
  theme: {
    extend: {
      colors: {
        primary: colors.lime,
        secondary: colors.fuchsia,
        tertiary: colors.sky,
        neutral: colors.slate,
      },
    },
  },
  plugins: [
    require("@tailwindcss/typography"),
    require("@tailwindcss/forms"),
    require("@tailwindcss/line-clamp"),
    require("@tailwindcss/aspect-ratio"),
  ],
};
