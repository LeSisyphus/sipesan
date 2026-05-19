/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    theme: {
        extend: {

            colors: {
                primary: "#0058bc",
                secondary: "#4c4aca",
                tertiary: "#595c60",
                error: "#ba1a1a",

                "on-surface": "#121c2a",
                "on-surface-variant": "#414755",

                "surface": "#f8f9ff",
                "surface-container": "#e6eeff",
                "surface-container-high": "#dee9fc",
                "surface-container-highest": "#d9e3f6",
                "surface-container-low": "#eff4ff",
                "surface-container-lowest": "#ffffff",

                "outline": "#717786",
                "outline-variant": "#c1c6d7",

                "primary-container": "#0070eb",
                "secondary-container": "#6664e4",
                "tertiary-container": "#727578",

                "error-container": "#ffdad6",
                "on-error-container": "#93000a",
            },

            spacing: {
                xs: "4px",
                sm: "8px",
                md: "16px",
                lg: "24px",
                xl: "48px",
            },

            fontFamily: {
                h1: ["Poppins"],
                h2: ["Poppins"],
                h3: ["Poppins"],
                body: ["Poppins"],
                label: ["Poppins"],
            },

            fontSize: {
                h1: ["48px", {
                    lineHeight: "1.2",
                    letterSpacing: "-0.02em",
                    fontWeight: "600",
                }],

                h2: ["32px", {
                    lineHeight: "1.25",
                    letterSpacing: "-0.01em",
                    fontWeight: "600",
                }],

                h3: ["24px", {
                    lineHeight: "1.3",
                    fontWeight: "500",
                }],

                "body-md": ["16px", {
                    lineHeight: "1.5",
                    fontWeight: "400",
                }],

                "label-sm": ["14px", {
                    lineHeight: "1.2",
                    letterSpacing: "0.02em",
                    fontWeight: "500",
                }],
            },

            borderRadius: {
                xl: "0.75rem",
                "2xl": "1.5rem",
            },
        },
    },

    plugins: [],
}