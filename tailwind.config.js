const defaultTheme = require('tailwindcss/defaultTheme');


// Custom color with css variable color in __theme_color.scss
function customColors(cssVar) {
  return ({ opacityVariable, opacityValue }) => {
    if (opacityValue !== undefined) {
      return `rgba(var(${cssVar}), ${opacityValue})`;
    }
    if (opacityVariable !== undefined) {
      return `rgba(var(${cssVar}), var(${opacityVariable}, 1))`;
    }
    return `rgb(var(${cssVar}))`;
  };
}


/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.jsx",
        "./resources/**/*.tsx",
    ],

    darkMode: "class", // or 'media' or 'class',

    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "1rem",
                "2xl": "128px",
            },
        },
        fontFamily: {
            // display: ["var(--font-display)", ...defaultTheme.fontFamily.sans],
            // body: ["var(--font-body)", ...defaultTheme.fontFamily.sans],
            display: ["var(--font-display)", "Soleil"],
            body: ["var(--font-body)", "Soleil"],
        },
        extend: {
            fontFamily: {
                // sans: ["Soleil", ...defaultTheme.fontFamily.sans],
                sans: ["Soleil"],
            },
            colors: {
                primary: {
                    50: customColors("--c-primary-50"),
                    100: customColors("--c-primary-100"),
                    200: customColors("--c-primary-200"),
                    300: customColors("--c-primary-300"),
                    400: customColors("--c-primary-400"),
                    500: customColors("--c-primary-500"),
                    6000: customColors("--c-primary-600"),
                    700: customColors("--c-primary-700"),
                    800: customColors("--c-primary-800"),
                    900: customColors("--c-primary-900"),
                },
                secondary: {
                    50: customColors("--c-secondary-50"),
                    100: customColors("--c-secondary-100"),
                    200: customColors("--c-secondary-200"),
                    300: customColors("--c-secondary-300"),
                    400: customColors("--c-secondary-400"),
                    500: customColors("--c-secondary-500"),
                    6000: customColors("--c-secondary-600"),
                    700: customColors("--c-secondary-700"),
                    800: customColors("--c-secondary-800"),
                    900: customColors("--c-secondary-900"),
                },
                neutral: {
                    50: customColors("--c-neutral-50"),
                    100: customColors("--c-neutral-100"),
                    200: customColors("--c-neutral-200"),
                    300: customColors("--c-neutral-300"),
                    400: customColors("--c-neutral-400"),
                    500: customColors("--c-neutral-500"),
                    6000: customColors("--c-neutral-600"),
                    700: customColors("--c-neutral-700"),
                    800: customColors("--c-neutral-800"),
                    900: customColors("--c-neutral-900"),
                },
                pest: {
                    rose: "#d23359",
                    violet: "#a03496",
                    purple: "#7e35c4",
                    cyprus: "#102e52",
                    aliceblue: "#e7f3ff",
                    search: {
                        purple: "#6E36D9",
                        rose: "#D33254",
                    },
                    icon: {
                        purple: "#9047B2",
                    },
                    badge: {
                        lightpink: "#F0E0F9",
                    },
                },
            },
            spacing: {
                pestcard: "540px",
                container_lg: "15rem",
                container_md: "15rem",
                container_sm: "1rem",
                container_others: "1rem",
            },
            backgroundImage: {
                banner: "url('/images/banner-animate.png'), linear-gradient(to right, #7e35c4, #be185d)",
                atoz: "url('/images/A-Z.png')",
                location: "url('/images/location_icon.png')",
                bpca_transparent: "url('/images/bpca_logo_transparent.png')",
            },
        },
    },

    variants: {
        extend: {
            animation: {
                "spin-slow": "spin 3s linear infinite",
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@tailwindcss/line-clamp"),
        require("@tailwindcss/aspect-ratio"),
        require("@tailwindcss/line-clamp"),
    ],
};
